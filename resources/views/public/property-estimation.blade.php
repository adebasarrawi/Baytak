@extends('layouts.public.app')

@section('title', 'Estimate Your Property')

@section('content')
<div class="hero page-inner overlay">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">Estimate Your Property</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">Property Valuation</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<div class="section">
  <div class="container">
    <div class="row mb-5 align-items-center">
      <div class="col-lg-6 text-center mx-auto">
        <h2 class="font-weight-bold text-primary heading">Get an Instant Estimate of Your Property Value</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="property-estimation-tabs">
          <ul class="nav nav-tabs nav-fill mb-0" id="estimationTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="estimate-tab" data-bs-toggle="tab" data-bs-target="#estimate-tab-pane" type="button" role="tab" aria-controls="estimate-tab-pane" aria-selected="true">
                <i class="fas fa-calculator me-2"></i> Instant Estimate
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="booking-tab" data-bs-toggle="tab" data-bs-target="#booking-tab-pane" type="button" role="tab" aria-controls="booking-tab-pane" aria-selected="false">
                <i class="fas fa-calendar-check me-2"></i> Book a Professional Appraiser
              </button>
            </li>
          </ul>
          
          <div class="tab-content p-4 border border-top-0 rounded-bottom shadow-sm" id="estimationTabContent">
            <!-- Estimation Form Tab -->
            <div class="tab-pane fade show active" id="estimate-tab-pane" role="tabpanel" aria-labelledby="estimate-tab" tabindex="0">
              <div class="row">
                <div class="col-md-7">
                  <form id="estimationForm" class="p-3">
                    <div class="bg-light p-4 rounded mb-4">
                      <h4 class="mb-3 text-primary">Property Information</h4>
                      
                      <div class="row g-3">
                        <div class="col-md-6 mb-3">
                          <label for="propertyType" class="form-label">Property Type</label>
                          <select class="form-select" id="propertyType" required>
                            <option value="">Choose...</option>
                            <option value="apartment">Apartment</option>
                            <option value="house">House</option>
                            <option value="villa">Villa</option>
                            <option value="commercial">Commercial</option>
                            <option value="land">Land</option>
                          </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                          <label for="neighborhood" class="form-label">Neighborhood/Area</label>
                          <select class="form-select" id="neighborhood" required>
                            <option value="">Choose...</option>
                            <option value="abdali">Abdali</option>
                            <option value="abdoun">Abdoun</option>
                            <option value="dabouq">Dabouq</option>
                            <option value="shmisani">Shmisani</option>
                            <option value="sweifieh">Sweifieh</option>
                            <option value="jabal_amman">Jabal Amman</option>
                            <option value="jabal_hussein">Jabal Hussein</option>
                            <option value="gardens">Gardens</option>
                            <option value="other">Other</option>
                          </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                          <label for="propertyAge" class="form-label">Property Age (Years)</label>
                          <input type="number" class="form-control" id="propertyAge" min="0" max="100" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                          <label for="area" class="form-label">Total Area (sqm)</label>
                          <input type="number" class="form-control" id="area" min="1" required>
                        </div>
                      </div>
                    </div>
                    
                    <div class="bg-light p-4 rounded mb-4">
                      <h4 class="mb-3 text-primary">Property Details</h4>
                      
                      <div class="row g-3">
                        <div class="col-md-4 mb-3">
                          <label for="bedrooms" class="form-label">Bedrooms</label>
                          <input type="number" class="form-control" id="bedrooms" min="0" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                          <label for="bathrooms" class="form-label">Bathrooms</label>
                          <input type="number" class="form-control" id="bathrooms" min="0" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                          <label for="floors" class="form-label">Number of Floors</label>
                          <input type="number" class="form-control" id="floors" min="1" value="1" required>
                        </div>
                      </div>
                      
                      <div class="mb-3">
                        <label class="form-label">Additional Features</label>
                        <div class="row g-2">
                          <div class="col-md-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="hasGarage">
                              <label class="form-check-label" for="hasGarage">Garage/Parking</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="hasGarden">
                              <label class="form-check-label" for="hasGarden">Garden</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="hasSwimmingPool">
                              <label class="form-check-label" for="hasSwimmingPool">Swimming Pool</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="hasBalcony">
                              <label class="form-check-label" for="hasBalcony">Balcony</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="hasElevator">
                              <label class="form-check-label" for="hasElevator">Elevator</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="isFurnished">
                              <label class="form-check-label" for="isFurnished">Furnished</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="bg-light p-4 rounded mb-4">
                      <h4 class="mb-3 text-primary">Land & Legal Information</h4>
                      
                      <div class="row g-3">
                        <div class="col-md-6 mb-3">
                          <label for="landClassification" class="form-label">Land Classification</label>
                          <select class="form-select" id="landClassification">
                            <option value="">Choose...</option>
                            <option value="residential">Residential</option>
                            <option value="commercial">Commercial</option>
                            <option value="industrial">Industrial</option>
                            <option value="agricultural">Agricultural</option>
                            <option value="mixed">Mixed Use</option>
                          </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                          <label for="registrationType" class="form-label">Registration Type</label>
                          <select class="form-select" id="registrationType">
                            <option value="">Choose...</option>
                            <option value="tabu">Tabu (Title Deed)</option>
                            <option value="mushtarak">Mushtarak (Shared)</option>
                            <option value="ifrazi">Ifrazi (Segregated)</option>
                            <option value="other">Other</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    
                    <div class="text-center mt-4">
                      <button type="button" id="calculateEstimateBtn" class="btn btn-primary btn-lg px-5 py-2">
                        <i class="fas fa-calculator me-2"></i> Calculate Estimate
                      </button>
                    </div>
                  </form>
                </div>
                
                <div class="col-md-5">
                  <div class="p-3">
                    <div id="estimationResult" class="bg-white rounded shadow-sm p-4 mb-4 d-none">
                      <h3 class="text-center mb-4">Estimated Property Value</h3>
                      
                      <div class="text-center mb-4">
                        <span class="display-4 text-primary fw-bold" id="estimatedValue">JOD 0</span>
                        <p class="text-muted">Estimated Market Value</p>
                      </div>
                      
                      <div class="d-flex justify-content-between mb-3">
                        <span>Value Range:</span>
                        <span class="fw-bold" id="valueRange">JOD 0 - JOD 0</span>
                      </div>
                      
                      <div class="d-flex justify-content-between mb-3">
                        <span>Price per sqm:</span>
                        <span class="fw-bold" id="pricePerSqm">JOD 0</span>
                      </div>
                      
                      <hr>
                      
                      <div class="alert alert-info mb-4">
                        <div class="d-flex">
                          <div class="me-3">
                            <i class="fas fa-info-circle fa-2x text-primary"></i>
                          </div>
                          <div>
                            <h5 class="alert-heading">This is a preliminary estimate</h5>
                            <p class="mb-0">For a comprehensive and accurate valuation, we recommend booking a professional property appraiser.</p>
                          </div>
                        </div>
                      </div>
                      
                      <div class="text-center">
                        <button type="button" class="btn btn-outline-primary btn-lg book-appraiser-btn" data-bs-toggle="tab" data-bs-target="#booking-tab-pane">
                          <i class="fas fa-user-tie me-2"></i> Book a Professional Appraiser
                        </button>
                      </div>
                    </div>
                    
                    <div class="bg-light rounded p-4">
                      <h4 class="mb-3 text-primary">Why Get a Professional Valuation?</h4>
                      <ul class="list-unstyled mb-0">
                        <li class="d-flex mb-3">
                          <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                          <div>
                            <strong>Accuracy:</strong> Get a precise valuation based on a thorough inspection.
                          </div>
                        </li>
                        <li class="d-flex mb-3">
                          <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                          <div>
                            <strong>Expertise:</strong> Our appraisers have extensive knowledge of the local market.
                          </div>
                        </li>
                        <li class="d-flex mb-3">
                          <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                          <div>
                            <strong>Documentation:</strong> Receive an official valuation report for legal purposes.
                          </div>
                        </li>
                        <li class="d-flex mb-3">
                          <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                          <div>
                            <strong>Negotiation:</strong> Strong position when selling or refinancing.
                          </div>
                        </li>
                        <li class="d-flex">
                          <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                          <div>
                            <strong>Investment:</strong> Make informed decisions based on accurate data.
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Booking Tab -->
            <div class="tab-pane fade" id="booking-tab-pane" role="tabpanel" aria-labelledby="booking-tab" tabindex="0">
              <div class="row">
                <div class="col-lg-7">
                  @if(Auth::check())
                  <!-- User is logged in, show booking form -->
                  <form id="bookingForm" class="p-3">
                    @csrf
                    <div class="bg-light p-4 rounded mb-4">
                      <h4 class="mb-3 text-primary">Select an Appraiser</h4>
                      
                      <div class="appraiser-selection mb-4">
                        <div class="row g-3">
                          @forelse($appraisers as $appraiser)
                          <div class="col-md-6 mb-3">
                            <div class="card appraiser-card h-100">
                              <input type="radio" name="appraiser_id" id="appraiser{{ $appraiser->id }}" 
                                     value="{{ $appraiser->id }}" class="d-none appraiser-radio">
                              <label for="appraiser{{ $appraiser->id }}" class="card-body d-flex flex-column h-100 cursor-pointer">
                                <div class="d-flex align-items-center mb-3">
                                  <img src="{{ $appraiser->profile_image ?? asset('images/default-avatar.jpg') }}" 
                                       alt="{{ $appraiser->name }}" class="rounded-circle me-3" width="60" height="60">
                                  <div>
                                    <h5 class="card-title mb-0">{{ $appraiser->name }}</h5>
                                    <div class="text-warning mb-1">
                                      @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($appraiser->rating))
                                          <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $appraiser->rating))
                                          <i class="fas fa-star-half-alt"></i>
                                        @else
                                          <i class="far fa-star"></i>
                                        @endif
                                      @endfor
                                      <span class="text-muted ms-1">({{ number_format($appraiser->rating, 1) }})</span>
                                    </div>
                                    <span class="badge d-inline-block  bg-primary">{{ $appraiser->specialty }}</span>
                                  </div>
                                </div>
                                <p class="card-text  bio flex-grow-1 ">{{ $appraiser->bio }}</p>
                                <div class="text-muted small">
                                  <i class="fas fa-certificate text-success me-1"></i> 
                                  {{ $appraiser->certification }}
                                </div>
                              </label>
                            </div>
                          </div>
                          @empty
                          <div class="col-12 text-center py-4">
                            <div class="alert alert-info">
                              <i class="fas fa-info-circle me-2"></i> 
                              No appraisers currently available. Please contact us for more information.
                            </div>
                          </div>
                          @endforelse
                        </div>
                      </div>
                    </div>
                    <div class="bg-light p-4 rounded mb-4">
  <h4 class="mb-3 text-primary">Schedule Appointment</h4>
  
  <div class="row g-3">
    <div class="col-md-6 mb-3">
      <label for="appointment_date" class="form-label">Preferred Date</label>
      <input type="date" class="form-control" id="appointment_date" name="appointment_date" min="{{ date('Y-m-d') }}" required>
    </div>
    
    <div class="col-md-6 mb-3">
      <label for="appointment_time" class="form-label">Preferred Time</label>
      <select class="form-select" id="appointment_time" name="appointment_time" required>
        <option value="">Choose...</option>
        <optgroup label="Morning">
          <option value="09:00">9:00 AM</option>
          <option value="10:00">10:00 AM</option>
          <option value="11:00">11:00 AM</option>
          <option value="12:00">12:00 PM</option>
        </optgroup>
        <optgroup label="Afternoon">
          <option value="13:00">1:00 PM</option>
          <option value="14:00">2:00 PM</option>
          <option value="15:00">3:00 PM</option>
          <option value="16:00">4:00 PM</option>
        </optgroup>
      </select>
    </div>
    
    <div class="col-md-12 mb-3">
      <label for="property_address" class="form-label">Property Address</label>
      <textarea class="form-control" id="property_address" name="property_address" rows="3" required></textarea>
    </div>
    
    <div class="col-md-12 mb-3">
      <label for="property_type" class="form-label">Property Type</label>
      <select class="form-select" id="property_type" name="property_type">
        <option value="">-- Select Property Type --</option>
        <option value="apartment">Apartment</option>
        <option value="house">House</option>
        <option value="villa">Villa</option>
        <option value="commercial">Commercial</option>
        <option value="land">Land</option>
      </select>
    </div>
    
    <div class="col-md-6 mb-3">
      <label for="client_name" class="form-label">Your Name</label>
      <input type="text" class="form-control" id="client_name" name="client_name" value="{{ Auth::user()->name }}" required>
    </div>
    
    <div class="col-md-6 mb-3">
      <label for="client_phone" class="form-label">Phone Number</label>
      <input type="tel" class="form-control" id="client_phone" name="client_phone" value="{{ Auth::user()->phone ?? '' }}" required>
    </div>
    
    <div class="col-md-12 mb-3">
      <label for="client_email" class="form-label">Email</label>
      <input type="email" class="form-control" id="client_email" name="client_email" value="{{ Auth::user()->email }}" required>
    </div>
    
    
    
    <!-- Hidden fields for property details from the instant estimate -->
    <input type="hidden" id="property_area" name="property_area" value="">
    <input type="hidden" id="bedrooms_count" name="bedrooms" value="">
    <input type="hidden" id="bathrooms_count" name="bathrooms" value="">
    
    <div class="col-md-12 mb-3">
      <label for="additional_notes" class="form-label">Additional Notes (Optional)</label>
      <textarea class="form-control" id="additional_notes" name="additional_notes" rows="3"></textarea>
    </div>
  </div>
</div>
                    
                    <div class="text-center mt-4">
                      <button type="button" id="bookAppointmentBtn" class="btn btn-primary btn-lg px-5 py-3">
                        <i class="fas fa-calendar-check me-2"></i> Book Appointment
                      </button>
                    </div>
                  </form>
                  @else
                  <!-- User is not logged in, show login prompt -->
                  <div class="login-required-message bg-light p-5 rounded text-center">
                    <div class="mb-4">
                      <i class="fas fa-user-lock fa-4x text-primary mb-3"></i>
                      <h4>Authentication Required</h4>
                      <p class="text-muted">You need to be logged in to book an appointment with our professional appraisers.</p>
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                      <a href="{{ route('login') }}?redirect=property.estimation" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                      </a>
                      <a href="{{ route('register') }}?redirect=property.estimation" class="btn btn-outline-primary px-4 py-2">
                        <i class="fas fa-user-plus me-2"></i> Register
                      </a>
                    </div>
                  </div>
                  @endif
                </div>
                
                <div class="col-lg-5">
                  <div class="p-3">
                    <div id="bookingConfirmation" class="bg-white rounded shadow-sm p-4 mb-4 d-none">
                      <div class="text-center mb-4">
                        <div class="mb-3">
                          <i class="fas fa-check-circle text-success fa-3x"></i>
                        </div>
                        <h3>Appointment Requested</h3>
                        <p class="text-muted">Your appointment request has been submitted successfully!</p>
                      </div>
                      
                      <div class="booking-details">
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                          <span>Appraiser:</span>
                          <span class="fw-bold" id="confirmedAppraiser">Not selected</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                          <span>Date & Time:</span>
                          <span class="fw-bold" id="confirmedDateTime">Not selected</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                          <span>Property Address:</span>
                          <span class="fw-bold" id="confirmedAddress">Not provided</span>
                        </div>
                      </div>
                      
                      <div class="alert alert-info mb-4">
                        <div class="d-flex">
                          <div class="me-3">
                            <i class="fas fa-info-circle fa-2x text-primary"></i>
                          </div>
                          <div>
                            <h5 class="alert-heading">What happens next?</h5>
                            <p class="mb-0">Our team will review your request and contact you within 24 hours to confirm your appointment. You'll also receive a confirmation email with all the details.</p>
                          </div>
                        </div>
                      </div>
                      
                      <div class="text-center mt-3">
                        <a href="{{ url('/my-appraisals') }}" class="btn btn-primary">
                          <i class="fas fa-calendar me-2"></i> View My Appointments
                        </a>
                      </div>
                    </div>
                    
                    <div class="bg-light rounded p-4 mb-4">
                      <h4 class="mb-3 text-primary">Our Valuation Services</h4>
                      <ul class="list-unstyled mb-0">
                        <li class="d-flex mb-3">
                          <span class="badge bg-primary me-3 mt-1 p-2">1</span>
                          <div>
                            <strong>Residential Valuation</strong>
                            <p class="mb-0 text-muted">Comprehensive assessment of houses, apartments, and villas.</p>
                          </div>
                        </li>
                        <li class="d-flex mb-3">
                          <span class="badge bg-primary me-3 mt-1 p-2">2</span>
                          <div>
                            <strong>Commercial Property Assessment</strong>
                            <p class="mb-0 text-muted">Detailed valuation of office spaces, retail properties, and business premises.</p>
                          </div>
                        </li>
                        <li class="d-flex mb-3">
                          <span class="badge bg-primary me-3 mt-1 p-2">3</span>
                          <div>
                            <strong>Land Valuation</strong>
                            <p class="mb-0 text-muted">Expert assessment of land value and development potential.</p>
                          </div>
                        </li>
                        <li class="d-flex mb-3">
                          <span class="badge bg-primary me-3 mt-1 p-2">4</span>
                          <div>
                            <strong>Investment Property Analysis</strong>
                            <p class="mb-0 text-muted">Evaluation of income-generating properties with ROI calculations.</p>
                          </div>
                        </li>
                        <li class="d-flex">
                          <span class="badge bg-primary me-3 mt-1 p-2">5</span>
                          <div>
                            <strong>Legal & Banking Valuation</strong>
                            <p class="mb-0 text-muted">Certified reports accepted by courts and financial institutions.</p>
                          </div>
                        </li>
                      </ul>
                    </div>
                    
                    <div class="bg-light rounded p-4">
                      <h4 class="mb-3 text-primary">Client Testimonials</h4>
                      <div class="testimonial mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center mb-2">
                          <div class="text-warning me-2">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                          </div>
                          <span class="fw-bold">Ahmad N.</span>
                        </div>
                        <p class="mb-0 fst-italic">"The valuation service was excellent. The appraiser was thorough and professional, providing valuable insights about my property's market value."</p>
                      </div>
                      <div class="testimonial">
                        <div class="d-flex align-items-center mb-2">
                        <div class="text-warning me-2">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                          </div>
                          <span class="fw-bold">Laila M.</span>
                        </div>
                        <p class="mb-0 fst-italic">"I needed a valuation report for a bank loan, and the service exceeded my expectations. The report was detailed and delivered promptly, which helped me secure the financing."</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="section bg-light pt-5 pb-5">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-6 text-center">
        <h2 class="font-weight-bold text-primary heading">Frequently Asked Questions</h2>
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="accordion" id="faqAccordion">
          <div class="accordion-item mb-3 border rounded shadow-sm">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                How accurate is the online property estimation?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                <p>The online estimation provides a preliminary value based on the information you provide and our proprietary valuation algorithm that uses historical data from similar properties in Jordan. While it's a good starting point, the accuracy can vary depending on unique features of your property and current market conditions.</p>
                <p class="mb-0">For a comprehensive and legally valid valuation, we recommend booking a professional appraiser who will conduct an in-person assessment and provide a detailed report.</p>
              </div>
            </div>
          </div>
          
          <div class="accordion-item mb-3 border rounded shadow-sm">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                What information do I need to prepare for the professional appraisal?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                <p>To expedite the professional appraisal process, it's helpful to have these documents ready:</p>
                <ul>
                  <li>Property title deed (Sanad Tasjeel)</li>
                  <li>Recent property tax assessment</li>
                  <li>Floor plans or architectural drawings (if available)</li>
                  <li>Details of any recent renovations or improvements</li>
                  <li>Recent utility bills</li>
                  <li>Building permits for any additions or modifications</li>
                  <li>Rental agreements (if the property is currently leased)</li>
                </ul>
                <p class="mb-0">Don't worry if you don't have all these documents. Our appraisers can still conduct a thorough valuation with basic property information.</p>
              </div>
            </div>
          </div>
          
          <div class="accordion-item mb-3 border rounded shadow-sm">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                How long does the professional property valuation take?
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                <p>The on-site inspection typically takes 1-2 hours, depending on the size and complexity of the property. After the inspection, our appraisers will conduct market research and prepare a comprehensive report.</p>
                <p class="mb-0">You can expect to receive the final valuation report within 3-5 business days after the inspection. For urgent requests, we also offer expedited services at an additional fee.</p>
              </div>
            </div>
          </div>
          
          <div class="accordion-item mb-3 border rounded shadow-sm">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Is the property valuation report accepted by banks and legal authorities?
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                <p>Yes, our professional valuation reports are prepared in accordance with International Valuation Standards (IVS) and are accepted by:</p>
                <ul>
                  <li>All major banks and financial institutions in Jordan</li>
                  <li>Courts and legal authorities</li>
                  <li>The Department of Lands and Survey</li>
                  <li>Insurance companies</li>
                  <li>Tax authorities</li>
                </ul>
                <p class="mb-0">Our appraisers are certified by the relevant professional bodies, ensuring that the reports meet all regulatory requirements.</p>
              </div>
            </div>
          </div>
          
          <div class="accordion-item border rounded shadow-sm">
            <h2 class="accordion-header" id="headingFive">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                What factors affect my property's value in Jordan?
              </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                <p>Multiple factors influence property values in the Jordanian market:</p>
                <ul>
                  <li><strong>Location:</strong> Neighborhood desirability, proximity to amenities, schools, and access to transportation</li>
                  <li><strong>Property Size and Layout:</strong> Total area, number of rooms, and efficient use of space</li>
                  <li><strong>Age and Condition:</strong> Year built, maintenance status, and quality of construction</li>
                  <li><strong>Land Classification:</strong> Zoning regulations and permitted usage</li>
                  <li><strong>Infrastructure:</strong> Access to utilities, water supply, and internet connectivity</li>
                  <li><strong>Market Trends:</strong> Current supply and demand in the specific area</li>
                  <li><strong>Economic Factors:</strong> Interest rates, inflation, and overall economic stability</li>
                </ul>
                <p class="mb-0">Our professional appraisers consider all these factors and more to provide an accurate valuation of your property.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="section pt-5 pb-0">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-6 text-center">
        <h2 class="font-weight-bold text-primary heading">Why Choose Our Valuation Services</h2>
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-4 mb-5">
        <div class="service-card text-center">
          <div class="icon-wrap mb-4">
            <span class="icon-bg d-inline-block rounded-circle bg-light p-4">
              <i class="fas fa-certificate fa-2x text-primary"></i>
            </span>
          </div>
          <div>
            <h3 class="mb-3">Certified Experts</h3>
            <p>Our team consists of professionally certified appraisers with extensive experience in the Jordanian property market.</p>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4 mb-5">
        <div class="service-card text-center">
          <div class="icon-wrap mb-4">
            <span class="icon-bg d-inline-block rounded-circle bg-light p-4">
              <i class="fas fa-chart-line fa-2x text-primary"></i>
            </span>
          </div>
          <div>
            <h3 class="mb-3">Market Insights</h3>
            <p>Gain valuable insights into current market trends and factors affecting your property's value in today's dynamic market.</p>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4 mb-5">
        <div class="service-card text-center">
          <div class="icon-wrap mb-4">
            <span class="icon-bg d-inline-block rounded-circle bg-light p-4">
              <i class="fas fa-file-alt fa-2x text-primary"></i>
            </span>
          </div>
          <div>
            <h3 class="mb-3">Comprehensive Reports</h3>
            <p>Receive detailed valuation reports that are recognized by banks, courts, and government agencies throughout Jordan.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Estimation calculator
    const calculateEstimateBtn = document.getElementById('calculateEstimateBtn');
    const estimationResult = document.getElementById('estimationResult');
    const estimatedValue = document.getElementById('estimatedValue');
    const valueRange = document.getElementById('valueRange');
    const pricePerSqm = document.getElementById('pricePerSqm');
    
    // Booking functionality
    const bookAppointmentBtn = document.getElementById('bookAppointmentBtn');
    const bookingConfirmation = document.getElementById('bookingConfirmation');
    const confirmedAppraiser = document.getElementById('confirmedAppraiser');
    const confirmedDateTime = document.getElementById('confirmedDateTime');
    const confirmedAddress = document.getElementById('confirmedAddress');
    
    // Appraiser selection styling
    const appraiserCards = document.querySelectorAll('.appraiser-card');
    appraiserCards.forEach(card => {
      const radio = card.querySelector('.appraiser-radio');
      card.addEventListener('click', function() {
        // Remove active class from all cards
        appraiserCards.forEach(c => c.classList.remove('border-primary'));
        // Add active class to clicked card
        card.classList.add('border-primary');
        // Check the radio
        radio.checked = true;
      });
    });
    
    // Book appraiser link in estimation tab
    const bookAppraiserBtns = document.querySelectorAll('.book-appraiser-btn');
    bookAppraiserBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        document.getElementById('booking-tab').click();
        
        // Transfer values from estimation to booking form
        const propertyType = document.getElementById('propertyType').value;
        const area = document.getElementById('area').value;
        const bedrooms = document.getElementById('bedrooms').value;
        const bathrooms = document.getElementById('bathrooms').value;
        
        // Set hidden fields
        document.getElementById('property_type').value = propertyType;
        document.getElementById('property_area').value = area;
        document.getElementById('bedrooms_count').value = bedrooms;
        document.getElementById('bathrooms_count').value = bathrooms;
      });
    });
    
    // Calculate estimate
    calculateEstimateBtn.addEventListener('click', function() {
      const propertyType = document.getElementById('propertyType').value;
      const neighborhood = document.getElementById('neighborhood').value;
      const propertyAge = parseInt(document.getElementById('propertyAge').value) || 0;
      const area = parseInt(document.getElementById('area').value) || 0;
      const bedrooms = parseInt(document.getElementById('bedrooms').value) || 0;
      const bathrooms = parseInt(document.getElementById('bathrooms').value) || 0;
      
      // Check if required fields are filled
      if (!propertyType || !neighborhood || !area) {
        alert('Please fill in all required fields.');
        return;
      }
      
      // Simple estimation algorithm (this is a placeholder - would be more complex in production)
      let basePrice = 0;
      
      // Base price by neighborhood (JOD per sqm)
      switch(neighborhood) {
        case 'abdali':
          basePrice = 1200;
          break;
        case 'abdoun':
          basePrice = 1500;
          break;
        case 'dabouq':
          basePrice = 1300;
          break;
        case 'shmisani':
          basePrice = 1100;
          break;
        case 'sweifieh':
          basePrice = 1000;
          break;
        case 'jabal_amman':
          basePrice = 950;
          break;
        case 'jabal_hussein':
          basePrice = 900;
          break;
        case 'gardens':
          basePrice = 1050;
          break;
        default:
          basePrice = 800;
      }
      
      // Adjust by property type
      switch(propertyType) {
        case 'apartment':
          basePrice *= 1.0;
          break;
        case 'house':
          basePrice *= 1.2;
          break;
        case 'villa':
          basePrice *= 1.5;
          break;
        case 'commercial':
          basePrice *= 1.3;
          break;
        case 'land':
          basePrice *= 0.8;
          break;
      }
      
      // Age adjustment factor (newer properties worth more)
      const ageAdjustment = Math.max(0.7, 1 - (propertyAge * 0.015));
      
      // Calculate estimated value
      let estimatedSqmPrice = basePrice * ageAdjustment;
      
      // Additional feature adjustments
      if (document.getElementById('hasGarage').checked) estimatedSqmPrice *= 1.05;
      if (document.getElementById('hasGarden').checked) estimatedSqmPrice *= 1.08;
      if (document.getElementById('hasSwimmingPool').checked) estimatedSqmPrice *= 1.1;
      if (document.getElementById('hasBalcony').checked) estimatedSqmPrice *= 1.03;
      if (document.getElementById('hasElevator').checked) estimatedSqmPrice *= 1.02;
      if (document.getElementById('isFurnished').checked) estimatedSqmPrice *= 1.07;
      
      // Calculate total value
      const totalValue = Math.round(estimatedSqmPrice * area);
      const lowerRange = Math.round(totalValue * 0.9);
      const upperRange = Math.round(totalValue * 1.1);
      
      // Display results
      estimatedValue.textContent = `JOD ${totalValue.toLocaleString()}`;
      valueRange.textContent = `JOD ${lowerRange.toLocaleString()} - JOD ${upperRange.toLocaleString()}`;
      pricePerSqm.textContent = `JOD ${Math.round(estimatedSqmPrice).toLocaleString()}`;
      
      // Show results
      estimationResult.classList.remove('d-none');
    });
    
    // Book appointment
    if (bookAppointmentBtn) {
      bookAppointmentBtn.addEventListener('click', function() {
        // Get form values
        const appraiserRadios = document.querySelectorAll('input[name="appraiser_id"]');
        let selectedAppraiser = null;
        let appraiserName = '';
        
        for (const radio of appraiserRadios) {
          if (radio.checked) {
            selectedAppraiser = radio.value;
            appraiserName = radio.closest('.appraiser-card').querySelector('.card-title').textContent;
            break;
          }
        }
        
        const appointmentDate = document.getElementById('appointment_date').value;
        const appointmentTime = document.getElementById('appointment_time').value;
        const propertyAddress = document.getElementById('property_address').value;
        const clientName = document.getElementById('client_name').value;
        const clientPhone = document.getElementById('client_phone').value;
        const clientEmail = document.getElementById('client_email').value;
        
        // Simple validation
        if (!selectedAppraiser || !appointmentDate || !appointmentTime || !propertyAddress 
            || !clientName || !clientPhone || !clientEmail) {
          alert('Please fill in all required fields.');
          return;
        }
        
        // Show loading state
        bookAppointmentBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Checking availability...';
        bookAppointmentBtn.disabled = true;
        
        // First check if the appointment slot is available
        fetch('/property-appraisal/check-availability', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            appraiser_id: selectedAppraiser,
            appointment_date: appointmentDate,
            appointment_time: appointmentTime
          })
        })
        .then(response => {
          console.log('Availability check response status:', response.status);
          return response.json();
        })
        .then(data => {
          console.log('Availability check result:', data);
          if (data.available) {
            // Slot is available, proceed with booking
            submitBookingForm(selectedAppraiser, appointmentDate, appointmentTime, 
                              propertyAddress, clientName, clientPhone, clientEmail,
                              appraiserName);
          } else {
            // Slot is not available
            bookAppointmentBtn.innerHTML = '<i class="fas fa-calendar-check me-2"></i> Book Appointment';
            bookAppointmentBtn.disabled = false;
            
            // Show conflict popup
            Swal.fire({
              icon: 'warning',
              title: 'Time Slot Not Available',
              text: 'The selected time slot is already booked. Please choose another time or date.',
              confirmButtonText: 'Choose Another Time',
              confirmButtonColor: '#0d6efd'
            });
          }
        })
        .catch(error => {
          console.error('Error checking availability:', error);
          bookAppointmentBtn.innerHTML = '<i class="fas fa-calendar-check me-2"></i> Book Appointment';
          bookAppointmentBtn.disabled = false;
          alert('There was an error checking appointment availability. Please try again.');
        });
      });
    }

    // Function to submit the booking form after availability check
    function submitBookingForm(appraiser_id, appointment_date, appointment_time, 
                              property_address, client_name, client_phone, client_email,
                              appraiserName) {
      
      // Get other form fields
      const propertyType = document.getElementById('property_type').value;
      const propertyArea = document.getElementById('property_area').value;
      const bedrooms = document.getElementById('bedrooms_count').value;
      const bathrooms = document.getElementById('bathrooms_count').value;
      const additionalNotes = document.getElementById('additional_notes').value;
      
      // Get CSRF token
      const token = document.querySelector('input[name="_token"]').value;
      console.log('CSRF Token available:', !!token);
      
      // Prepare form data
      const formData = {
        _token: token,
        appraiser_id: appraiser_id,
        appointment_date: appointment_date,
        appointment_time: appointment_time,
        property_address: property_address,
        client_name: client_name,
        client_phone: client_phone,
        client_email: client_email,
        property_type: propertyType,
        property_area: propertyArea,
        bedrooms: bedrooms,
        bathrooms: bathrooms,
        additional_notes: additionalNotes
      };
      
      // Debug: Log the data being sent
      console.log('Booking form data to submit:', formData);
      
      // Update button to indicate booking in progress
      bookAppointmentBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Booking your appointment...';
      
      // Send AJAX request to book appointment
      fetch('/property-appraisal/book', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
      })
      .then(response => {
        console.log('Booking response status:', response.status);
        if (!response.ok) {
          console.error('Response not OK:', response.statusText);
        }
        return response.json();
      })
      .then(data => {
        console.log('Booking response data:', data);
        if (data.success) {
          // Format date and time
          const formattedDate = new Date(appointment_date);
          const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
          const formattedDateTime = `${formattedDate.toLocaleDateString('en-US', options)} at ${formatTime(appointment_time)}`;
          
          // Update confirmation
          confirmedAppraiser.textContent = appraiserName;
          confirmedDateTime.textContent = formattedDateTime;
          confirmedAddress.textContent = property_address;
          
          // Show confirmation
          bookingConfirmation.classList.remove('d-none');
          
          // Scroll to confirmation
          bookingConfirmation.scrollIntoView({ behavior: 'smooth' });
          
          // Reset form
          document.getElementById('bookingForm').reset();
        } else {
          // Show error message
          console.error('Booking error:', data);
          Swal.fire({
            icon: 'error',
            title: 'Booking Error',
            text: data.message || 'There was an error booking your appointment. Please try again.',
            confirmButtonColor: '#0d6efd'
          });
        }
      })
      .catch(error => {
        console.error('Fetch error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Connection Error',
          text: 'There was a problem connecting to the server. Please try again later.',
          confirmButtonColor: '#0d6efd'
        });
      })
      .finally(() => {
        // Reset button state
        bookAppointmentBtn.innerHTML = '<i class="fas fa-calendar-check me-2"></i> Book Appointment';
        bookAppointmentBtn.disabled = false;
      });
    }
    
    // Helper function to format time
    function formatTime(timeString) {
      const [hours, minutes] = timeString.split(':');
      const hour = parseInt(hours);
      return hour > 12 ? `${hour - 12}:${minutes} PM` : `${hour}:${minutes} AM`;
    }
  });
  </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush

@push('styles')
<style>

.card-body {
  position: relative;
  overflow: hidden;
}
  /* Appraiser Cards Layout */
  .card-text-p.badge {
  display: inline-block;
  max-width: 100%;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
 
  .appraiser-selection .row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
  }
  
  .appraiser-selection .col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
    padding-right: 15px;
    padding-left: 15px;
  }
  
  .appraiser-card {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 20px;
    height: 100%;
  }
  
  .appraiser-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(148, 27, 27, 0.1);
    border-color: #0d6efd;
  }
  
  .appraiser-card label {
    display: flex;
    flex-direction: column;
    height: 100%;
    cursor: pointer;
    padding: 20px;
  }
  
  /* Tabs Styling */
  .property-estimation-tabs .nav-link {
    font-weight: 600;
    padding: 12px 20px;
    color: #495057;
    border-radius: 0;
  }
  
  .property-estimation-tabs .nav-link.active {
    color: #0d6efd;
    background-color: white;
    border-bottom-color: white;
  }
  
  /* Responsive Adjustments */
  @media (max-width: 768px) {
    .appraiser-selection .col-md-6 {
      flex: 0 0 100%;
      max-width: 100%;
    }
    
    .property-estimation-tabs .nav-link {
      padding: 10px 15px;
      font-size: 14px;
    }
  }
  
  /* General Improvements */
  .tab-content {
    background: white;
  }
  
  .bg-light {
    background-color: #f8f9fa!important;
  }
  
  .text-primary {
    color: #0d6efd!important;
  }
  
  .btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
  }
</style>
@endpush