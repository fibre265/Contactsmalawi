@extends('layouts.generalLayout')
@section('content')

<div class="container my-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="box" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold text-primary">Community Success Stories</h1>
            <p class="text-muted mb-0">See how our platform is making an impact.</p>
        </div>
        <button class="btn btn-success shadow-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#submitStoryModal">
            <i class="bi bi-pencil-square me-2"></i> Share Your Story
        </button>
    </div>

    <div class="row">
        @if($stories->isEmpty())
            <div class="col-12 text-center py-5 card bg-light border-0">
                <i class="bi bi-chat-square-heart text-secondary fs-1 mb-2"></i>
                <p class="text-muted fs-5 mb-0">No stories published yet. Be the first to share your experience!</p>
            </div>
        @else
            @foreach($stories as $item)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm p-4" style="border-left: 4px solid #28a745 !important;">
                        <i class="bi bi-quote text-success opacity-25 fs-1 lh-1 mb-2"></i>
                        <p class="card-text text-dark fs-5 italic">"{{ $item->story }}"</p>
                        <div class="mt-auto pt-3 border-top border-light d-flex justify-content-between align-items-center">
                            <span class="text-muted small fw-semibold">
                                <i class="bi bi-geo-alt-fill me-1 text-danger"></i> {{ $item->location }}
                            </span>
                            <span class="text-muted text-xs">{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<div class="modal fade" id="submitStoryModal" tabindex="-1" aria-labelledby="submitStoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="submitStoryModalLabel"><i class="bi bi-heart-fill me-2"></i> Share Anonymously</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('stories.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info small" role="alert">
                        <i class="bi bi-shield-lock-fill me-2"></i> Your identity is completely safe. No names or email addresses are tracked.
                    </div>
                    
                    <div class="mb-3">
                        <label for="storyText" class="form-label fw-semibold">What happened? How did we help?</label>
                        <textarea class="form-control" id="storyText" name="story" rows="5" placeholder="e.g., Your website helped me call for help when robbers entered our neighborhood..." required minlength="10" maxlength="1000"></textarea>
                        <div class="form-text text-end small">Maximum 1000 characters.</div>
                    </div>

                    <div class="mb-3">
                        <label for="locationInput" class="form-label fw-semibold">Your Location (Optional)</label>
                        <input type="text" class="form-control" id="locationInput" name="location" placeholder="e.g., Area 18, Lilongwe / Blantyre">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Submit Story</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection