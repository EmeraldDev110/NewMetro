{{--
  Template Name: Custom Template
--}}

@extends('layouts.app')

@section('content')
  <section class="container">
      @while(have_posts()) @php the_post() @endphp
          @include('partials.page-header')
          @include('partials.content-page')
      @endwhile
  </section>
@endsection
