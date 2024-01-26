<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReimbursementItemRequest;
use App\Models\Reimbursement;
use App\Models\ReimbursementItem;
use Database\Seeders\RoleSeeder;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class ReimbursementItemController extends Controller
{
    public function create(Reimbursement $reimbursement)
    {
        if ($reimbursement->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot edit approved reimbursement');
            return redirect()->route('reimbursements.index');
        }

        return view('reimbursement-item.create', compact('reimbursement'));
    }

    public function store(ReimbursementItemRequest $request, Reimbursement $reimbursement)
    {
        if ($reimbursement->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot edit approved reimbursement');
            return redirect()->route('reimbursements.index');
        }

        $reimbursement->items()->create($request->validated());
        Alert::success('Success', 'Item added successfully');
        return redirect()->route('reimbursements.edit', $reimbursement);
    }

    public function edit(Reimbursement $reimbursement, ReimbursementItem $reimbursement_item)
    {
        if ($reimbursement->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot edit approved reimbursement');
            return redirect()->route('reimbursements.index');
        }
        return view('reimbursement-item.edit', compact('reimbursement', 'reimbursement_item'));
    }

    public function update(ReimbursementItemRequest $request, Reimbursement $reimbursement, ReimbursementItem $reimbursement_item)
    {
        if ($reimbursement->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot edit approved reimbursement');
            return redirect()->route('reimbursements.index');
        }
        $reimbursement_item->update($request->validated());
        Alert::success('Success', 'Item updated successfully');
        return redirect()->route('reimbursements.edit', $reimbursement);
    }

    public function destroy(Reimbursement $reimbursement, ReimbursementItem $reimbursement_item): RedirectResponse
    {
        if ($reimbursement->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot delete item from approved reimbursement');
            return back();
        }

        if ($reimbursement->items()->count() <= 1) {
            Alert::error('Error', 'You cannot delete the last item');
            return back();
        }

        $reimbursement_item->delete();

        Alert::success('Success', 'Item deleted successfully');
        return back();
    }
}
