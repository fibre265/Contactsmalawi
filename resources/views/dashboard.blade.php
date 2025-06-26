<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    

                <table id="users-table" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Towship</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Rows will be added by DataTables -->
        </tbody>
    </table>


<button id="addCategoryButton" type="button" class="btn btn-primary">
  Add Category
</button>
<table id="categories-table" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>category</th>
                <th>Actions</th>
                
            </tr>
        </thead>
        <tbody>
            <!-- Rows will be added by DataTables -->
        </tbody>
    </table>

<!-- Modal -->
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

    




<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editCategoryForm" action="" method="POST">
        <input type="hidden" name="_method" value="PUT">
          @csrf
          @method('PUT') <!-- Ensure it's a PUT request for updating -->
          <input type="hidden" id="editCategoryId" name="id">
          <div class="mb-3">
            <label for="editCategoryName" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="editCategoryName" name="category" placeholder="Enter category name" required>
          </div>
          <button type="submit" class="btn btn-success">Update Category</button>
        </form>
      </div>
    </div>
  </div>
</div>








                </div>
            </div>
        </div>
    </div>
    <script>$(document).ready(function() {
    // Show modal when button is clicked
    $('#addCategoryButton').on('click', function() {
        $('#addCategoryModal').modal('show');
    });

    // Handle form submission with AJAX
    $('#addCategoryForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission
        
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            url: $(this).attr('action'), // Get the form action URL
            type: 'POST',
            data: $(this).serialize(), // Serialize form data
            success: function(response) {
                // Handle success - e.g., reload the page or update the category list dynamically
                $('#addCategoryModal').modal('hide'); // Close the modal
                location.reload(); // Optionally reload the page to reflect the changes
            },
            error: function(response) {
                // Handle errors (e.g., validation errors)
                console.error(response.responseText);
            }
        });
    });
});



$(document).ready(function() {
    // Initialize the DataTable
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

    $(document).ready(function() {
    // Edit button click event
    $('#categories-table').on('click', '.editCategory', function() {
        var id = $(this).data('id');
        
        // Fetch the category data from the server
        $.ajax({
            url: '/categories/' + id + '/edit', // Adjust this route as necessary
            type: 'GET',
            success: function(response) {
                // Populate the modal form with the data
                $('#editCategoryId').val(response.id);
                $('#editCategoryName').val(response.category);
                
                // Show the modal
                $('#editCategoryModal').modal('show');
            },
            error: function(response) {
                console.error(response.responseText);
            }
        });
    });

    // Handle the form submission for updating the category
    $('#editCategoryForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        var id = $('#editCategoryId').val(); // Get the category ID
        var actionUrl = '/categories/' + id; // URL for updating the category
        
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            url: actionUrl,
            type: 'PUT',
            data: $(this).serialize(), // Serialize the form data
            success: function(response) {
                // Hide the modal after success
                $('#editCategoryModal').modal('hide');
                
                // Reload the DataTable to reflect changes
                $('#categories-table').DataTable().ajax.reload(null, false);
                
                // Optionally, show a success message
                alert('Category updated successfully!');
            },
            error: function(response) {
                console.error(response.responseText);
                // Optionally, show an error message
                alert('Failed to update category!');
            }
        });
    });
});

});



</script>
</x-app-layout>



