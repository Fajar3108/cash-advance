<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\CashAdvance;
use App\Models\Item;
use RealRashid\SweetAlert\Facades\Alert;

class ItemController extends Controller
{
    public function create(CashAdvance $cashAdvance)
    {
        return view('item.create', compact('cashAdvance'));
    }

    public function store(ItemRequest $request, CashAdvance $cashAdvance)
    {
        $cashAdvance->items()->create($request->validated());
        Alert::success('Success', 'Item added successfully');
        return redirect()->route('cash-advances.edit', $cashAdvance);
    }

    public function edit(CashAdvance $cashAdvance, Item $item)
    {
        return view('item.edit', compact('cashAdvance', 'item'));
    }

    public function update(ItemRequest $request, CashAdvance $cashAdvance, Item $item)
    {
        $item->update($request->validated());
        Alert::success('Success', 'Item updated successfully');
        return redirect()->route('cash-advances.edit', $cashAdvance);
    }

    public function destroy(CashAdvance $cashAdvance, Item $item)
    {
        if ($cashAdvance->is_approved) {
            Alert::error('Error', 'You cannot delete item from approved cash advance');
            return back();
        }

        if ($cashAdvance->items()->count() <= 1) {
            Alert::error('Error', 'You cannot delete the last item');
            return back();
        }

        $item->delete();
        Alert::success('Success', 'Item deleted successfully');
        return back();
    }
}
