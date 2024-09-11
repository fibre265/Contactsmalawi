





       

@extends('layouts.generalLayout')
@section('content')

<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

  <!-- ======= Team Section ======= -->

<section id="team" class="team">

      <div class="container">

        <div class="section-title" data-aos="fade-in" data-aos-delay="100">
          <h2>Phone Number: {{ $user->email }}</h2>
  

    <ul>
            <li>
                 <!-- Display the district name -->
                 <h2>Name: {{ $user->name }}</h2>
                <!-- Display the district name -->
                <h2>District: {{ $user->district->district }}</h2>

                <!-- Display the region name -->
                <h2>Region: {{ $user->district->region->region }}</h2>
            </li>
        
    </ul>

          
            If this is not the agent number you acre looking for,plese call 08867.. and you will be assisted as soon as possible if the number is register with us</p>
        </div>

        <div class="">

          <div class="col-lg-12 col-md-12">
            <div class="member" data-aos="fade-up">
          
              <div class="member-info">
                <h4>Contacts Malawi</h4>
                <span>Chief Executive Officer</span>
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Team Section -->
 

</x-guest-layout>
@endsection









 



