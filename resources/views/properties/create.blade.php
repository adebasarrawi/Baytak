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
        <!-- Success Message After Submission -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
          <h4 class="alert-heading"><i class="fas fa-check-circle me-2"></i> Property Submitted!</h4>
          <p>{{ session('success') }}</p>
          <p class="mb-0">Your property listing has been submitted and is pending approval. Our team will review your listing and it will be published soon.</p>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

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
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-home text-primary"></i>
                  </span>
                  <input type="text" class="form-control border-start-0" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Modern Villa with Pool">
                </div>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="property_type" class="form-label">Property Type <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-building text-primary"></i>
                  </span>
                  <select class="form-select border-start-0" id="property_type" name="property_type_id" required>
                    <option value="">Select Property Type</option>
                    @foreach(App\Models\PropertyType::all() as $type)
                      <option value="{{ $type->id }}" {{ old('property_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="purpose" class="form-label">Purpose <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-tag text-primary"></i>
                  </span>
                  <select class="form-select border-start-0" id="purpose" name="purpose" required>
                    <option value="">Select Purpose</option>
                    <option value="sale" {{ old('purpose') == 'sale' ? 'selected' : '' }}>For Sale</option>
                    <option value="rent" {{ old('purpose') == 'rent' ? 'selected' : '' }}>For Rent</option>
                  </select>
                </div>
              </div>
            </div>
            
            <h4 class="text-primary mb-3">Location Details</h4>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label for="area_id" class="form-label">Area <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-map-marker-alt text-primary"></i>
                  </span>
                  <select class="form-select border-start-0" id="area_id" name="area_id" required>
                    <option value="">Select Area</option>
                    @foreach(App\Models\Area::all() as $area)
                      <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="address" class="form-label">Full Address <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-location-dot text-primary"></i>
                  </span>
                  <input type="text" class="form-control border-start-0" id="address" name="address" value="{{ old('address') }}" required placeholder="e.g. 123 Main Street, Apt 4B">
                </div>
              </div>
            </div>
            
            <h4 class="text-primary mb-3">Property Details</h4>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Price (JOD) <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-money-bill text-primary"></i>
                  </span>
                  <input type="number" class="form-control border-start-0" id="price" name="price" value="{{ old('price') }}" required min="0" step="0.01" placeholder="e.g. 150000">
                </div>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="size" class="form-label">Size (sq.ft) <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-ruler-combined text-primary"></i>
                  </span>
                  <input type="number" class="form-control border-start-0" id="size" name="size" value="{{ old('size') }}" required min="0" placeholder="e.g. 1500">
                </div>
              </div>
              
              <div class="col-md-4 mb-3">
                <label for="bedrooms" class="form-label">Bedrooms</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-bed text-primary"></i>
                  </span>
                  <input type="number" class="form-control border-start-0" id="bedrooms" name="bedrooms" value="{{ old('bedrooms') }}" min="0" placeholder="e.g. 3">
                </div>
              </div>
              
              <div class="col-md-4 mb-3">
                <label for="bathrooms" class="form-label">Bathrooms</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-bath text-primary"></i>
                  </span>
                  <input type="number" class="form-control border-start-0" id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}" min="0" placeholder="e.g. 2">
                </div>
              </div>
              
              <div class="col-md-4 mb-3">
                <label for="parking_spaces" class="form-label">Parking Spaces</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-car text-primary"></i>
                  </span>
                  <input type="number" class="form-control border-start-0" id="parking_spaces" name="parking_spaces" value="{{ old('parking_spaces') }}" min="0" placeholder="e.g. 1">
                </div>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="year_built" class="form-label">Year Built</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-calendar-alt text-primary"></i>
                  </span>
                  <select class="form-select border-start-0" id="year_built" name="year_built">
                    <option value="">Select Year Built</option>
                    @for($year = date('Y'); $year >= 1950; $year--)
                      <option value="{{ $year }}" {{ old('year_built') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                  </select>
                </div>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="is_featured" class="form-label">Featured Property</label>
                <div class="form-check form-switch p-2 mt-2 bg-light rounded">
                  <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_featured">Mark as featured (appears in spotlight sections)</label>
                </div>
              </div>
            </div>
            
            <h4 class="text-primary mb-3">Features</h4>
            <div class="row mb-4">
              <div class="col-md-12 mb-3">
                <label class="form-label">Property Features</label>
                <div class="row bg-light p-3 rounded">
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
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-align-left text-primary"></i>
                  </span>
                  <textarea class="form-control border-start-0" id="description" name="description" rows="6" required placeholder="Provide a detailed description of your property...">{{ old('description') }}</textarea>
                </div>
              </div>
            </div>
            
            <h4 class="text-primary mb-3">Property Images</h4>
            <div class="row mb-4">
              <div class="col-md-12 mb-3">
                <label for="images" class="form-label">Upload Images <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-images text-primary"></i>
                  </span>
                  <input type="file" class="form-control border-start-0" id="images" name="images[]" multiple accept="image/*" required>
                </div>
                <div class="form-text">You can upload multiple images. The first image will be set as primary image automatically.</div>
              </div>
              <div class="col-md-12">
                <div id="image-previews" class="row mt-3"></div>
              </div>
            </div>
            
            <h4 class="text-primary mb-3">Contact Information</h4>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label for="contact_name" class="form-label">Contact Name</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-user text-primary"></i>
                  </span>
                  <input type="text" class="form-control border-start-0" id="contact_name" name="contact_name" value="{{ old('contact_name', Auth::user()->name ?? '') }}" placeholder="Your name">
                </div>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="contact_phone" class="form-label">Contact Phone <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-phone text-primary"></i>
                  </span>
                  <input type="tel" class="form-control border-start-0" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', Auth::user()->phone ?? '') }}" required placeholder="Your phone number">
                </div>
              </div>
              
              <div class="col-md-12 mb-3">
                <label for="contact_email" class="form-label">Contact Email</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-envelope text-primary"></i>
                  </span>
                  <input type="email" class="form-control border-start-0" id="contact_email" name="contact_email" value="{{ old('contact_email', Auth::user()->email ?? '') }}" placeholder="Your email address">
                </div>
              </div>
            </div>
            
            <div class="form-check mb-4 p-3 bg-light rounded">
            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
             <label class="form-check-label" for="terms">
               I confirm that all information provided is accurate and I have the right to list this property.
             </label>
           </div>
           
           <div class="text-center">
             <button type="submit" class="btn btn-primary btn-lg px-5">
               <i class="fas fa-paper-plane me-2"></i> Submit Property
             </button>
           </div>
         </form>
       </div>
     </div>
   </div>
 </div>
</div>

<!-- Submission Confirmation Modal -->
<div class="modal fade" id="submissionModal" tabindex="-1" aria-labelledby="submissionModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered">
   <div class="modal-content">
     <div class="modal-header bg-success text-white">
       <h5 class="modal-title" id="submissionModalLabel"><i class="fas fa-check-circle me-2"></i> Property Submitted</h5>
       <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
     </div>
     <div class="modal-body text-center p-4">
       <div class="mb-4">
         <i class="fas fa-building fa-4x text-success mb-3"></i>
         <h4>Thank You!</h4>
         <p>Your property listing has been submitted successfully and is pending approval. Our team will review your listing and it will be published soon.</p>
       </div>
       <a href="{{ route('profile') }}" class="btn btn-success">Go to My Profile</a>
     </div>
   </div>
 </div>
</div>

@push('scripts')
<script>
 // Image preview functionality
 document.addEventListener('DOMContentLoaded', function() {
   // Show success modal if there's a success message
   if (document.querySelector('.alert-success')) {
     setTimeout(function() {
       var myModal = new bootstrap.Modal(document.getElementById('submissionModal'));
       myModal.show();
     }, 500);
   }
   
   // Image preview handler
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
             <div class="card h-100">
               <img src="${e.target.result}" class="card-img-top" alt="Preview" style="height: 150px; object-fit: cover;">
               <div class="card-body p-2 text-center">
                 ${i === 0 ? '<span class="badge bg-primary">Primary Image</span>' : '<span class="badge bg-secondary">Additional Image</span>'}
               </div>
             </div>
           `;
           document.getElementById('image-previews').appendChild(preview);
         }
         reader.readAsDataURL(file);
       }
     }
   });
   
   // Validate file input before form submission
   document.querySelector('form').addEventListener('submit', function(event) {
     const imageInput = document.getElementById('images');
     if (imageInput.files.length === 0) {
       event.preventDefault();
       alert('Please select at least one image for your property.');
       imageInput.focus();
     }
   });
 });
</script>
@endpush
@endsection