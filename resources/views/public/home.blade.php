@extends('layouts.public.app')

@section('title', 'Home')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="hero">
  <div class="hero-slide">
    <div class="img overlay" style="background-image: url('images/bg-1.jpg')"></div>
    <!-- <div class="img overlay" style="background-image: url('images/hero_bg_2.jpg')"></div>
    <div class="img overlay" style="background-image: url('images/hero_bg_1.jpg')"></div> -->
  </div>

  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-10 text-center">
        <h1 class="heading" data-aos="fade-up">
          Easiest way to find your dream home
        </h1>
      <!-- Replace the existing search bar with this upgraded version -->
<div class="container">
  <div class="row justify-content-center align-items-center">
    <div class="col-lg-10 text-center">
      <h1 class="heading" data-aos="fade-up">
        Easiest way to find your dream home
      </h1>
      <form action="{{ route('properties.index') }}" method="GET" class="property-search-form mt-5" data-aos="fade-up" data-aos-delay="200">
  <div class="search-container bg-white rounded-lg shadow p-4">
    <!-- Main Search Filters Row -->
    <div class="row g-3 mb-3">
      <!-- Property Type -->
      <div class="col-md-4">
        <div class="form-group">
          <label class="form-label small text-muted">Property Type</label>
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-building text-primary"></i>
            </span>
            <select class="form-select border-start-0" name="property_type">
              <option value="">All Types</option>
              @php
                $propertyTypes = App\Models\PropertyType::all();
              @endphp
              @foreach($propertyTypes as $type)
                <option value="{{ $type->id }}" {{ request('property_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      
      <!-- Location - Enhanced with Governorate and Area -->
      <div class="col-md-4">
        <div class="form-group">
          <label class="form-label small text-muted">Location</label>
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-map-marker-alt text-primary"></i>
            </span>
            <select class="form-select border-start-0" id="governorate" name="governorate_id">
              <option value="">All Governorates</option>
              @php
                $governorates = App\Models\Governorate::orderBy('name')->get();
              @endphp
              @foreach($governorates as $governorate)
                <option value="{{ $governorate->id }}" {{ request('governorate_id') == $governorate->id ? 'selected' : '' }}>{{ $governorate->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      
      <!-- Areas based on selected governorate -->
      <div class="col-md-4">
        <div class="form-group">
          <label class="form-label small text-muted">Area</label>
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-map text-primary"></i>
            </span>
            <select class="form-select border-start-0" id="area" name="area_id">
              <option value="">All Areas</option>
              @php
                $selectedGovernorate = request('governorate_id');
                $areas = $selectedGovernorate ? App\Models\Area::where('governorate_id', $selectedGovernorate)->orderBy('name')->get() : App\Models\Area::orderBy('name')->get();
              @endphp
              @foreach($areas as $area)
                <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }} data-governorate="{{ $area->governorate_id }}">{{ $area->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Second row with Purpose -->
    <div class="row g-3 mb-3">
      <!-- Purpose -->
      <div class="col-md-4">
        <div class="form-group">
          <label class="form-label small text-muted">Purpose</label>
          <div class="d-flex">
            <div class="form-check form-check-inline flex-grow-1">
              <input class="form-check-input" type="radio" name="purpose" id="purposeBuy" value="sale" {{ request('purpose') != 'rent' ? 'checked' : '' }}>
              <label class="form-check-label d-flex align-items-center justify-content-center bg-light rounded p-2 w-100" for="purposeBuy">
                <i class="fas fa-tag me-2 text-primary"></i> Buy
              </label>
            </div>
            <div class="form-check form-check-inline flex-grow-1">
              <input class="form-check-input" type="radio" name="purpose" id="purposeRent" value="rent" {{ request('purpose') == 'rent' ? 'checked' : '' }}>
              <label class="form-check-label d-flex align-items-center justify-content-center bg-light rounded p-2 w-100" for="purposeRent">
                <i class="fas fa-calendar-alt me-2 text-primary"></i> Rent
              </label>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Price Range -->
      <div class="col-md-8">
        <div class="form-group">
          <label class="form-label small text-muted">Price Range (JOD)</label>
          <div class="d-flex gap-2">
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-coins text-primary"></i>
              </span>
              <input type="number" class="form-control border-start-0" name="min_price" placeholder="Min" 
                     value="{{ request('min_price') }}" min="0" oninput="this.value = Math.abs(this.value)">
            </div>
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-coins text-primary"></i>
              </span>
              <input type="number" class="form-control border-start-0" name="max_price" placeholder="Max" 
                     value="{{ request('max_price') }}" min="0" oninput="this.value = Math.abs(this.value)">
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Third row with Beds and Baths -->
    <div class="row g-3 mb-3">
      <!-- Bedrooms -->
      <div class="col-md-4">
        <div class="form-group">
          <label class="form-label small text-muted">Bedrooms</label>
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-bed text-primary"></i>
            </span>
            <select class="form-select border-start-0" name="bedrooms">
              <option value="">Any</option>
              @for($i = 1; $i <= 6; $i++)
                <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>{{ $i }}+</option>
              @endfor
            </select>
          </div>
        </div>
      </div>
      
      <!-- Bathrooms -->
      <div class="col-md-4">
        <div class="form-group">
          <label class="form-label small text-muted">Bathrooms</label>
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-bath text-primary"></i>
            </span>
            <select class="form-select border-start-0" name="bathrooms">
              <option value="">Any</option>
              @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ request('bathrooms') == $i ? 'selected' : '' }}>{{ $i }}+</option>
              @endfor
            </select>
          </div>
        </div>
      </div>
      
      <!-- Property Size -->
      <div class="col-md-4">
        <div class="form-group">
          <label class="form-label small text-muted">Area (sq.ft)</label>
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-ruler-combined text-primary"></i>
            </span>
            <input type="number" class="form-control border-start-0" name="min_size" placeholder="Min Size" 
                   value="{{ request('min_size') }}" min="0" oninput="this.value = Math.abs(this.value)">
          </div>
        </div>
      </div>
    </div>
    
    <!-- Keywords and Search Button Row -->
    <div class="row g-3 align-items-end">
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary w-100 py-3">
          <i class="fas fa-search me-2"></i> Find Properties
        </button>
      </div>
    </div>
    
    <!-- Advanced Filters Toggle -->
    <div class="text-center mt-3">
      <a href="#advancedFilters" data-bs-toggle="collapse" class="text-decoration-none small">
        <i class="fas fa-sliders-h me-1"></i> Advanced Filters
        <i class="fas fa-chevron-down ms-1 small"></i>
      </a>
    </div>
    
    <!-- Advanced Filters Collapsible Section -->
    <div class="collapse mt-3" id="advancedFilters">
      <div class="card card-body border-0 bg-light">
        <div class="row g-3">
          <!-- Property Size - Max -->
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label small text-muted">Max Area (sq.ft)</label>
              <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                  <i class="fas fa-ruler-combined text-primary"></i>
                </span>
                <input type="number" class="form-control border-start-0" name="max_size" placeholder="Max Size" 
                       value="{{ request('max_size') }}" min="0" oninput="this.value = Math.abs(this.value)">
              </div>
            </div>
          </div>
          
          <!-- Year Built -->
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label small text-muted">Year Built</label>
              <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                  <i class="fas fa-calendar-alt text-primary"></i>
                </span>
                <select class="form-select border-start-0" name="year_built">
                  <option value="">Any Year</option>
                  @for ($year = date('Y'); $year >= 1990; $year--)
                    <option value="{{ $year }}" {{ request('year_built') == $year ? 'selected' : '' }}>{{ $year }}</option>
                  @endfor
                </select>
              </div>
            </div>
          </div>
          
          <!-- Features -->
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label small text-muted">Features</label>
              <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                  <i class="fas fa-star text-primary"></i>
                </span>
                <select class="form-select border-start-0" name="feature_id">
                  <option value="">Any Features</option>
                  @php
                    $features = App\Models\Feature::all();
                  @endphp
                  @foreach($features as $feature)
                    <option value="{{ $feature->id }}" {{ request('feature_id') == $feature->id ? 'selected' : '' }}>{{ $feature->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>


    </div>
  </div>
</div>

      </div>
    </div>
  </div>
</div>

<div class="section">
  <!-- Replace the existing Popular Properties section with this -->
<div class="section">
  <div class="container">
    <div class="row mb-5 align-items-center">
      <div class="col-lg-6">
        <h2 class="font-weight-bold text-primary heading">
          Popular Properties
        </h2>
      </div>
      <div class="col-lg-6 text-lg-end">
        <p>
          <a href="{{ url('/properties') }}" class="btn btn-primary text-white py-3 px-4">View all properties</a>
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="property-slider-wrap">
          <div class="property-slider">
            @php
            // Fetch popular properties from database
            // You can define "popular" based on view count, featured status, or a combination
            $popularProperties = App\Models\Property::where('is_approved', true)
                ->orderBy('is_featured', 'desc')
                ->orderBy('views', 'desc')
                ->take(8)
                ->get();
            @endphp

            @foreach($popularProperties as $property)
            <div class="property-item">
              <a href="{{ route('properties.show', $property->id) }}" class="img">
                @php
                  $primaryImage = $property->images->where('is_primary', true)->first();
                  $fallbackImage = $property->images->first();
                  $imagePath = null;
                  
                  if ($primaryImage && file_exists(public_path('storage/' . $primaryImage->image_path))) {
                    $imagePath = asset('storage/' . $primaryImage->image_path);
                  } elseif ($fallbackImage && file_exists(public_path('storage/' . $fallbackImage->image_path))) {
                    $imagePath = asset('storage/' . $fallbackImage->image_path);
                  } else {
                    $imagePath = asset('images/default-property.jpg');
                  }
                @endphp
                <img src="{{ $imagePath }}" alt="{{ $property->title }}" class="img-fluid" />
              </a>

              <div class="property-content">
                <div class="price mb-2"><span>{{ number_format($property->price) }} JOD</span></div>
                <div>
                  <span class="d-block mb-2 text-black-50">{{ \Illuminate\Support\Str::limit($property->address, 30) }}</span>
                  <span class="city d-block mb-3">{{ $property->area->name ?? 'Amman' }}, Jordan</span>

                  <div class="specs d-flex mb-4">
                    <span class="d-block d-flex align-items-center me-3">
                      <span class="icon-bed me-2"></span>
                      <span class="caption">{{ $property->bedrooms ?? '0' }} beds</span>
                    </span>
                    <span class="d-block d-flex align-items-center">
                      <span class="icon-bath me-2"></span>
                      <span class="caption">{{ $property->bathrooms ?? '0' }} baths</span>
                    </span>
                  </div>

                  <a href="{{ route('properties.show', $property->id) }}" class="btn btn-primary py-2 px-3">See details</a>
                </div>
              </div>
            </div>
            @endforeach
            
            <!-- If no properties are found, display some placeholders -->
            @if($popularProperties->isEmpty())
              @for($i = 0; $i < 4; $i++)
              <div class="property-item">
                <a href="#" class="img">
                  <img src="{{ asset('images/img_' . ($i+1) . '.jpg') }}" alt="Property Image" class="img-fluid" />
                </a>
                <div class="property-content">
                  <div class="price mb-2"><span>250,000 JOD</span></div>
                  <div>
                    <span class="d-block mb-2 text-black-50">Example Address, Sample Location</span>
                    <span class="city d-block mb-3">Amman, Jordan</span>
                    <div class="specs d-flex mb-4">
                      <span class="d-block d-flex align-items-center me-3">
                        <span class="icon-bed me-2"></span>
                        <span class="caption">3 beds</span>
                      </span>
                      <span class="d-block d-flex align-items-center">
                        <span class="icon-bath me-2"></span>
                        <span class="caption">2 baths</span>
                      </span>
                    </div>
                    <a href="{{ url('/properties') }}" class="btn btn-primary py-2 px-3">Browse Properties</a>
                  </div>
                </div>
              </div>
              @endfor
            @endif
          </div>

          <div id="property-nav" class="controls" tabindex="0" aria-label="Carousel Navigation">
            <span class="prev" data-controls="prev" aria-controls="property" tabindex="-1">Prev</span>
            <span class="next" data-controls="next" aria-controls="property" tabindex="-1">Next</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<!-- Sell Your Property CTA Section -->
<div class="section bg-primary py-5">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-7 mb-4 mb-lg-0">
        <div class="text-white">
          <h2 class="font-weight-bold mb-3">List Your Property With Us</h2>
          <p class="mb-4 lead">Are you a property owner? Join our platform and reach thousands of potential buyers or tenants. Our user-friendly listing process makes it easy to showcase your property to the right audience.</p>
          <ul class="list-unstyled mb-4">
            <li class="d-flex align-items-center mb-2">
              <span class="icon-check me-2 text-white"></span>
              <span>Free listing for basic properties</span>
            </li>
            <li class="d-flex align-items-center mb-2">
              <span class="icon-check me-2 text-white"></span>
              <span>Professional photography services available</span>
            </li>
            <li class="d-flex align-items-center">
              <span class="icon-check me-2 text-white"></span>
              <span>Dedicated support team to help you through the process</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 text-center text-lg-end">
        <div class="bg-white p-4 rounded shadow-lg">
          <h3 class="text-primary mb-3">List Your Property Today</h3>
          <p class="text-dark mb-4">Join our network of property sellers and find the perfect buyer for your property.</p>
          @if(Auth::check())
            @if(Auth::user()->user_type === 'seller')
              <a href="{{ url('/properties/create') }}" class="btn btn-primary btn-lg w-100 py-3">Add New Property</a>
            @else
              <a href="{{ url('/seller-register') }}" class="btn btn-primary btn-lg w-100 py-3">Become a Seller</a>
            @endif
          @else
            <a href="{{ url('/seller-register') }}?user_type=seller" class="btn btn-primary btn-lg w-100 py-3"></a>
            <p class="mt-3 small">Already have an account? <a href="{{ route('login') }}?redirect=properties/create" class="text-primary">Login</a>Add New Property</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<section class="features-1">
  <div class="container">
    <div class="row">
      <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
        <div class="box-feature">
          <span class="flaticon-house"></span>
          <h3 class="mb-3">Our Properties</h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Voluptates, accusamus.
          </p>
          <p><a href="#" class="learn-more">Learn More</a></p>
        </div>
      </div>
      <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="500">
        <div class="box-feature">
          <span class="flaticon-building"></span>
          <h3 class="mb-3">Property for Sale</h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Voluptates, accusamus.
          </p>
          <p><a href="#" class="learn-more">Learn More</a></p>
        </div>
      </div>
      <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
        <div class="box-feature">
          <span class="flaticon-house-3"></span>
          <h3 class="mb-3">Real Estate Agent</h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Voluptates, accusamus.
          </p>
          <p><a href="#" class="learn-more">Learn More</a></p>
        </div>
      </div>
      <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="600">
        <div class="box-feature">
          <span class="flaticon-house-1"></span>
          <h3 class="mb-3">House for Sale</h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Voluptates, accusamus.
          </p>
          <p><a href="#" class="learn-more">Learn More</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="section sec-testimonials">
  <div class="container">
    <div class="row mb-5 align-items-center">
      <div class="col-md-6">
        <h2 class="font-weight-bold heading text-primary mb-4 mb-md-0">
          Customer Says
        </h2>
      </div>
      <div class="col-md-6 text-md-end">
        <div id="testimonial-nav">
          <span class="prev" data-controls="prev">Prev</span>

          <span class="next" data-controls="next">Next</span>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4"></div>
    </div>
    <div class="testimonial-slider-wrap">
      <div class="testimonial-slider">
        <div class="item">
          <div class="testimonial">
            <img src="images/person_1-min.jpg" alt="Image" class="img-fluid rounded-circle w-25 mb-4" />
            <div class="rate">
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
            </div>
            <h3 class="h5 text-primary mb-4">James Smith</h3>
            <blockquote>
              <p>
                &ldquo;Far far away, behind the word mountains, far from the
                countries Vokalia and Consonantia, there live the blind
                texts. Separated they live in Bookmarksgrove right at the
                coast of the Semantics, a large language ocean.&rdquo;
              </p>
            </blockquote>
            <p class="text-black-50">Designer, Co-founder</p>
          </div>
        </div>

        <div class="item">
          <div class="testimonial">
            <img src="images/person_2-min.jpg" alt="Image" class="img-fluid rounded-circle w-25 mb-4" />
            <div class="rate">
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
            </div>
            <h3 class="h5 text-primary mb-4">Mike Houston</h3>
            <blockquote>
              <p>
                &ldquo;Far far away, behind the word mountains, far from the
                countries Vokalia and Consonantia, there live the blind
                texts. Separated they live in Bookmarksgrove right at the
                coast of the Semantics, a large language ocean.&rdquo;
              </p>
            </blockquote>
            <p class="text-black-50">Designer, Co-founder</p>
          </div>
        </div>

        <div class="item">
          <div class="testimonial">
            <img src="images/person_3-min.jpg" alt="Image" class="img-fluid rounded-circle w-25 mb-4" />
            <div class="rate">
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
            </div>
            <h3 class="h5 text-primary mb-4">Cameron Webster</h3>
            <blockquote>
              <p>
                &ldquo;Far far away, behind the word mountains, far from the
                countries Vokalia and Consonantia, there live the blind
                texts. Separated they live in Bookmarksgrove right at the
                coast of the Semantics, a large language ocean.&rdquo;
              </p>
            </blockquote>
            <p class="text-black-50">Designer, Co-founder</p>
          </div>
        </div>

        <div class="item">
          <div class="testimonial">
            <img src="images/person_4-min.jpg" alt="Image" class="img-fluid rounded-circle w-25 mb-4" />
            <div class="rate">
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
              <span class="icon-star text-warning"></span>
            </div>
            <h3 class="h5 text-primary mb-4">Dave Smith</h3>
            <blockquote>
              <p>
                &ldquo;Far far away, behind the word mountains, far from the
                countries Vokalia and Consonantia, there live the blind
                texts. Separated they live in Bookmarksgrove right at the
                coast of the Semantics, a large language ocean.&rdquo;
              </p>
            </blockquote>
            <p class="text-black-50">Designer, Co-founder</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="section section-4 bg-light">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-5">
        <h2 class="font-weight-bold heading text-primary mb-4">
          Let's find home that's perfect for you
        </h2>
        <p class="text-black-50">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam
          enim pariatur similique debitis vel nisi qui reprehenderit.
        </p>
      </div>
    </div>
    <div class="row justify-content-between mb-5">
      <div class="col-lg-7 mb-5 mb-lg-0 order-lg-2">
        <div class="img-about dots">
          <img src="images/hero_bg_3.jpg" alt="Image" class="img-fluid" />
        </div>
      </div>
      <div class="col-lg-4">
        <div class="d-flex feature-h">
          <span class="wrap-icon me-3">
            <span class="icon-home2"></span>
          </span>
          <div class="feature-text">
            <h3 class="heading">2M Properties</h3>
            <p class="text-black-50">
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Nostrum iste.
            </p>
          </div>
        </div>

        <div class="d-flex feature-h">
          <span class="wrap-icon me-3">
            <span class="icon-person"></span>
          </span>
          <div class="feature-text">
            <h3 class="heading">Top Rated Agents</h3>
            <p class="text-black-50">
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Nostrum iste.
            </p>
          </div>
        </div>

        <div class="d-flex feature-h">
          <span class="wrap-icon me-3">
            <span class="icon-security"></span>
          </span>
          <div class="feature-text">
            <h3 class="heading">Legit Properties</h3>
            <p class="text-black-50">
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Nostrum iste.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="row section-counter mt-5">
      <div class="col-6 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
        <div class="counter-wrap mb-5 mb-lg-0">
          <span class="number"><span class="countup text-primary">3298</span></span>
          <span class="caption text-black-50"># of Buy Properties</span>
        </div>
      </div>
      <div class="col-6 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
        <div class="counter-wrap mb-5 mb-lg-0">
          <span class="number"><span class="countup text-primary">2181</span></span>
          <span class="caption text-black-50"># of Sell Properties</span>
        </div>
      </div>
      <div class="col-6 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="500">
        <div class="counter-wrap mb-5 mb-lg-0">
          <span class="number"><span class="countup text-primary">9316</span></span>
          <span class="caption text-black-50"># of All Properties</span>
        </div>
      </div>
      <div class="col-6 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="600">
        <div class="counter-wrap mb-5 mb-lg-0">
          <span class="number"><span class="countup text-primary">7191</span></span>
          <span class="caption text-black-50"># of Agents</span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="section">
  <div class="row justify-content-center footer-cta" data-aos="fade-up">
    <div class="col-lg-7 mx-auto text-center">
      <h2 class="mb-4">Be a part of our growing real state agents</h2>
      <p>
        <a href="#" target="_blank" class="btn btn-primary text-white py-3 px-4">Apply for Real Estate agent</a>
      </p>
    </div>
    <!-- /.col-lg-7 -->
  </div>
  <!-- /.row -->
</div>

<div class="section section-5 bg-light">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-6 mb-5">
        <h2 class="font-weight-bold heading text-primary mb-4">
          Our Agents
        </h2>
        <p class="text-black-50">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam
          enim pariatur similique debitis vel nisi qui reprehenderit totam?
          Quod maiores.
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0">
        <div class="h-100 person">
          <img src="images/person_1-min.jpg" alt="Image" class="img-fluid" />

          <div class="person-contents">
            <h2 class="mb-0"><a href="#">James Doe</a></h2>
            <span class="meta d-block mb-3">Real Estate Agent</span>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Facere officiis inventore cumque tenetur laboriosam, minus
              culpa doloremque odio, neque molestias?
            </p>

            <ul class="social list-unstyled list-inline dark-hover">
              <li class="list-inline-item">
                <a href="#"><span class="icon-twitter"></span></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><span class="icon-facebook"></span></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><span class="icon-linkedin"></span></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><span class="icon-instagram"></span></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0">
        <div class="h-100 person">
          <img src="images/person_2-min.jpg" alt="Image" class="img-fluid" />

          <div class="person-contents">
            <h2 class="mb-0"><a href="#">Jean Smith</a></h2>
            <span class="meta d-block mb-3">Real Estate Agent</span>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Facere officiis inventore cumque tenetur laboriosam, minus
              culpa doloremque odio, neque molestias?
            </p>

            <ul class="social list-unstyled list-inline dark-hover">
              <li class="list-inline-item">
                <a href="#"><span class="icon-twitter"></span></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><span class="icon-facebook"></span></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><span class="icon-linkedin"></span></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><span class="icon-instagram"></span></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0">
        <div class="h-100 person">
          <img src="images/person_3-min.jpg" alt="Image" class="img-fluid" />

          <div class="person-contents">
            <h2 class="mb-0"><a href="#">Alicia Huston</a></h2>
            <span class="meta d-block mb-3">Real Estate Agent</span>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Facere officiis inventore cumque tenetur laboriosam, minus
              culpa doloremque odio, neque molestias?
            </p>

            <ul class="social list-unstyled list-inline dark-hover">
              <li class="list-inline-item">
                <a href="#"><span class="icon-twitter"></span></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><span class="icon-facebook"></span></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><span class="icon-linkedin"></span></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><span class="icon-instagram"></span></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div> <!-- نهاية hero section -->


@push('scripts')
<script>
// JavaScript to prevent negative values
document.addEventListener('DOMContentLoaded', function() {
    const numberInputs = document.querySelectorAll('input[type="number"][min="0"]');
    
    numberInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value < 0) {
                this.value = 0;
            }
        });
    });

    // Governorate-Area dynamic dropdown
    const governorateSelect = document.getElementById('governorate');
    const areaSelect = document.getElementById('area');

    if (governorateSelect && areaSelect) {
        governorateSelect.addEventListener('change', function() {
            const governorateId = this.value;
            const areaOptions = areaSelect.querySelectorAll('option');
            
            areaOptions.forEach(option => {
                if (option.value === "" || option.dataset.governorate === governorateId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
            
            areaSelect.value = "";
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
  const governorateSelect = document.getElementById('governorate');
  const areaSelect = document.getElementById('area');
  
  // نسخ جميع خيارات المناطق في مصفوفة للاستخدام لاحقًا
  const areaOptions = Array.from(areaSelect.options);
  
  // دالة لتصفية المناطق بناءً على المحافظة المختارة
  function filterAreas() {
    const selectedGovernorate = governorateSelect.value;
    
    // مسح الخيارات الحالية
    areaSelect.innerHTML = '';
    
    // إضافة خيار "كل المناطق"
    const allOption = document.createElement('option');
    allOption.value = '';
    allOption.textContent = 'All Areas';
    areaSelect.appendChild(allOption);
    
    // تصفية وإضافة المناطق ذات الصلة
    if (selectedGovernorate) {
      // إضافة المناطق التابعة للمحافظة المختارة فقط
      areaOptions
        .filter(option => option.dataset.governorate === selectedGovernorate || option.value === '')
        .forEach(option => {
          areaSelect.appendChild(option.cloneNode(true));
        });
    } else {
      // إضافة جميع المناطق إذا لم يتم اختيار محافظة
      areaOptions.forEach(option => {
        areaSelect.appendChild(option.cloneNode(true));
      });
    }
    
    // استعادة المنطقة المحددة مسبقًا إذا كانت تطابق المحافظة الحالية
    const previouslySelectedArea = "{{ request('area_id') }}";
    if (previouslySelectedArea) {
      // التحقق مما إذا كانت المنطقة المحددة مسبقًا صالحة للمحافظة الحالية
      const matchingOption = areaOptions.find(option => 
        option.value === previouslySelectedArea && 
        (!selectedGovernorate || option.dataset.governorate === selectedGovernorate)
      );
      
      if (matchingOption) {
        areaSelect.value = previouslySelectedArea;
      }
    }
  }
  
  // التصفية الأولية
  filterAreas();
  
  // إضافة مستمع حدث للتغيير
  governorateSelect.addEventListener('change', filterAreas);
});
</script>
@endpush



@endsection

