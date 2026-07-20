@extends('layouts.generalLayout')
@section('content')

<div class="container d-flex justify-content-center">
    <div class="col-md-6">
        <div class="donation-card">
            <h2 class="text-center text-primary mb-3">Support Unified Contacts System</h2>
            
            <p class="text-muted text-center mb-4">
                Your donations help keep the Malawian emergency directory live, updated, and accessible to everyone. Your contributions directly fund:
            </p>

            <!-- Refactored Feature Points Section -->
            <div class="purpose-list mb-4 text-muted">
                <div class="purpose-item">
                    <span class="purpose-icon">✓</span>
                    <span><strong>Server & Hosting Infrastructure:</strong> Maintaining reliable and secure servers to keep the platform online 24/7.</span>
                </div>
                <div class="purpose-item">
                    <span class="purpose-icon">✓</span>
                    <span><strong>Public Awareness & Outreach:</strong> Advertising and promoting the platform so more Malawians know where to turn during emergencies.</span>
                </div>
                <div class="purpose-item">
                    <span class="purpose-icon">✓</span>
                    <span><strong>Continuous Data Operations:</strong> Dedicated human resources to verify, update, and manage information in real-time.</span>
                </div>
            </div>

            <form action="{{ route('donate.initialize') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Your Name (Optional)</label>
                    <input type="text" name="donor_name" class="form-control" placeholder="e.g., Lawrence">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Email Address (Optional)</label>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary">Amount (MWK) <span class="text-danger">*</span></label>
                    <input type="number" name="amount" class="form-control" placeholder="Minimum 500 MWK" required min="500">
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold shadow-sm">
                    Donate via Mobile Money / Card
                </button>
            </form>
        </div>
    </div>
</div>

@endsection