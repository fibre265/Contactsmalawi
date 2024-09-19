
      <!-- <div class="container">
      <li>District: {{ $district }}</li>
<div class="section-title" data-aos="fade-in" data-aos-delay="100">
  <h2></h2>
  @foreach ($users as $user)
  <a href="">
    <li>Phone Number: {{ $user->email }}</li>
    <li>name: {{ $user->name}}</li>
    </a>
    <hr>
  @endforeach
</div> -->
     
@extends('layouts.generalLayout')
@section('content')
<section id="counts" class="counts  section-bg">
<CEnter> <H1>CHIKWAWA</H1> </CEnter>
</section>
<section id="counts" class="">
<div class="container">

<div class="row no-gutters">

@foreach ($users as $user)
  <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
  <a href="{{ route('users.show', $user) }}">
    <div class="count-box">
      <i class="bi bi-headset"></i>
      <span data-purecounter-start="0" data-purecounter-end="{{ $user->email }}" data-purecounter-duration="1" class="purecounter"></span>
      <p><strong>{{ $user->name }}</strong> {{ $user->township }} from {{ $user->district->district }}  </p>
    </div>
    </a>
  </div>
@endforeach
</div>
</div>
</section><!-- End count Section -->
@endsection
