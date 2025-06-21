<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        return view('public.profile', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        return view('public.profile-edit');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Prepare data for update
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio,
        ];

        // Handle image upload if present
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            
            // Get current user to remove old image if exists
            $currentUser = DB::table('users')->where('id', Auth::id())->first();
            
            // Delete old image if exists
            if ($currentUser->profile_image) {
                $oldImagePath = 'public/' . $currentUser->profile_image;
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
            }
            
            // Create directory if it doesn't exist
            if (!Storage::disk('public')->exists('profile-images')) {
                Storage::disk('public')->makeDirectory('profile-images');
            }
            
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store the new image in the public storage
            $imagePath = $image->storeAs('profile-images', $filename, 'public');
            $updateData['profile_image'] = $imagePath;
        }

        // Execute the update in the database
        DB::table('users')
            ->where('id', Auth::id())
            ->update($updateData);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        // Validate the request data
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Get current user
        $user = DB::table('users')->where('id', Auth::id())->first();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'The current password is incorrect.'])
                ->withInput();
        }

        // Update password
        DB::table('users')
            ->where('id', Auth::id())
            ->update([
                'password' => Hash::make($request->password)
            ]);

        return redirect()->route('profile.edit')->with('success', 'Password changed successfully!');
    }
}