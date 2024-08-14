{{--
  Template Name: Home Template
--}}

@extends('layouts.app')

@section('content')
<div class="floating-button">
  <a href="{{ home_url('/contact') }}" class="blackToPurple homestart">
    <p class="button-text">Start Here</p>
    <div class="circlegrow"></div>
    <p class="second-text"> 
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="18" viewBox="0 0 40 18" fill="none">
        <path d="M1.25118 8.8877H37.6844M31.2592 1.74243C33.0916 4.43963 35.4933 6.7346 38.3081 8.47766L38.7489 8.75069L38.2933 9.01401C35.2921 10.7485 32.8554 13.2578 31.2592 16.2577" stroke="white" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
      </svg> 
      Talk to Us
    </p>
  </a>
</div>

  @include('pages.home.home-hero')
  @include('pages.home.home-weare')
  @include('pages.home.home-whychoose')
  @include('pages.home.home-testimonials')
  @include('pages.home.home-rundown')
  @include('pages.home.home-map')
  @include('pages.home.home-faq')

@endsection
