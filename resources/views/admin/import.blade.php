@extends('layouts.generalLayout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white font-weight-bold">
                    <i class="bi bi-file-earmark-spreadsheet me-2"></i> Bulk Import Contacts (Excel / CSV)
                </div>
                
                <div class="card-body p-4">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <p class="text-muted small mb-4">
                        Upload an Excel file (<code>.xlsx</code>, <code>.xls</code>) or CSV containing directory entries. The system will automatically create user accounts and bind them to their respective districts, categories, and regions.
                    </p>

                    <form action="{{ route('admin.import.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="excel_file" class="form-label font-weight-bold">Select File (.xlsx, .xls, .csv)</label>
                            <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx, .xls, .csv" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-upload me-1"></i> Upload & Create Accounts
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Expected File Format Info Card -->
            <div class="card mt-4 border-0 bg-light">
                <div class="card-body">
                    <h6 class="font-weight-bold text-dark mb-2">Expected Spreadsheet Column Headers:</h6>
                    <code class="d-block bg-white p-2 border rounded text-primary mb-2">name | township | phonenumber | district | category | region | is_approved</code>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection