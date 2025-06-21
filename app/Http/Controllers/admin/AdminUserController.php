<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by user type (including admin role)
        if ($request->has('user_type') && $request->user_type) {
            $query->where('user_type', $request->user_type);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Show deleted users if requested
        if ($request->has('show_deleted') && $request->show_deleted) {
            $query->onlyTrashed();
        }

        $users = $query->withCount(['properties', 'favorites', 'appraisals'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20|unique:users',
            'user_type' => 'required|in:user,seller,admin,appraiser',
            'status' => 'required|in:active,inactive',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email_verified' => 'boolean'
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Set email verification
        if ($request->has('email_verified') && $request->email_verified) {
            $validated['email_verified_at'] = now();
        }

        User::create($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $user->load(['properties', 'favorites', 'appraisals', 'payments']);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'user_type' => 'required|in:user,seller,admin,appraiser',
            'status' => 'required|in:active,inactive',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email_verified' => 'boolean'
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Handle email verification
        if ($request->has('email_verified')) {
            if ($request->email_verified && !$user->hasVerifiedEmail()) {
                $validated['email_verified_at'] = now();
            } elseif (!$request->email_verified && $user->hasVerifiedEmail()) {
                $validated['email_verified_at'] = null;
            }
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User updated successfully.');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user->update([
            'password' => $request->password
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    /**
     * Soft delete the specified user
     */
    public function destroy(User $user)
    {
        // Prevent deleting the current admin user
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'User deleted successfully.');
    }

    /**
     * Restore a soft deleted user
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users.index')
                        ->with('success', 'User restored successfully.');
    }

    /**
     * Permanently delete a user
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        
        // Delete profile image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->forceDelete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'User permanently deleted.');
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(User $user)
    {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        return redirect()->back()
                        ->with('success', "User status changed to {$newStatus}.");
    }

    /**
     * Verify user email
     */
    public function verifyEmail(User $user)
    {
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return redirect()->back()->with('success', 'User email verified successfully.');
        }

        return redirect()->back()->with('info', 'User email is already verified.');
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,verify_email',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        $users = User::whereIn('id', $request->user_ids);

        switch ($request->action) {
            case 'delete':
                $users->delete();
                $message = 'Selected users deleted successfully.';
                break;
            case 'activate':
                $users->update(['status' => 'active']);
                $message = 'Selected users activated successfully.';
                break;
            case 'deactivate':
                $users->update(['status' => 'inactive']);
                $message = 'Selected users deactivated successfully.';
                break;
            case 'verify_email':
                $users->update(['email_verified_at' => now()]);
                $message = 'Selected users email verified successfully.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Deactivate expired subscription
     */
    public function deactivateSubscription($paymentId)
    {
        $payment = \App\Models\Payment::findOrFail($paymentId);
        $user = $payment->user;

        // Deactivate the payment
        $payment->update(['active' => false]);

        // Change user type to regular user if subscription expired
        if ($user->user_type === 'seller') {
            $user->update(['user_type' => 'user']);
        }

        return redirect()->back()->with('success', 'User subscription deactivated and user type changed to regular user.');
    }
}