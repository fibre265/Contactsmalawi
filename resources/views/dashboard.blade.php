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
                    
                    <!-- Global Session Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('status'))
                        <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- User Management Section -->
                    <div class="mb-5">
                        <div class="border-bottom pb-3 mb-4 d-flex justify-content-between align-items-end">
                            <div>
                                <h3 class="h5 text-secondary mb-1">User Management</h3>
                                <p class="text-muted small mb-0">View, manage, and upload user records across the platform.</p>
                            </div>
                            <a href="{{ route('admin.import.index') }}" class="btn btn-primary btn-sm fw-bold px-3">
                                <i class="bi bi-upload me-1"></i> Upload Users
                            </a>
                        </div>

                        <table id="users-table" class="display w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Township</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-5" style="border-top: 1px dashed #ccc;">

                    <!-- System Categories Management Section -->
                    <div class="mb-5">
                        <div class="border-bottom pb-3 mb-4 d-flex justify-content-between align-items-end">
                            <div>
                                <h3 class="h5 text-secondary mb-1">System Categories</h3>
                                <p class="text-muted small mb-0">Manage, organize, add, or customize content categories across the platform.</p>
                            </div>
                            <button id="addCategoryButton" type="button" class="btn btn-primary btn-sm fw-bold px-3">
                                Add Category
                            </button>
                        </div>

                        @if(session('category_success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                {{ session('category_success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <table id="categories-table" class="display w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-5" style="border-top: 1px dashed #ccc;">

                    <!-- Stories Management Section -->
                    <div class="mb-5">
                        <div class="border-bottom pb-3 mb-4">
                            <h3 class="h5 text-secondary mb-1">Stories Management</h3>
                            <p class="text-muted small mb-0">Review, approve, modify, or remove user-submitted stories.</p>
                        </div>

                        @if(session('story_success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                {{ session('story_success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <table id="stories-table" class="display w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Story (Excerpt)</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-5" style="border-top: 1px dashed #ccc;">

                    <!-- About Page Content Settings -->
                    <div class="mb-5">
                        <div class="border-bottom pb-3 mb-4">
                            <h3 class="h5 text-secondary mb-1">About Page Content Settings</h3>
                            <p class="text-muted small mb-0">Customize the hero and mission statements displayed publicly on the About page.</p>
                        </div>

                        @if(session('settings_success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                {{ session('settings_success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="setting_hero_description" class="form-label fw-bold text-muted small">Hero Banner Description</label>
                                    <textarea name="settings[hero_description]" 
                                              id="setting_hero_description" 
                                              rows="3" 
                                              class="form-control @error('settings.hero_description') is-invalid @enderror" 
                                              placeholder="The unified directory platform..." 
                                              required>{{ old('settings.hero_description', $settings['hero_description'] ?? '') }}</textarea>
                                    @error('settings.hero_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="setting_mission_statement" class="form-label fw-bold text-muted small">Mission Statement</label>
                                    <textarea name="settings[mission_statement]" 
                                              id="setting_mission_statement" 
                                              rows="4" 
                                              class="form-control @error('settings.mission_statement') is-invalid @enderror" 
                                              placeholder="We believe in community visibility..." 
                                              required>{{ old('settings.mission_statement', $settings['mission_statement'] ?? '') }}</textarea>
                                    @error('settings.mission_statement')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-success px-4 font-weight-bold btn-sm" id="saveSettingsBtn">
                                    Save Page Content Settings
                                </button>
                            </div>
                        </form>
                    </div>

                    <hr class="my-5" style="border-top: 1px dashed #ccc;">

                    <!-- Newsletter Broadcast Control -->
                    <div class="mb-4">
                        <div class="border-bottom pb-3 mb-4">
                            <h3 class="h5 text-secondary mb-1">Newsletter Broadcast Control</h3>
                            <p class="text-muted small mb-0">Dispatch background marketing notifications or structural updates system-wide.</p>
                        </div>

                        @if(session('broadcast_success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                {{ session('broadcast_success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.broadcast.send') }}" method="POST" id="broadcastForm">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="message_body" class="form-label fw-bold text-muted small">Message Content Body</label>
                                <textarea name="message_body" 
                                          id="message_body" 
                                          rows="6" 
                                          class="form-control @error('message_body') is-invalid @enderror" 
                                          placeholder="Write your email announcement message here..." 
                                          required></textarea>
                                
                                @error('message_body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted small mt-2">
                                    <i class="bi bi-info-circle"></i> This message will be chunked into background delivery task rows automatically. Your browser window can be safely closed once processing starts.
                                </div>
                            </div>

                            <div class="d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary px-4 font-weight-bold btn-sm" id="submitBtn">
                                    Dispatch Mass Broadcast
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Add Category Modal -->
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
                                            <label for="categoryName" class="form-label fw-bold">Category Name</label>
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
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="editCategoryId" name="id">
                                        <div class="mb-3">
                                            <label for="editCategoryName" class="form-label fw-bold">Category Name</label>
                                            <input type="text" class="form-control" id="editCategoryName" name="category" placeholder="Enter category name" required>
                                        </div>
                                        <button type="submit" class="btn btn-success">Update Category</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Story Modal -->
                    <div class="modal fade" id="editStoryModal" tabindex="-1" aria-labelledby="editStoryModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStoryModalLabel">Edit Story</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editStoryForm" action="" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="editStoryId" name="id">
                                        
                                        <div class="mb-3">
                                            <label for="editStoryLocation" class="form-label fw-bold">Location</label>
                                            <input type="text" class="form-control" id="editStoryLocation" name="location" placeholder="e.g. Lilongwe">
                                        </div>

                                        <div class="mb-3">
                                            <label for="editStoryBody" class="form-label fw-bold">Story Content</label>
                                            <textarea class="form-control" id="editStoryBody" name="story" rows="8" required></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success">Update Story</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize the Stories DataTable
        $('#stories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.stories.data") }}',
                type: 'GET'
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'story', name: 'story' },
                { data: 'location', name: 'location' },
                { data: 'approved', name: 'approved' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Edit story button click event
        $('#stories-table').on('click', '.editStory', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '/admin/stories/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    $('#editStoryId').val(response.id);
                    $('#editStoryLocation').val(response.location);
                    $('#editStoryBody').val(response.story);
                    $('#editStoryForm').attr('action', '/admin/stories/' + response.id);
                    $('#editStoryModal').modal('show');
                },
                error: function(response) {
                    console.error(response.responseText);
                    alert('Failed to retrieve story data!');
                }
            });
        });

        // Handle the AJAX form submission for updating the story
        $('#editStoryForm').submit(function(event) {
            event.preventDefault();
            var formAction = $(this).attr('action');
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: formAction,
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editStoryModal').modal('hide');
                    $('#stories-table').DataTable().ajax.reload(null, false);
                    alert('Story updated successfully!');
                },
                error: function(response) {
                    console.error(response.responseText);
                    alert('Failed to update story!');
                }
            });
        });

        $(document).ready(function() {
            // Prevent broadcast double submissions
            $('#broadcastForm').submit(function() {
                var submitBtn = $('#submitBtn');
                submitBtn.prop('disabled', true);
                submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Enqueueing Tasks...');
            });

            // Loading UI indicators on Settings submit
            $('#settingsForm').submit(function() {
                var saveBtn = $('#saveSettingsBtn');
                saveBtn.prop('disabled', true);
                saveBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...');
            });

            // Show add category modal
            $('#addCategoryButton').on('click', function() {
                $('#addCategoryModal').modal('show');
            });

            // Handle add category submission with AJAX
            $('#addCategoryForm').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addCategoryModal').modal('hide');
                        $('#categories-table').DataTable().ajax.reload(null, false);
                        alert('Category saved successfully!');
                    },
                    error: function(response) {
                        console.error(response.responseText);
                    }
                });
            });

            // Initialize the Categories DataTable
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
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Edit button click event listener tracking table rows
            $('#categories-table').on('click', '.editCategory', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '/categories/' + id + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#editCategoryId').val(response.id);
                        $('#editCategoryName').val(response.category);
                        $('#editCategoryForm').attr('action', '/categories/' + response.id);
                        $('#editCategoryModal').modal('show');
                    },
                    error: function(response) {
                        console.error(response.responseText);
                    }
                });
            });

            // Handle the form submission for updating the category
            $('#editCategoryForm').submit(function(event) {
                event.preventDefault();
                var formAction = $(this).attr('action');
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: formAction,
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editCategoryModal').modal('hide');
                        $('#categories-table').DataTable().ajax.reload(null, false);
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
</x-app-layout>