<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->role, fn($q, $role) => $q->where('role', $role))
            ->when($request->search, fn($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->withCount(['properties', 'bookings'])
            ->latest()
            ->paginate(10);

        return view('admin.a.index', [
            'users' => $users,
            'roles' => ['user' => 'User', 'admin' => 'Admin'] 
        ]);
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('toast', [
            'type' => 'success',
            'message' => 'User status updated'
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('toast', [
                'type' => 'error',
                'message' => 'Cannot delete admin users'
            ]);
        }

        $user->delete();
        return back()->with('toast', [
            'type' => 'success',
            'message' => 'User deleted successfully'
        ]);
    }
}

