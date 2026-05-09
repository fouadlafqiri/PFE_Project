<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        /** @var \App\User $user */
        $user = Auth::user();

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $photo->getClientOriginalName());
            $uploadPath = public_path('uploads/profile_photos');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $photo->move($uploadPath, $photoName);
            $data['photo'] = asset('uploads/profile_photos/' . $photoName);
        }

        $user->update($data);

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}
