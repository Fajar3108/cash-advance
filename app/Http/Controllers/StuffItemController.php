<?php

namespace App\Http\Controllers;

use App\Http\Requests\StuffItemRequest;
use App\Models\Stuff;
use App\Models\StuffItem;
use Database\Seeders\RoleSeeder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class StuffItemController extends Controller
{
    public function create(Stuff $stuff): View
    {
        if ($stuff->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot edit approved cash advance');
            return redirect()->route('stuffs.index');
        }

        return view('stuff-item.create', compact('stuff'));
    }

    public function store(StuffItemRequest $request, Stuff $stuff): RedirectResponse
    {
        if ($stuff->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot edit approved cash advance');
            return redirect()->route('stuffs.index');
        }

        $stuff->items()->create($request->validated());

        Alert::success('Success', 'Item added successfully');

        return redirect()->route('stuffs.edit', $stuff->id);
    }

    public function edit(Stuff $stuff, StuffItem $stuffItem): View
    {
        if ($stuff->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot edit approved cash advance');
            return redirect()->route('stuffs.index');
        }

        return view('stuff-item.edit', compact('stuff', 'stuffItem'));
    }

    public function update(StuffItemRequest $request, Stuff $stuff, StuffItem $stuffItem): RedirectResponse
    {
        if ($stuff->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot edit approved cash advance');
            return redirect()->route('stuffs.index');
        }

        $stuffItem->update($request->validated());

        Alert::success('Success', 'Item updated successfully');

        return redirect()->route('stuffs.edit', $stuff->id);
    }

    public function destroy(Stuff $stuff, StuffItem $stuffItem): RedirectResponse
    {
        if ($stuff->is_approved && auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            Alert::error('Error', 'You cannot edit approved cash advance');
            return redirect()->route('stuffs.index');
        }

        if ($stuff->items()->count() <= 1) {
            Alert::error('Error', 'You cannot delete the last item');
            return back();
        }

        $stuffItem->delete();

        Alert::success('Success', 'Item deleted successfully');

        return redirect()->route('stuffs.edit', $stuff->id);
    }
}
