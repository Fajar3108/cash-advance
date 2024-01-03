<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return redirect()->back()->withInput($request->except('password'))->with('error', 'Invalid credentials');
        }

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function profile()
    {
        return view('auth.profile');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->only(['name', 'email']);

        if ($request->hasFile('signature')) {
            Storage::disk('public')->delete(auth()->user()->signature);
            $data['signature'] = $request->file('signature')->store('signatures', ['disk' => 'public']);
        }

        auth()->user()->update($data);

        Alert::success('Success', 'Profile updated successfully');

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function changePasswordView()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        auth()->user()->update([
            'password' => bcrypt($request->password),
        ]);

        Alert::success('Success', 'Password changed successfully');

        return redirect()->route('change-password')->with('success', 'Password changed successfully');
    }
}
