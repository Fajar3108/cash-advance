<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaUsageItemRequest;
use App\Models\CaUsage;
use App\Models\CaUsageItem;
use RealRashid\SweetAlert\Facades\Alert;

class CaUsageItemController extends Controller
{
    public function create(CaUsage $caUsage)
    {
        return view('ca-usage-item.create', compact('caUsage'));
    }

    public function store(CaUsage $caUsage, CaUsageItemRequest $request)
    {
        $caUsage->items()->create($request->validated());
        Alert::success('Success', 'Item added successfully');
        return redirect()->route('ca-usages.edit', $caUsage);
    }

    public function edit(CaUsage $caUsage, CaUsageItem $caUsageItem)
    {
        return view('ca-usage-item.edit', compact('caUsage', 'caUsageItem'));
    }

    public function update(CaUsage $caUsage, CaUsageItem $caUsageItem, CaUsageItemRequest $request)
    {
        $caUsageItem->update($request->validated());
        Alert::success('Success', 'Item updated successfully');
        return redirect()->route('ca-usages.edit', $caUsage);
    }

    public function destroy(CaUsage $caUsage, CaUsageItem $caUsageItem)
    {
        if ($caUsage->items()->count() <= 1) {
            Alert::error('Error', 'You cannot delete the last item');
            return back();
        }

        $caUsageItem->delete();
        Alert::success('Success', 'Item deleted successfully');
        return redirect()->route('ca-usages.edit', $caUsage);
    }
}
