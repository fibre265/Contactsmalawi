@extends('layouts.generalLayout')
@section('content')

 <!-- ======= Contact Section ======= -->
 <section id="contact" class="contact section-bg">
      <div class="container" data-aos="fade-up">
     
        <div class="section-title">
          <h2> {{ $region }} Region</h2>
          <p> If this is not the agent number you acre looking for,plese call 08867.. and you will be assisted as soon as possible if the number is register with us</p></p>
        </div>

        <div class="row">
        @foreach ($districts as $district)
          <div class="col-lg-3 col-md-6">
          <a href="/search_in_district/{{ $district->id }}">
            <div class="info-box  mb-4">
              <i class=" bx bx-envelope"><i class="bx bx-phone-call"></i></i>
              <h3>{{ $district->district }}</h3>
              <p><i>Contacts: {{ $district->user->count() }}</i></p>
            </div>
            </a>
          </div>
		  
          @endforeach
        </div>

      </div>
    </section><!-- End Contact Section -->
@endsection
