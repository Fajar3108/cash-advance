<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('role')->latest();

        if (request()->has('q')) {
            $users = $users->where('name', 'like', '%' . request('q') . '%');
        }

        $users = $users->paginate(10);

        return view('user.index', compact('users'));
    }

    public function create(): View
    {
        return view('user.create', [
            'user' => new User(),
            'roles' => Role::all(),
        ]);
    }

    public function store(UserRequest $request)
    {
        if ($request->hasFile('signature')) {
            $signature = $request->file('signature')->store('signatures', ['disk' => 'public']);
        }

        $data = $request->validated();
        $data['signature'] = $signature ?? null;
        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = $data['role'];

        User::create($data);

        Alert::success('Success', 'User created successfully');

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user): View
    {
        return view('user.edit', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        $data['role_id'] = $data['role'];

        if ($request->hasFile('signature')) {
            Storage::disk('public')->delete($user->signature);
            $signature = $request->file('signature')->store('signatures', ['disk' => 'public']);
            $data['signature'] = $signature;
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        Alert::success('Success', 'User updated successfully');

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        Storage::disk('public')->delete($user->signature);
        $user->delete();
        Alert::success('Success', 'User deleted successfully');
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
