<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Toggle favorite status for a property.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request)
    {
        $propertyId = $request->property_id;
        $userId = Auth::id();
        
        // Check if property exists
        $property = Property::findOrFail($propertyId);
        
        // Check if already favorited
        $favorite = Favorite::where('user_id', $userId)
            ->where('property_id', $propertyId)
            ->first();
            
        if ($favorite) {
            // If already favorited, remove from favorites
            $favorite->delete();
            return redirect()->back()->with('success', 'Property removed from favorites');
        } else {
            // If not favorited, add to favorites
            Favorite::create([
                'user_id' => $userId,
                'property_id' => $propertyId
            ]);
            return redirect()->back()->with('success', 'Property added to favorites');
        }
    }

    /**
     * Display user's favorite properties.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        
        // جلب سجلات المفضلة مع علاقة العقار
        $favorites = Favorite::with('property')
            ->where('user_id', $user->id)
            ->paginate(12);
        
        return view('favorites.index', compact('favorites'));
    }
}