<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
