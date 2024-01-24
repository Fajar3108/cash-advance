<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashAdvanceRequest;
use App\Models\CashAdvance;
use Barryvdh\DomPDF\Facade\Pdf;
use Database\Seeders\RoleSeeder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CashAdvanceController extends Controller
{
    public function index(): View
    {
        $cashAdvances = CashAdvance::with('user', 'admin')->orderBy('date', 'DESC');

        if (request()->has('q')) {
            $cashAdvances = $cashAdvances->where('name', 'like', '%' . request('q') . '%');
        }

        if (auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            $cashAdvances = $cashAdvances->where('user_id', auth()->id());
        }

        $cashAdvances = $cashAdvances->paginate(10);

        return view('cash-advance.index', compact('cashAdvances'));
    }

    public function create(): View
    {
        $cashAdvance = new CashAdvance();
        $cashAdvance->date = now()->format('Y-m-d');
        return view('cash-advance.create', [
            'cashAdvance' => $cashAdvance,
        ]);
    }

    public function store(CashAdvanceRequest $request)
    {
        if (empty($request->items)) {
            Alert::error('Error', 'Please add at least one item');
            return back()->withInput($request->except('items'));
        }

        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['user_id'] = auth()->id();

            if ($request->is_user_signature_showed) {
                $data['is_user_signature_showed'] = true;
            } else {
                $data['is_user_signature_showed'] = false;
            }

            $cashAdvance = CashAdvance::create($data);

            $items = json_decode($request->items);

            for ($i = 0; $i < count($items); $i++) {
                $items[$i] = [
                    'id' => str()->uuid(),
                    'note' => $items[$i]->note,
                    'price' => $items[$i]->price,
                    'quantity' => $items[$i]->quantity,
                    'cash_advance_id' => $cashAdvance->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $cashAdvance->items()->insert($items);
        });

        Alert::success('Success', 'CA created successfully');

        return redirect()->route('cash-advances.index');
    }

    public function show(CashAdvance $cashAdvance): View
    {
        return view('cash-advance.show', compact('cashAdvance'));
    }

    public function edit(CashAdvance $cashAdvance)
    {
        if ($cashAdvance->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot edit approved cash advance');
            return redirect()->route('cash-advances.index');
        }

        return view('cash-advance.edit', compact('cashAdvance'));
    }

    public function update(CashAdvanceRequest $request, CashAdvance $cashAdvance)
    {
        if ($cashAdvance->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot edit approved cash advance');
            return redirect()->route('cash-advances.index');
        }

        $data = $request->validated();

        if ($request->is_user_signature_showed) {
            $data['is_user_signature_showed'] = true;
        } else {
            $data['is_user_signature_showed'] = false;
        }

        $cashAdvance->update($data);

        Alert::success('Success', 'CA updated successfully');

        return redirect()->route('cash-advances.index');
    }

    public function destroy(CashAdvance $cashAdvance): RedirectResponse
    {
        if ($cashAdvance->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot delete approved cash advance');
            return redirect()->route('cash-advances.index');
        }

        DB::transaction(function () use ($cashAdvance) {
            $cashAdvance->items()->delete();
            $cashAdvance->delete();
        });

        Alert::success('Success', 'CA deleted successfully');

        return redirect()->route('cash-advances.index');
    }

    public function approve(CashAdvance $cashAdvance): RedirectResponse
    {
        $cashAdvance->update([
            'is_approved' => true,
            'admin_id' => auth()->id(),
            'is_admin_signature_showed' => request()->is_admin_signature_showed ? true : false,
        ]);

        Alert::success('Success', 'CA approved successfully');

        return redirect()->route('cash-advances.index');
    }

    public function pdf(CashAdvance $cashAdvance)
    {
        $pdf = Pdf::loadView('cash-advance.pdf', compact('cashAdvance'));
        return $pdf->stream('cash-advance.pdf');
    }

    public function note(CashAdvance $cashAdvance): RedirectResponse
    {
        $note = request()->note;

        if (empty($note)) {
            Alert::error('Error', 'Note cannot be empty');
            return back();
        }

        $cashAdvance->update([
            'note' => $note,
        ]);

        Alert::success('Success', 'Note updated successfully');

        return back();
    }
}
