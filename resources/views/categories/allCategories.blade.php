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
        padding: 25px 20px;
        margin-bottom: 30px;
        box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        border-bottom: 4px solid #007bff;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .category-card-box:hover {
        transform: translateY(-5px);
        background-color: #f1f7ff;
        box-shadow: 0px 4px 20px rgba(0, 123, 255, 0.15);
    }
    .category-card-box i {
        font-size: 2.5rem;
        color: #007bff;
        margin-bottom: 10px;
    }
    .category-card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333333;
        margin-bottom: 5px;
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
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 text-center text-md-start">
            <h1 class="section-title">{{ $district ?? 'Search Results' }}</h1>
            
            <div class="d-flex flex-column align-items-center align-items-md-end mt-3 mt-md-0">
                <button id="addCategoryButton" type="button" class="btn btn-primary shadow-sm mb-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="bi bi-plus-circle me-2"></i> Create Category
                </button>
                <a href="/pendingCategories" class="btn btn-sm btn-outline-secondary shadow-sm">
                    <i class="bi bi-clock-history me-1"></i> See Pending Categories
                </a>
            </div>
        </div>

        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
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
                            <button type="submit" class="btn btn-success">Save Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($groupedUsers->isEmpty())
            <div class="row">
                <div class="col-12 d-flex justify-content-center align-items-center" style="height: 200px;">
                    <div class="alert alert-warning text-center" role="alert">
                        <h4 class="alert-heading">No Results Found</h4>
                        <p>Unfortunately, we couldn't find any results matching your search.</p>
                    </div>
                </div>
            </div>
        @else
            
            <div class="row">
                @foreach ($groupedUsers as $categoryName => $users)
                    @php
                        $collapseId = 'collapse_' . Str::slug($categoryName);
                    @endphp

                    <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
                        <div class="category-card-box w-100 text-center" 
                             data-bs-toggle="collapse" 
                             data-bs-target="#{{ $collapseId }}" 
                             aria-expanded="false" 
                             aria-controls="{{ $collapseId }}">
                            <i class="bi bi-folder2-open"></i>
                            <div class="category-card-title">{{ $categoryName }}</div>
                            <span class="badge bg-primary rounded-pill">{{ $users->count() }} Results</span>
                        </div>
                    </div>
                @endforeach
            </div>

            @foreach ($groupedUsers as $categoryName => $users)
                @php
                    $collapseId = 'collapse_' . Str::slug($categoryName);
                @endphp

                <div class="collapse col-12" id="{{ $collapseId }}" data-bs-parent="#counts">
                    <div class="card card-body bg-light border-0 mb-4 rounded-3 shadow-sm">
                        <h3 class="h5 mb-4 text-dark border-bottom pb-2">
                            Showing Results for: <strong class="text-primary">{{ $categoryName }}</strong>
                        </h3>
                        
                        <div class="row">
                            @foreach ($users as $user)
                                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
                                    <a href="{{ route('users.show', $user) }}" class="user-link w-100">
                                        <div class="count-box text-center">
                                            <i class="bi bi-person-badge"></i>
                                            <p class="mb-0"><strong>{{ $user->name }}</strong></p>
                                            <p class="text-muted small mb-0">{{ $user->township ?? 'No Township Specified' }}</p>
                                            <span class="text-xs text-primary italic d-block mt-2">{{ $user->email }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

        @endif
    </div>
</section>

<script>
$(document).ready(function() {
    // CSRF Setup for all AJAX updates
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle form submission with AJAX (Add Category)
    $('#addCategoryForm').submit(function(event) {
        event.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#addCategoryModal').modal('hide');
                location.reload(); // Reload context page
            },
            error: function(response) {
                console.error(response.responseText);
                alert('Failed to save category. Check console for details.');
            }
        });
    });

    // Initialize the DataTable (if this page element exists)
    if ($('#categories-table').length) {
        $('#categories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/categories',
                type: 'GET'
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'category', name: 'category' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Edit button click event on table components
        $('#categories-table').on('click', '.editCategory', function() {
            var id = $(this).data('id');
            
            $.ajax({
                url: '/categories/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    $('#editCategoryId').val(response.id);
                    $('#editCategoryName').val(response.category);
                    $('#editCategoryModal').modal('show');
                },
                error: function(response) {
                    console.error(response.responseText);
                }
            });
        });
    }

    // Handle the form submission for updating categories
    $('#editCategoryForm').submit(function(event) {
        event.preventDefault();

        var id = $('#editCategoryId').val();
        
        $.ajax({
            url: '/categories/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#editCategoryModal').modal('hide');
                if ($.fn.DataTable.isDataTable('#categories-table')) {
                    $('#categories-table').DataTable().ajax.reload(null, false);
                }
                alert('Category updated successfully!');
            },
            error: function(response) {
                console.error(response.responseText);
                alert('Failed to update category!');
            }
        });
    });
});
</script>

@endsection