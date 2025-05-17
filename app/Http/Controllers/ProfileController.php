<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    //
    public function edit()
    {
        $userId = session('id', request()->cookie('id'));
        $user = DB::table('users')->where('id', $userId)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in.');
        }

        return view('auth.edit-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $userId = session('id', request()->cookie('id'));

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        DB::table('users')->where('id', $userId)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Get the user using session key 'id'
        $userId = session('id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->withErrors(['session' => 'User not found. Please log in again.']);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully!');
    }


    public function orders()
    {
        return view('order');
    }
}
