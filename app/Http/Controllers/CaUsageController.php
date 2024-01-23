<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaUsageRequest;
use App\Models\CashAdvance;
use App\Models\CaUsage;
use Barryvdh\DomPDF\Facade\Pdf;
use Database\Seeders\RoleSeeder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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

            if ($request->is_user_signature_showed) {
                $data['is_user_signature_showed'] = true;
            } else {
                $data['is_user_signature_showed'] = false;
            }

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
        $cashAdvances = CashAdvance::orderBy('date', 'DESC');

        if (auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            $cashAdvances = $cashAdvances->where('user_id', auth()->id());
        }

        $cashAdvances = $cashAdvances->get();

        return view('ca-usage.edit', compact('caUsage', 'cashAdvances'));
    }

    public function update(CaUsageRequest $request, CaUsage $caUsage)
    {
        if ($caUsage->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot edit approved cash advance');
            return redirect()->route('ca-usages.index');
        }

        $data = $request->validated();

        if ($request->is_user_signature_showed) {
            $data['is_user_signature_showed'] = true;
        } else {
            $data['is_user_signature_showed'] = false;
        }

        $caUsage->update($data);

        Alert::success('Success', 'CA Usage Report updated successfully');

        return redirect()->route('ca-usages.index');
    }

    public function destroy(CaUsage $caUsage)
    {
        if ($caUsage->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot delete approved cash advance');
            return redirect()->route('ca-usages.index');
        }

        $caUsage->delete();

        Alert::success('Success', 'CA Usage Report deleted successfully');

        return redirect()->route('ca-usages.index');
    }

    public function approve(CaUsage $caUsage): RedirectResponse
    {
        $caUsage->update([
            'is_approved' => true,
            'admin_id' => auth()->id(),
            'is_admin_signature_showed' => request()->is_admin_signature_showed ? true : false,
        ]);

        Alert::success('Success', 'Approved successfully');

        return redirect()->route('ca-usages.index');
    }

    public function pdf(CaUsage $caUsage)
    {
        $pdf = Pdf::loadView('ca-usage.pdf', compact('caUsage'));
        return $pdf->download('ca-usage.pdf');
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
}
