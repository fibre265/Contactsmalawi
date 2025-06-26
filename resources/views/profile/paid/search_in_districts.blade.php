@extends('layouts.generalLayout')
@section('content')

<!-- Add custom styles for the section and heading -->
<style>
    .section-bg {
        background-color: #f8f9fa; /* Light background */
        padding: 50px 0;
    }
    .section-title {
        font-size: 3rem;
        font-weight: 700;
        color: #007bff; /* Bright blue color */
        text-align: center;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }
    .count-box {
        background: #ffffff; /* White background for boxes */
    }
    .count-box i {
        font-size: 3rem;
        color: #007bff; /* Icon color */
        margin-bottom: 15px;
    }
    .user-picture {
        width: 100%; /* Set the width of the picture */
        height: auto; /* Maintain the aspect ratio */
        max-height: 200px; /* Optional: limit the max height */
        object-fit: cover; /* Ensure the image fits well */
    }

</style>

<section id="counts" class="">
    <div class="container">
        <div class="row no-gutters">
            <h1 class="section-title">{{ $district }}</h1>
            @foreach ($users as $user)
                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
                    <a href="{{ route('users.show', $user) }}">
                        <div class="count-box">
                            <!-- Display the user's picture -->
                         
                                <img src="{{ asset('/storage/uploads/pictures/' . $user->picture) }}" alt="{{ $user->name }}'s picture" class="user-picture">
                        

                            <i class="bi bi-headset"></i>
                            <span data-purecounter-start="0" data-purecounter-end="{{ $user->email }}" data-purecounter-duration="1" class="purecounter"></span>
                            <p><strong>{{ $user->name }}</strong> <br> {{ $user->township }} </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section><!-- End count Section -->
@endsection
