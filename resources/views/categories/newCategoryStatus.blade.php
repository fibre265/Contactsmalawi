@extends('layouts.generalLayout')
@section('content')

<style>
    .section-bg {
        background-color: #f8f9fa; /* Light background */
        padding: 50px 0;
    }
    .section-title {
        font-size: 3rem;
        font-weight: 700;
        color: #007bff; /* Bright blue color */
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 0;
    }
    /* Clickable Category Box Styles */
    .category-card-box {
        background: #ffffff;
        padding: 35px 20px; /* Enhanced vertical padding */
        margin-bottom: 30px;
        box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        border-bottom: 4px solid #ffc107; /* Warning amber color */
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 250px; /* Adjusted height to perfectly cradle all structural elements */
    }
    .category-card-box:hover {
        transform: translateY(-5px);
        background-color: #fffdf5;
        box-shadow: 0px 4px 20px rgba(255, 193, 7, 0.2);
    }
    .category-card-box i.main-icon {
        font-size: 2.8rem;
        color: #ffc107;
        margin-bottom: 15px;
        display: inline-block;
    }
    .category-card-title {
        font-size: 1.35rem;
        font-weight: 600;
        color: #333333;
        margin-bottom: 0;
    }
</style>

<section id="counts" class="section-bg">
    <div class="container">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 text-center text-md-start">
            <h1 class="section-title">Pending Approvals</h1>
            <button id="addCategoryButton" type="button" class="btn btn-primary shadow-sm mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="bi bi-plus-circle me-2"></i> Create Category
            </button>
        </div>

        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addCategoryForm" action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" name="category" placeholder="Enter category name" required>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Save Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @if($categories->isEmpty())
                <div class="col-12 text-center py-5">
                    <div class="text-muted fs-5">
                        <i class="bi bi-inbox mb-2 d-block fs-1 text-secondary"></i>
                        No pending categories found.
                    </div>
                </div>
            @else
                @foreach ($categories as $cat)
                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                        <div class="category-card-box w-100 text-center">
                            <i class="bi bi-hourglass-split main-icon"></i>
                            
                            <div class="category-card-title text-capitalize mb-3">{{ $cat->category }}</div>
                            
                            <div class="w-100 text-center mb-2">
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill d-inline-flex align-items-center justify-content-center fw-semibold shadow-sm" style="font-size: 0.85rem; letter-spacing: 0.3px;">
                                    <i class="bi bi-clock-history me-1"></i> Pending Approval
                                </span>
                            </div>

                            <hr class="w-75 my-3 opacity-25">

                            <div class="w-100 text-center">
                                <button class="btn btn-sm btn-outline-success like-btn rounded-pill px-3 shadow-sm fw-semibold" data-id="{{ $cat->id }}">
                                    <i class="bi bi-hand-thumbs-up-fill me-1"></i> Endorse (<span class="like-count">{{ $cat->likes ?? 0 }}</span>)
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    // Inject CSRF protection rules globally into jQuery
    $.ajaxSetup({
        headers: {
            // First tries to read the meta tag, falls back directly to Blade's token generator
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
        }
    });

    // ... rest of your code remains exactly the same ...

    // -------------------------------------------------------------------------
    // ANONYMOUS TRACKING LOGIC (On Window Loading Event)
    // -------------------------------------------------------------------------
    $('.like-btn').each(function() {
        var button = $(this);
        var categoryId = button.data('id');
        
        if (localStorage.getItem('liked_category_' + categoryId)) {
            button.removeClass('btn-outline-success')
                  .addClass('btn-success text-white')
                  .html('<i class="bi bi-check-circle-fill me-1"></i> Endorsed (' + button.find('.like-count').text() + ')');
        }
    });

    // -------------------------------------------------------------------------
    // ENDORSE BUTTON DELEGATED CLICK EVENT HANDLER
    // -------------------------------------------------------------------------
    $(document).on('click', '.like-btn', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var categoryId = button.data('id');
        var countSpan = button.find('.like-count');

        if (localStorage.getItem('liked_category_' + categoryId)) {
            alert('You have already endorsed this suggested category item!');
            return;
        }

        button.prop('disabled', true);

        $.ajax({
            url: '/categories/' + categoryId + '/like',
            type: 'POST',
            success: function(response) {
                if(response.success) {
                    countSpan.text(response.likes);
                    localStorage.setItem('liked_category_' + categoryId, 'true');
                    
                    button.removeClass('btn-outline-success')
                          .addClass('btn-success text-white')
                          .html('<i class="bi bi-check-circle-fill me-1"></i> Endorsed (' + response.likes + ')');
                }
                button.prop('disabled', false);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Something went wrong. Please refresh your page and try again.');
                button.prop('disabled', false);
            }
        });
    });

    // Handle asynchronous form submission
    $('#addCategoryForm').submit(function(event) {
        event.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#addCategoryModal').modal('hide');
                location.reload(); 
            },
            error: function(response) {
                console.error(response.responseText);
                alert('Failed to save category.');
            }
        });
    });
});
</script>

@endsection