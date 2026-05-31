<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'address'         => 'nullable|string|max:500',
            'gender'          => 'nullable|in:Male,Female,Other',
            'phone'           => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('name', 'email', 'address', 'gender', 'phone');

        if ($request->hasFile('profile_picture')) {
            $file     = $request->file('profile_picture');
            $mime     = $file->getMimeType();
            $binary   = file_get_contents($file->getRealPath());
            $data['profile_picture_base64'] = 'data:' . $mime . ';base64,' . base64_encode($binary);
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('profile.show')->with('toast_success', 'Profile updated successfully!');
    }
}
