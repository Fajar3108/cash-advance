<?php

namespace App\Http\Controllers;

use App\Constants\StatusConstant;
use App\Http\Requests\ReimbursementRequest;
use App\Models\Reimbursement;
use App\Models\ReimbursementItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Database\Seeders\RoleSeeder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ReimbursementController extends Controller
{
    public function index(): View
    {
        $reimbursements = Reimbursement::with('user', 'admin')->orderBy('date', 'DESC');

        if (request()->has('q')) {
            $reimbursements = $reimbursements->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . request('q') . '%');
            });
        }

        if (auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            $reimbursements = $reimbursements->where('user_id', auth()->id());
        }

        $reimbursements = $reimbursements->paginate(10);

        return view('reimbursement.index', compact('reimbursements'));
    }

    public function show(Reimbursement $reimbursement): View
    {
        return view('reimbursement.show', compact('reimbursement'));
    }

    public function create(): View
    {
        $reimbursement = new Reimbursement();
        $reimbursement->date = now()->format('Y-m-d');
        return view('reimbursement.create', compact('reimbursement'));
    }

    public function store(ReimbursementRequest $request): RedirectResponse
    {
        if (empty($request->items)) {
            Alert::error('Error', 'Please add at least one item');
            return back()->withInput($request->except('items'));
        }

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['is_user_signature_showed'] = $request->is_user_signature_showed ? true : false;
        $data['status'] = $request->is_draft ? StatusConstant::DRAFT : StatusConstant::PENDING;

        $items = json_decode($request->items);

        DB::transaction(function () use ($data, $items) {
            $reimbursement = Reimbursement::create($data);

            for ($i = 0; $i < count($items); $i++) {
                $timestamps = now()->addSeconds($i * 3);
                $items[$i] = [
                    'id' => str()->uuid(),
                    'note' => $items[$i]->note,
                    'price' => $items[$i]->price,
                    'date' => $items[$i]->date,
                    'reimbursement_id' => $reimbursement->id,
                    'created_at' => $timestamps,
                    'updated_at' => $timestamps,
                ];
            }

            ReimbursementItem::insert($items);
        });


        Alert::success('Success', 'Reimbursement created successfully');

        return redirect()->route('reimbursements.index');
    }

    public function edit(Reimbursement $reimbursement): View
    {
        $this->authorize('update', $reimbursement);

        return view('reimbursement.edit', compact('reimbursement'));
    }

    public function update(ReimbursementRequest $request, Reimbursement $reimbursement): RedirectResponse
    {
        $this->authorize('update', $reimbursement);

        $data = $request->validated();
        $data['is_user_signature_showed'] = $request->is_user_signature_showed ? true : false;
        $data['status'] = $request->is_draft ? StatusConstant::DRAFT : StatusConstant::PENDING;

        $reimbursement->update($data);

        Alert::success('Success', 'Reimbursement updated successfully');

        return redirect()->route('reimbursements.index');
    }

    public function destroy(Reimbursement $reimbursement): RedirectResponse
    {
        $this->authorize('update', $reimbursement);

        $reimbursement->delete();

        Alert::success('Success', 'Reimbursement deleted successfully');

        return redirect()->route('reimbursements.index');
    }

    public function approve(Reimbursement $reimbursement): RedirectResponse
    {
        $reimbursement->update([
            'status' => StatusConstant::APPROVED,
            'admin_id' => auth()->id(),
            'is_admin_signature_showed' => request()->is_admin_signature_showed ? true : false,
        ]);

        Alert::success('Success', 'Reimbursement approved successfully');

        return back();
    }

    public function note(Reimbursement $reimbursement): RedirectResponse
    {
        $note = request()->note;

        if (empty($note)) {
            Alert::error('Error', 'Note cannot be empty');
            return back();
        }

        $reimbursement->update([
            'note' => $note,
        ]);

        Alert::success('Success', 'Note updated successfully');

        return back();
    }

    public function pdf(Reimbursement $reimbursement)
    {
        $pdf = Pdf::loadView('reimbursement.pdf', compact('reimbursement'));
        return $pdf->stream('reimbursement.pdf');
    }

    public function report(Request $request): View
    {
        $reimbursementsRaw = Reimbursement::with('user', 'admin')->orderBy('date', 'DESC');

        if (request()->has('q')) {
            $reimbursementsRaw = $reimbursementsRaw->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . request('q') . '%');
            });
        } else {
            if ($request->has('requestBy')) {
                $reimbursementsRaw = $reimbursementsRaw->where('user_id', $request->requestBy);
            }

            if ($request->has('startDate')) {
                $reimbursementsRaw = $reimbursementsRaw->where('date', '>=', $request->startDate);
            } else {
                $reimbursementsRaw = $reimbursementsRaw->where('date', '>=', now()->format('Y-m-d'));
            }

            if ($request->has('endDate')) {
                $reimbursementsRaw = $reimbursementsRaw->where('date', '<=', $request->endDate);
            } else {
                $reimbursementsRaw = $reimbursementsRaw->where('date', '<=', now()->format('Y-m-d'));
            }
        }

        $reimbursementsRaw = $reimbursementsRaw->get()->groupBy('user_id');

        $reimbursements = collect();

        $reimbursementsRaw->each(function ($reimbursement) use ($reimbursements) {
            foreach ($reimbursement as $item) {
                $reimbursements->push($item);
            }
        });

        return view('reimbursement.report', compact('reimbursements'));
    }
}
