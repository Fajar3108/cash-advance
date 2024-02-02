<?php

namespace App\Http\Controllers;

use App\Constants\StatusConstant;
use App\Http\Requests\CaUsageRequest;
use App\Models\CashAdvance;
use App\Models\CaUsage;
use Barryvdh\DomPDF\Facade\Pdf;
use Database\Seeders\RoleSeeder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class CaUsageController extends Controller
{
    public function index(): View
    {
        $caUsages = CaUsage::with('user', 'admin')->orderBy('date', 'DESC');

        if (request()->has('q')) {
            $caUsages = $caUsages->where('name', 'like', '%' . request('q') . '%');
        }

        if (auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            $caUsages = $caUsages->where('user_id', auth()->id());
        }

        $caUsages = $caUsages->paginate(10);

        return view('ca-usage.index', compact('caUsages'));
    }

    public function create(): View
    {
        $caUsage = new CaUsage();
        $caUsage->date = now()->format('Y-m-d');

        $cashAdvances = CashAdvance::orderBy('date', 'DESC');

        if (auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            $cashAdvances = $cashAdvances->where('user_id', auth()->id());
        }

        $cashAdvances = $cashAdvances->get();

        return view('ca-usage.create', compact('caUsage', 'cashAdvances'));
    }

    public function store(CaUsageRequest $request)
    {
        if (empty($request->items)) {
            Alert::error('Error', 'Please add at least one item');
            return back()->withInput($request->except('items'));
        }

        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['user_id'] = auth()->id();
            $data['is_user_signature_showed'] = $request->is_user_signature_showed ? true : false;
            $data['status'] = $request->is_draft ? StatusConstant::DRAFT : StatusConstant::PENDING;

            $caUsage = CaUsage::create($data);

            $items = json_decode($request->items);

            for ($i = 0; $i < count($items); $i++) {
                $items[$i] = [
                    'id' => str()->uuid(),
                    'ca_usage_id' => $caUsage->id,
                    'note' => $items[$i]->note,
                    'amount' => $items[$i]->amount,
                    'type' => $items[$i]->type,
                    'date' => $items[$i]->date,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $caUsage->items()->insert($items);
        });

        Alert::success('Success', 'CA Usage Report created successfully');

        return redirect()->route('ca-usages.index');
    }

    public function show(CaUsage $caUsage): View
    {
        return view('ca-usage.show', compact('caUsage'));
    }

    public function edit(CaUsage $caUsage): View
    {
        $this->authorize('update', $caUsage);

        $cashAdvances = CashAdvance::orderBy('date', 'DESC');

        if (auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            $cashAdvances = $cashAdvances->where('user_id', auth()->id());
        }

        $cashAdvances = $cashAdvances->get();

        return view('ca-usage.edit', compact('caUsage', 'cashAdvances'));
    }

    public function update(CaUsageRequest $request, CaUsage $caUsage)
    {
        $this->authorize('update', $caUsage);

        $data = $request->validated();
        $data['is_user_signature_showed'] = $request->is_user_signature_showed ? true : false;
        $data['status'] = $request->is_draft ? StatusConstant::DRAFT : StatusConstant::PENDING;

        $caUsage->update($data);

        Alert::success('Success', 'CA Usage Report updated successfully');

        return redirect()->route('ca-usages.index');
    }

    public function destroy(CaUsage $caUsage)
    {
        $this->authorize('update', $caUsage);

        $caUsage->delete();

        Alert::success('Success', 'CA Usage Report deleted successfully');

        return redirect()->route('ca-usages.index');
    }

    public function approve(CaUsage $caUsage): RedirectResponse
    {
        $caUsage->update([
            'status' => StatusConstant::APPROVED,
            'admin_id' => auth()->id(),
            'is_admin_signature_showed' => request()->is_admin_signature_showed ? true : false,
        ]);

        // WA BLAST FOR MAS ANDRE (ASMEN)
        if ($caUsage->user_id === '9b2c771f-fbdc-409e-8259-49d084c7d1c5') {
            Http::get('https://ca.hanatekindo.com/storage/upload-ca/wa.php?wa=6281315559784');
        }

        Alert::success('Success', 'Approved successfully');

        return redirect()->route('ca-usages.index');
    }

    public function pdf(CaUsage $caUsage)
    {
        $pdf = Pdf::loadView('ca-usage.pdf', compact('caUsage'));
        return $pdf->stream('ca-usage.pdf');
    }

    public function note(CaUsage $caUsage): RedirectResponse
    {
        $note = request()->note;

        if (empty($note)) {
            Alert::error('Error', 'Note cannot be empty');
            return back();
        }

        $caUsage->update([
            'note' => $note,
        ]);

        Alert::success('Success', 'Note updated successfully');

        return back();
    }

    public function report(Request $request): View
    {
        $caUsagesRaw = CaUsage::with('user', 'admin')->orderBy('date', 'DESC');

        if ($request->has('q')) {
            $caUsagesRaw = $caUsagesRaw->where('name', 'like', '%' . $request->q . '%');
        } else {
            if ($request->has('requestBy')) {
                $caUsagesRaw = $caUsagesRaw->where('user_id', $request->requestBy);
            }

            if ($request->has('startDate')) {
                $caUsagesRaw = $caUsagesRaw->where('date', '>=', $request->startDate);
            } else {
                $caUsagesRaw = $caUsagesRaw->where('date', '>=', now()->format('Y-m-d'));
            }

            if ($request->has('endDate')) {
                $caUsagesRaw = $caUsagesRaw->where('date', '<=', $request->endDate);
            } else {
                $caUsagesRaw = $caUsagesRaw->where('date', '<=', now()->format('Y-m-d'));
            }
        }

        $caUsagesRaw = $caUsagesRaw->get()->groupBy('user_id');

        $caUsages = collect();

        $caUsagesRaw->each(function ($cashAdvance) use ($caUsages) {
            foreach ($cashAdvance as $item) {
                $caUsages->push($item);
            }
        });

        return view('ca-usage.report', compact('caUsages'));
    }
}
