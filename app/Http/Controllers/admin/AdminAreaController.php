<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAreaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $governorate = $request->get('governorate');
        
        $query = Area::with(['governorate', 'properties'])
            ->withCount('properties');
        
        // Search filter
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        
        // Governorate filter
        if ($governorate) {
            $query->where('governorate_id', $governorate);
        }
        
        $areas = $query->orderBy('name')->paginate(15);
        
        // Statistics
        $totalAreas = Area::count();
        $areasWithProperties = Area::has('properties')->count();
        $areasWithoutProperties = $totalAreas - $areasWithProperties;
        $totalProperties = DB::table('properties')->count();
        
        // Areas by governorate
        $areasByGovernorate = Area::join('governorates', 'areas.governorate_id', '=', 'governorates.id')
            ->select('governorates.name as governorate_name', DB::raw('count(*) as count'))
            ->groupBy('governorates.id', 'governorates.name')
            ->orderBy('count', 'desc')
            ->get();
        
        // Top areas with most properties
        $topAreas = Area::withCount('properties')
            ->orderBy('properties_count', 'desc')
            ->take(10)
            ->get();
        
        // Get all governorates for filter
        $governorates = Governorate::orderBy('name')->get();
        
        return view('admin.areas.index', compact(
            'areas', 'governorates', 'search', 'governorate',
            'totalAreas', 'areasWithProperties', 'areasWithoutProperties', 'totalProperties',
            'areasByGovernorate', 'topAreas'
        ));
    }
    
    public function create()
    {
        $governorates = Governorate::orderBy('name')->get();
        return view('admin.areas.create', compact('governorates'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:areas,name',
            'governorate_id' => 'required|exists:governorates,id'
        ]);
        
        Area::create($validated);
        
        return redirect()->route('admin.areas.index')
            ->with('success', 'Area created successfully');
    }
    
    public function edit(Area $area)
    {
        $governorates = Governorate::orderBy('name')->get();
        return view('admin.areas.edit', compact('area', 'governorates'));
    }
    
    public function update(Request $request, Area $area)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:areas,name,' . $area->id,
            'governorate_id' => 'required|exists:governorates,id'
        ]);
        
        $area->update($validated);
        
        return redirect()->route('admin.areas.index')
            ->with('success', 'Area updated successfully');
    }
    
    public function destroy(Area $area)
    {
        // Check if area has properties
        $propertiesCount = $area->properties()->count();
        
        if ($propertiesCount > 0) {
            return redirect()->route('admin.areas.index')
                ->with('error', "Cannot delete area. It has {$propertiesCount} properties associated with it.");
        }
        
        $area->delete();
        
        return redirect()->route('admin.areas.index')
            ->with('success', 'Area deleted successfully');
    }
}