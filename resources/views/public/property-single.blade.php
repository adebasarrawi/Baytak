@extends('layouts.public.app')

@section('title', 'Property Details - 5232 California AVE. 21BC')

@section('content')

<div class="site-mobile-menu site-navbar-target">
  <div class="site-mobile-menu-header">
    <div class="site-mobile-menu-close">
      <span class="icofont-close js-menu-toggle"></span>
    </div>
  </div>
  <div class="site-mobile-menu-body"></div>
</div>

<nav class="site-nav">
  <div class="container">
    <div class="menu-bg-wrap">
      <div class="site-navigation">
        <a href="{{ url('/') }}" class="logo m-0 float-start">Property</a>

        <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end">
          <li><a href="{{ url('/') }}">Home</a></li>
          <li class="has-children">
            <a href="{{ url('/properties') }}">Properties</a>
            <ul class="dropdown">
              <li><a href="#">Buy Property</a></li>
              <li><a href="#">Sell Property</a></li>
              <li class="has-children">
                <a href="#">Dropdown</a>
                <ul class="dropdown">
                  <li><a href="#">Sub Menu One</a></li>
                  <li><a href="#">Sub Menu Two</a></li>
                  <li><a href="#">Sub Menu Three</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li><a href="{{ url('/services') }}">Services</a></li>
          <li><a href="{{ url('/about') }}">About</a></li>
          <li><a href="{{ url('/contact') }}">Contact Us</a></li>
        </ul>

        <a href="#" class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none" data-toggle="collapse" data-target="#main-navbar">
          <span></span>
        </a>
      </div>
    </div>
  </div>
</nav>

<div class="hero page-inner overlay">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">5232 California AVE. 21BC</h1>

        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/properties') }}">Properties</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">
              5232 California AVE. 21BC
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<div class="section">
  <div class="container">
    <div class="row justify-content-between">
      <div class="col-lg-7">
        <div class="img-property-slide-wrap">
          <div class="img-property-slide">
            <img src="{{ asset('images/img_1.jpg') }}" alt="Property Image" class="img-fluid" />
            <img src="{{ asset('images/img_2.jpg') }}" alt="Property Image" class="img-fluid" />
            <img src="{{ asset('images/img_3.jpg') }}" alt="Property Image" class="img-fluid" />
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <h2 class="heading text-primary">5232 California Ave. 21BC</h2>
        <p class="meta">California, United States</p>
        <p class="text-black-50">
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione
          laborum quo quos omnis sed magnam id, ducimus saepe, debitis error
          earum, iste dicta odio est sint dolorem magni animi tenetur.
        </p>
        <p class="text-black-50">
          Perferendis eligendi reprehenderit, assumenda molestias nisi eius
          iste reiciendis porro tenetur in, repudiandae amet libero.
          Doloremque, reprehenderit cupiditate error laudantium qui, esse
          quam debitis, eum cumque perferendis, illum harum expedita.
        </p>

        <div class="d-block agent-box p-5">
          <div class="img mb-4">
            <img src="{{ asset('images/person_2-min.jpg') }}" alt="Agent Alicia Huston" class="img-fluid" />
          </div>
          <div class="text">
            <h3 class="mb-0">Alicia Huston</h3>
            <div class="meta mb-3">Real Estate Agent</div>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Ratione laborum quo quos omnis sed magnam id ducimus saepe
            </p>
            <ul class="list-unstyled social dark-hover d-flex">
              <li class="me-1">
                <a href="#"><span class="icon-instagram"></span></a>
              </li>
              <li class="me-1">
                <a href="#"><span class="icon-twitter"></span></a>
              </li>
              <li class="me-1">
                <a href="#"><span class="icon-facebook"></span></a>
              </li>
              <li class="me-1">
                <a href="#"><span class="icon-linkedin"></span></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection