@extends('layouts.public.app')

@section('title', 'Share Your Experience')

@section('content')

<div class="section py-5 bg-light" style="margin-top: 100px;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="testimonial-form bg-white p-4 p-md-5 rounded-3 shadow">
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Thank you!</strong> {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <h2 class="h3 text-center mb-4" style="color: #2c3e50;">Tell Us About Your Experience</h2>
          <p class="text-center mb-4" style="color: #7f8c8d;">Your feedback helps us improve our services and assists other users in finding their perfect property.</p>
          
          <form action="{{ route('testimonials.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="name" class="form-label">Your Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" 
                         id="name" name="name" value="{{ old('name') }}" required>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="position" class="form-label">Your Profession/Title</label>
                  <input type="text" class="form-control @error('position') is-invalid @enderror" 
                         id="position" name="position" value="{{ old('position') }}" 
                         placeholder="e.g. Business Owner, Engineer, etc.">
                  @error('position')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="email" class="form-label">Your Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" 
                         id="email" name="email" value="{{ old('email') }}" 
                         required placeholder="For verification only, won't be published">
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <small class="text-muted">We'll never share your email with anyone else.</small>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="area_id" class="form-label">Area You Bought/Rented In</label>
                  <select class="form-select @error('area_id') is-invalid @enderror" 
                          id="area_id" name="area_id">
                    <option value="">Select Area (Optional)</option>
                    @php
                      $governorates = App\Models\Governorate::orderBy('name')->with(['areas' => function($query) {
                          $query->orderBy('name');
                      }])->get();
                    @endphp
                    
                    @foreach($governorates as $governorate)
                      <optgroup label="{{ $governorate->name }}">
                        @foreach($governorate->areas as $area)
                          <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                            {{ $area->name }}
                          </option>
                        @endforeach
                      </optgroup>
                    @endforeach
                  </select>
                  @error('area_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              
              <div class="col-12 mb-4">
                <div class="form-group">
                  <label class="form-label">Rate Your Experience <span class="text-danger">*</span></label>
                  
                  <div class="d-flex flex-wrap gap-2">
                    <div class="rating-option">
                      <input type="radio" class="btn-check" name="rating" id="rating5" value="5" autocomplete="off" 
                             {{ old('rating', 5) == 5 ? 'checked' : '' }}>
                      <label class="btn btn-outline-success" for="rating5">
                        <i class="fas fa-star me-1"></i> Excellent
                      </label>
                    </div>
                    
                    <div class="rating-option">
                      <input type="radio" class="btn-check" name="rating" id="rating4" value="4" autocomplete="off" 
                             {{ old('rating') == 4 ? 'checked' : '' }}>
                      <label class="btn btn-outline-success" for="rating4">
                        <i class="fas fa-star me-1"></i> Very Good
                      </label>
                    </div>
                    
                    <div class="rating-option">
                      <input type="radio" class="btn-check" name="rating" id="rating3" value="3" autocomplete="off" 
                             {{ old('rating') == 3 ? 'checked' : '' }}>
                      <label class="btn btn-outline-secondary" for="rating3">
                        <i class="fas fa-star me-1"></i> Good
                      </label>
                    </div>
                    
                    <div class="rating-option">
                      <input type="radio" class="btn-check" name="rating" id="rating2" value="2" autocomplete="off" 
                             {{ old('rating') == 2 ? 'checked' : '' }}>
                      <label class="btn btn-outline-warning" for="rating2">
                        <i class="fas fa-star me-1"></i> Fair
                      </label>
                    </div>
                    
                    <div class="rating-option">
                      <input type="radio" class="btn-check" name="rating" id="rating1" value="1" autocomplete="off" 
                             {{ old('rating') == 1 ? 'checked' : '' }}>
                      <label class="btn btn-outline-danger" for="rating1">
                        <i class="fas fa-star me-1"></i> Poor
                      </label>
                    </div>
                  </div>
                  
                  @error('rating')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              
              <div class="col-12 mb-3">
                <div class="form-group">
                  <label for="content" class="form-label">Your Experience <span class="text-danger">*</span></label>
                  <textarea class="form-control @error('content') is-invalid @enderror" 
                           id="content" name="content" rows="5" required
                           placeholder="Tell us about your experience searching for, buying, or renting your property...">{{ old('content') }}</textarea>
                  @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              
              <div class="col-12 mb-4">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input @error('consent') is-invalid @enderror" 
                         id="consent" name="consent" {{ old('consent') ? 'checked' : '' }} required>
                  <label class="form-check-label" for="consent">
                    I agree to have my testimonial displayed on the website. <span class="text-danger">*</span>
                  </label>
                  @error('consent')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary px-4 py-2 submit-btn">
                  <i class=" me-2"></i> Submit Your Testimonial
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  :root {
    --primary-color: #2c3e50;
    --secondary-color: #34495e;
    --accent-color: #3498db;
    --text-color: #7f8c8d;
    --light-bg: #ecf0f1;
  }
  
  body {
    background-color: var(--light-bg);
  }
  
  .testimonial-form {
    border: 1px solid rgba(0,0,0,0.1);
    transition: all 0.3s ease;
  }
  
  .testimonial-form:hover {
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  }
  
  .form-control, .form-select {
    border-radius: 0.375rem;
    border: 1px solid #ced4da;
    padding: 0.5rem 1rem;
  }
  
  .form-control:focus, .form-select:focus {
    border-color: var(--accent-color);
    box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
  }
  
  .rating-option .btn {
    border-radius: 0.375rem;
    transition: all 0.2s;
    font-weight: 500;
  }
  
  .rating-option .btn:hover {
    transform: translateY(-2px);
  }
  
  .rating-option .btn-check:checked + .btn {
    color: white;
  }
  
  .rating-option .btn-check:checked + .btn-outline-success {
    background-color: var(--bs-success);
  }
  
  .rating-option .btn-check:checked + .btn-outline-secondary {
    background-color: var(--bs-secondary);
  }
  
  .rating-option .btn-check:checked + .btn-outline-warning {
    background-color: var(--bs-warning);
  }
  
  .rating-option .btn-check:checked + .btn-outline-danger {
    background-color: var(--bs-danger);
  }
  
  .submit-btn {
    background-color: var(--primary-color);
    border: none;
    padding: 0.75rem 2rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
  }
  
  .submit-btn:hover {
    background-color: var(--secondary-color);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(44, 62, 80, 0.3);
  }
  
  @media (max-width: 767.98px) {
    .rating-option {
      width: 100%;
    }
    
    .rating-option .btn {
      width: 100%;
      margin-bottom: 0.5rem;
    }
  }
</style>
@endpush

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // إضافة تأثيرات للعناصر عند التركيز
    const inputs = document.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
      });
      
      input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
      });
    });
  });
</script>
@endpush