@extends('layouts.public.app')

@section('title', 'Our Services')

@section('content')



<div class="hero page-inner overlay" >
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">Our Services</h1>

        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">
              Services
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<div class="section bg-light">
  <div class="container">
    <div class="row">
      @php
        $services = [
          [
            'icon' => 'flaticon-house',
            'title' => 'Quality Properties',
            'description' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.'
          ],
          [
            'icon' => 'flaticon-house-2',
            'title' => 'Top Rated Agent',
            'description' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.'
          ],
          [
            'icon' => 'flaticon-building',
            'title' => 'Property for Sale',
            'description' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.'
          ],
          [
            'icon' => 'flaticon-house-3',
            'title' => 'House for Sale',
            'description' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.'
          ],
          [
            'icon' => 'flaticon-house-4',
            'title' => 'Quality Properties',
            'description' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.'
          ],
          [
            'icon' => 'flaticon-building',
            'title' => 'Top Rated Agent',
            'description' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.'
          ],
          [
            'icon' => 'flaticon-house',
            'title' => 'Property for Sale',
            'description' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.'
          ],
          [
            'icon' => 'flaticon-house-1',
            'title' => 'House for Sale',
            'description' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.'
          ]
        ];
      @endphp

      @foreach($services as $index => $service)
        <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ 300 + ($index * 100) }}">
          <div class="box-feature mb-4">
            <span class="{{ $service['icon'] }} mb-4 d-block"></span>
            <h3 class="text-black mb-3 font-weight-bold">{{ $service['title'] }}</h3>
            <p class="text-black-50">{{ $service['description'] }}</p>
            <p><a href="#" class="learn-more">Read more</a></p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

<div class="section sec-testimonials">
  <div class="container">
    <div class="row mb-5 align-items-center">
      <div class="col-md-6">
        <h2 class="font-weight-bold heading text-primary mb-4 mb-md-0">
          Customer Testimonials
        </h2>
      </div>
      <div class="col-md-6 text-md-end">
        <div id="testimonial-nav">
          <span class="prev" data-controls="prev">Prev</span>
          <span class="next" data-controls="next">Next</span>
        </div>
      </div>
    </div>

    <div class="testimonial-slider-wrap">
      <div class="testimonial-slider">
        @php
          $testimonials = [
            [
              'image' => 'person_1-min.jpg',
              'name' => 'James Smith',
              'position' => 'Designer, Co-founder',
              'quote' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.'
            ],
            [
              'image' => 'person_2-min.jpg',
              'name' => 'Mike Houston',
              'position' => 'Designer, Co-founder',
              'quote' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.'
            ],
            [
              'image' => 'person_3-min.jpg',
              'name' => 'Cameron Webster',
              'position' => 'Designer, Co-founder',
              'quote' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.'
            ],
            [
              'image' => 'person_4-min.jpg',
              'name' => 'Dave Smith',
              'position' => 'Designer, Co-founder',
              'quote' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.'
            ]
          ];
        @endphp

        @foreach($testimonials as $testimonial)
          <div class="item">
            <div class="testimonial">
              <img src="{{ asset('images/' . $testimonial['image']) }}" alt="{{ $testimonial['name'] }}" class="img-fluid rounded-circle w-25 mb-4" />
              <div class="rate">
                @for($i = 0; $i < 5; $i++)
                  <span class="icon-star text-warning"></span>
                @endfor
              </div>
              <h3 class="h5 text-primary mb-4">{{ $testimonial['name'] }}</h3>
              <blockquote>
                <p>&ldquo;{{ $testimonial['quote'] }}&rdquo;</p>
              </blockquote>
              <p class="text-black-50">{{ $testimonial['position'] }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

@endsection