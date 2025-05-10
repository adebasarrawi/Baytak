<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Verificar si el usuario es administrador
     *
     * @return bool
     */
    private function userIsAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }
    
    /**
     * Verificar si el usuario puede gestionar la propiedad
     *
     * @param Property $property
     * @return bool
     */
    private function canManageProperty(Property $property)
    {
        return Auth::id() === $property->user_id || $this->userIsAdmin();
    }

    /**
     * Mostrar listado de propiedades
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Crear consulta base
        $query = Property::with(['type', 'area', 'images', 'features'])
            ->where('is_approved', true);
        
        // Aplicar filtros si se proporcionan
        if ($request->filled('property_type')) {
            $query->where('property_type_id', $request->property_type);
        }
        
        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        // Ordenar propiedades
        $query->orderBy('is_featured', 'desc')
              ->orderBy('created_at', 'desc');
        
        // Obtener resultados paginados
        $properties = $query->paginate(12);
        
        // Obtener tipos de propiedades para el filtro
        $propertyTypes = PropertyType::all();
        
        return view('public.properties', compact('properties', 'propertyTypes'));
    }
    
    /**
     * Mostrar los detalles de una propiedad
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\View\View
     */
    public function show(Property $property)
    {
        // Cargar relaciones
        $property->load(['type', 'area', 'images', 'features', 'user']);
        
        // Incrementar contador de vistas
        $property->increment('views');
        
        return view('properties.show', compact('property'));
    }
    
    /**
     * Mostrar formulario para crear una nueva propiedad
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login', ['redirect' => 'properties/create'])
                ->with('error', 'You must be logged in to create a property listing.');
        }
        
        // Verificar si el usuario es un vendedor
        if (Auth::user()->user_type !== 'seller') {
            // Si el usuario es un usuario normal (no vendedor)
            if (Auth::user()->user_type === 'user') {
                return redirect()->route('seller.payment')
                    ->with('info', 'To list properties, you need to complete your seller registration.');
            } 
            // Si el usuario es un vendedor pendiente
            elseif (Auth::user()->user_type === 'pending_seller') {
                return redirect()->route('seller.payment')
                    ->with('info', 'You need to complete the payment to activate your seller account.');
            }
        }
        
        $propertyTypes = PropertyType::all();
        $areas = Area::all();
        
        return view('properties.create', compact('propertyTypes', 'areas'));
    }
    
    /**
     * Almacenar una nueva propiedad en la base de datos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to create a property listing.');
        }
        
        // Verificar si el usuario es un vendedor
        if (Auth::user()->user_type !== 'seller') {
            return redirect()->route('seller.payment')
                ->with('error', 'You need to complete your seller registration first.');
        }
        
        // Validar la solicitud
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'size' => 'required|numeric',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'property_type_id' => 'required|exists:property_types,id',
            'area_id' => 'required|exists:areas,id',
            'address' => 'required|string',
            'purpose' => 'required|in:sale,rent',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Crear propiedad
        $property = Property::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'size' => $validated['size'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'property_type_id' => $validated['property_type_id'],
            'area_id' => $validated['area_id'],
            'address' => $validated['address'],
            'purpose' => $validated['purpose'],
            'slug' => Str::slug($validated['title'] . '-' . uniqid()),
            'is_approved' => null, // null means pending approval
            'is_featured' => false
        ]);
        
        // Procesar imágenes subidas - la primera imagen será la primaria
        if ($request->hasFile('images')) {
            $this->uploadPropertyImages($property, $request->file('images'));
        }

        return redirect()->route('properties.my')
            ->with('success', 'Property submitted for approval. You will be notified once it is reviewed.');
    }
    
    /**
     * Mostrar formulario para editar una propiedad
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Property $property)
    {
        // Verificar si el usuario actual está autorizado para editar esta propiedad
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to edit this property.');
        }
        
        $propertyTypes = PropertyType::all();
        $areas = Area::all();
        
        return view('properties.edit', compact('property', 'propertyTypes', 'areas'));
    }
    
    /**
     * Actualizar la propiedad en la base de datos
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Property $property)
    {
        // Verificar si el usuario actual está autorizado para actualizar esta propiedad
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to update this property.');
        }
        
        // Validar la solicitud
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'size' => 'required|numeric',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'property_type_id' => 'required|exists:property_types,id',
            'area_id' => 'required|exists:areas,id',
            'address' => 'required|string',
            'purpose' => 'required|in:sale,rent',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_image' => 'nullable|integer'
        ]);

        // Actualizar propiedad
        $property->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'size' => $validated['size'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'property_type_id' => $validated['property_type_id'],
            'area_id' => $validated['area_id'],
            'address' => $validated['address'],
            'purpose' => $validated['purpose'],
            'is_approved' => null, // Reset to pending approval when updated
        ]);
        
        // Gestionar subidas de imágenes si se proporcionaron nuevas
        if ($request->hasFile('images')) {
            $this->uploadPropertyImages($property, $request->file('images'));
        }
        
        // Si solo se cambió la imagen principal (sin nuevas subidas)
        elseif (isset($validated['primary_image'])) {
            $this->updatePrimaryImage($property, $validated['primary_image']);
        }

        return redirect()->route('properties.my')
            ->with('success', 'Property updated successfully and is pending approval.');
    }
    
    /**
     * Mostrar las propiedades del vendedor
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function myProperties()
    {
        $properties = Property::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(8);
        
        return view('properties.my', compact('properties'));
    }
    
    /**
     * Eliminar la propiedad específica
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Property $property)
    {
        // Verificar si el usuario actual está autorizado para eliminar esta propiedad
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to delete this property.');
        }
        
        // Eliminar todas las imágenes asociadas del almacenamiento
        foreach ($property->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }
        
        // Eliminar la propiedad (las imágenes se eliminarán en cascada debido a las restricciones de clave externa)
        $property->delete();
        
        return redirect()->route('properties.my')
            ->with('success', 'Property deleted successfully.');
    }
    
    /**
     * Método para eliminar una imagen específica
     *
     * @param  int  $imageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteImage($imageId)
    {
        $image = PropertyImage::findOrFail($imageId);
        
        // Verificar si el usuario actual es el propietario de esta propiedad
        $property = $image->property;
        
        if (!$this->canManageProperty($property)) {
            return redirect()->back()
                ->with('error', 'You are not authorized to delete this image.');
        }
        
        // Obtener la ruta del archivo
        $filePath = $image->image_path;
        
        // Eliminar del almacenamiento si el archivo existe
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
        
        // Eliminar de la base de datos
        $image->delete();
        
        return back()->with('success', 'Image deleted successfully.');
    }
    
    /**
     * Método auxiliar para manejar subidas de imágenes
     *
     * @param  \App\Models\Property  $property
     * @param  array  $images
     * @return void
     */
    private function uploadPropertyImages(Property $property, array $images)
    {
        $i = 0;
        foreach ($images as $image) {
            // Almacenar la imagen en el directorio storage/app/public/properties/images
            $path = $image->store('properties/images', 'public');
            
            // Crear el registro de la imagen
            $property->images()->create([
                'image_path' => $path,
                'is_primary' => ($i == 0), // La primera imagen siempre será la principal
                'sort_order' => $i
            ]);
            
            $i++;
        }
    }
    
    /**
     * Método auxiliar para actualizar la imagen principal
     *
     * @param  \App\Models\Property  $property
     * @param  int  $primaryImageId
     * @return void
     */
    private function updatePrimaryImage(Property $property, $primaryImageId)
    {
        // Reestablecer todas las imágenes a no-primarias
        $property->images()->update(['is_primary' => false]);
        
        // Establecer la imagen seleccionada como primaria
        if (is_numeric($primaryImageId)) {
            $property->images()->where('id', $primaryImageId)->update(['is_primary' => true]);
        }
    }
}