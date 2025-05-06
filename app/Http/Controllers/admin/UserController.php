
<?php
app/Http/Controllers/Admin/UserController.php
namespace App\Http\Controllers\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.a.index');
    }
    public function index(Request $request)
    {
        $query = User::withCount(['properties', 'bookings'])
            ->latest();
            
        if ($request->has('role')) {
            $query->where('role', $request->role);
        }
        
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }
        
        $users = $query->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'User status updated');
    }
    
    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admin users');
        }
        
        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }
}
