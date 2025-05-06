@extends('layouts.public.app')

@section('title', 'Add New Property')

@section('content')
<div class="hero page-inner overlay">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">List Your Property</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">Add New Property</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<div class="section">
  <div class="container">
    <div class="row mb-5">
      <div class="col-lg-8 mx-auto">
        <div class="bg-white p-4 rounded shadow-sm">
          <h2 class="text-primary mb-4">Property Information</h2>
          
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row mb-4">
              <div class="col-md-12 mb-3">
                <label for="title" class="form-label">Property Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Modern Villa with Pool">
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="property_type" class="form-label">Property Type <span class="text-danger">*</span></label>
                <select class="form-select" id="property_type" name="property_type_id" required>
                  <option value="">Select Property Type</option>
                  @foreach(App\Models\PropertyType::all() as $type)
                    <option value="{{ $type->id }}" {{ old('property_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="purpose" class="form-label">Purpose <span class="text-danger">*</span></label>
                <select class="form-select" id="purpose" name="purpose" required>
                  <option value="">Select Purpose</option>
                  <option value="sale" {{ old('purpose') == 'sale' ? 'selected' : '' }}>For Sale</option>
                  <option value="rent" {{ old('purpose') == 'rent' ? 'selected' : '' }}>For Rent</option>
                </select>
              </div>
            </div>
            
            <h4 class="text-primary mb-3">Location Details</h4>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label for="area_id" class="form-label">Area <span class="text-danger">*</span></label>
                <select class="form-select" id="area_id" name="area_id" required>
                  <option value="">Select Area</option>
                  @foreach(App\Models\Area::all() as $area)
                    <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="address" class="form-label">Full Address <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required placeholder="e.g. 123 Main Street, Apt 4B">
              </div>
            </div>
            
            <h4 class="text-primary mb-3">Property Details</h4>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Price (JOD) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required min="0" step="0.01" placeholder="e.g. 150000">
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="size" class="form-label">Size (sq.ft) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="size" name="size" value="{{ old('size') }}" required min="0" placeholder="e.g. 1500">
              </div>
              
              <div class="col-md-4 mb-3">
                <label for="bedrooms" class="form-label">Bedrooms</label>
                <input type="number" class="form-control" id="bedrooms" name="bedrooms" value="{{ old('bedrooms') }}" min="0" placeholder="e.g. 3">
              </div>
              
              <div class="col-md-4 mb-3">
                <label for="bathrooms" class="form-label">Bathrooms</label>
                <input type="number" class="form-control" id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}" min="0" placeholder="e.g. 2">
              </div>
              
              <div class="col-md-4 mb-3">
                <label for="parking_spaces" class="form-label">Parking Spaces</label>
                <input type="number" class="form-control" id="parking_spaces" name="parking_spaces" value="{{ old('parking_spaces') }}" min="0" placeholder="e.g. 1">
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="year_built" class="form-label">Year Built</label>
                <select class="form-select" id="year_built" name="year_built">
                  <option value="">Select Year Built</option>
                  @for($year = date('Y'); $year >= 1950; $year--)
                    <option value="{{ $year }}" {{ old('year_built') == $year ? 'selected' : '' }}>{{ $year }}</option>
                  @endfor
                </select>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="is_featured" class="form-label">Featured Property</label>
                <div class="form-check form-switch mt-2">
                  <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_featured">Mark as featured (appears in spotlight sections)</label>
                </div>
              </div>
            </div>
            
            <h4 class="text-primary mb-3">Features</h4>
            <div class="row mb-4">
              <div class="col-md-12 mb-3">
                <label class="form-label">Property Features</label>
                <div class="row">
                  @foreach(App\Models\Feature::all() as $feature)
                    <div class="col-md-4 mb-2">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="feature_{{ $feature->id }}" name="features[]" value="{{ $feature->id }}" {{ (is_array(old('features')) && in_array($feature->id, old('features'))) ? 'checked' : '' }}>
                        <label class="form-check-label" for="feature_{{ $feature->id }}">{{ $feature->name }}</label>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            
            <h4 class="text-primary mb-3">Description</h4>
            <div class="row mb-4">
              <div class="col-md-12 mb-3">
                <label for="description" class="form-label">Property Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="6" required placeholder="Provide a detailed description of your property...">{{ old('description') }}</textarea>
              </div>
            </div>
            
            <h4 class="text-primary mb-3">Property Images</h4>
            <div class="row mb-4">
              <div class="col-md-12 mb-3">
                <label for="images" class="form-label">Upload Images <span class="text-danger">*</span></label>
                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" required>
                <div class="form-text">You can upload multiple images. First image will be set as primary image.</div>
              </div>
              <div class="col-md-12">
                <div id="image-previews" class="row mt-3"></div>
              </div>
            </div>
            
            <h4 class="text-primary mb-3">Contact Information</h4>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label for="contact_name" class="form-label">Contact Name</label>
                <input type="text" class="form-control" id="contact_name" name="contact_name" value="{{ old('contact_name', Auth::user()->name ?? '') }}" placeholder="Your name">
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="contact_phone" class="form-label">Contact Phone <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', Auth::user()->phone ?? '') }}" required placeholder="Your phone number">
              </div>
              
              <div class="col-md-12 mb-3">
                <label for="contact_email" class="form-label">Contact Email</label>
                <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ old('contact_email', Auth::user()->email ?? '') }}" placeholder="Your email address">
              </div>
            </div>
            
            <div class="form-check mb-4">
              <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
              <label class="form-check-label" for="terms">
                I confirm that all information provided is accurate and I have the right to list this property.
              </label>
            </div>
            
            <div class="text-center">
              <button type="submit" class="btn btn-primary btn-lg px-5">Submit Property</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Image preview functionality
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('images').addEventListener('change', function(event) {
      // Clear previous previews
      document.getElementById('image-previews').innerHTML = '';
      
      // Create preview for each selected image
      for (let i = 0; i < event.target.files.length; i++) {
        const file = event.target.files[i];
        if (file.type.match('image.*')) {
          const reader = new FileReader();
          reader.onload = function(e) {
            const preview = document.createElement('div');
            preview.className = 'col-md-3 mb-3';
            preview.innerHTML = `
              <div class="position-relative">
                <img src="${e.target.result}" class="img-thumbnail" alt="Preview">
                ${i === 0 ? '<span class="badge bg-primary position-absolute top-0 end-0 m-2">Primary</span>' : ''}
              </div>
            `;
            document.getElementById('image-previews').appendChild(preview);
          }
          reader.readAsDataURL(file);
        }
      }
    });
  });
</script>
@endpush
@endsection