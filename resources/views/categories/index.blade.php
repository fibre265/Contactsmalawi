<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="container">
    <h2>Categories List</h2>
    <table id="categoriesTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->category }}</td>
                <td>
                    <!-- Edit Button -->
                    <button type="button" class="btn btn-primary" data-id="{{ $category->id }}" data-category="{{ $category->category }}" data-bs-toggle="modal" data-bs-target="#editCategoryModal">
                      Edit
                    </button>
                    <!-- Delete Button -->
                    <button type="button" class="btn btn-danger" data-id="{{ $category->id }}" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">
                      Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $('#categoriesTable').DataTable(); // Initialize DataTable
    });
</script>
@endsection
 

     
</script>
</x-app-layout>



