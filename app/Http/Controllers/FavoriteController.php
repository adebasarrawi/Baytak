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
            return response()->json([
                'status' => 'removed',
                'message' => 'Property removed from favorites'
            ]);
        } else {
            // If not favorited, add to favorites
            Favorite::create([
                'user_id' => $userId,
                'property_id' => $propertyId
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Property added to favorites'
            ]);
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
        
        // Get favorite properties using a direct query instead of relationship
        $favorites = Property::whereIn('id', function($query) use ($user) {
            $query->select('property_id')
                  ->from('favorites')
                  ->where('user_id', $user->id);
        })->paginate(12);
        
        return view('favorites.index', compact('favorites'));
    }
}