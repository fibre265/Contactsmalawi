@extends('layouts.generalLayout')
@section('content')

<style>
    .section-bg {
        background-color: #f8f9fa; /* Light background */
        padding: 120px 0 60px 0; /* Extra top padding to clear fixed header safely */
    }
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #007bff; /* Bright blue color */
        text-align: center;
        margin-bottom: 40px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }
    /* Target User Box Styles */
    .count-box {
        background: #ffffff; /* White background for boxes */
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        transition: transform 0.3s ease;
    }
    .count-box:hover {
        transform: translateY(-5px);
    }
    .count-box i {
        font-size: 2.5rem;
        color: #28a745; /* Distinct icon color for users */
        margin-bottom: 15px;
    }
    .user-link {
        text-decoration: none;
        color: inherit;
    }
    .user-link:hover {
        color: inherit;
    }
</style>

<section id="counts" class="section-bg">
    <div class="container">
        
        <h1 class="section-title">{{ $categoryName ?? 'Category Results' }}</h1>

        @if ($users->isEmpty())
            <div class="row">
                <div class="col-12 d-flex justify-content-center align-items-center" style="height: 200px;">
                    <div class="alert alert-warning text-center w-50" role="alert">
                        <h4 class="alert-heading">No Results Found</h4>
                        <p>Unfortunately, there are no emergency contacts listed under this category right now.</p>
                    </div>
                </div>
            </div>
        @else
            
            <div class="row">
                <h3 class="h5 mb-4 text-dark text-center pb-2">
                    Showing Emergency Contacts under: <strong class="text-primary">{{ $categoryName }}</strong>
                </h3>
                
                @foreach ($users as $user)
                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                        <a href="{{ route('users.show', $user) }}" class="user-link w-100">
                            <div class="count-box text-center h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <i class="bi bi-person-badge d-block"></i>
                                    <p class="mb-1"><strong>{{ $user->name }}</strong></p>
                                    <p class="text-muted small mb-0">
                                        {{ $user->township ?? 'No Township Specified' }} 
                                        @if(!empty($user->district->district))
                                            , {{ $user->district->district }}
                                        @endif
                                    </p>
                                </div>
                                <span class="text-xs text-primary font-monospace d-block mt-3fw-bold">{{ $user->email }}</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        @endif
    </div>
</section>

@endsection