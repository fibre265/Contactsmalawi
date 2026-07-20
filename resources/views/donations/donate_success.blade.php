@extends('layouts.generalLayout')
@section('content')

<style>
    .success-card {
        background: #ffffff;
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.08);
        margin-top: 50px;
        border-top: 5px solid #28a745; /* Green color accent for success */
    }
    .success-icon {
        font-size: 4rem;
        color: #28a745;
    }
    .transaction-details {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }
</style>

<div class="container d-flex justify-content-center">
    <div class="col-md-6">
        <div class="success-card text-center">
            
            <div class="mb-3">
                <i class="bi bi-check-circle-fill success-icon"></i>
            </div>

            <h2 class="text-success mb-2">Thank You, {{ $donation->donor_name }}!</h2>
            <p class="text-muted">Your donation to the unified contacts system was received and tracked successfully.</p>

            <div class="transaction-details text-start">
                <h4 class="h6 text-uppercase text-muted border-bottom pb-2 mb-3">Transaction Summary</h4>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Amount Contributed:</span>
                    <strong class="text-dark">MWK {{ number_format($donation->amount, 2) }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Tracking Reference:</span>
                    <small class="text-monospace text-dark font-weight-bold">{{ $donation->tx_ref }}</small>
                </div>

                <div class="d-flex justify-content-between mb-0">
                    <span class="text-secondary">Payment Status:</span>
                    <span class="badge bg-success text-uppercase">Completed</span>
                </div>
            </div>

            <div class="mt-4 pt-2">
                <a href="{{ route('donate.form') }}" class="btn btn-outline-primary btn-sm me-2">
                    <i class="bi bi-heart"></i> Donate Again
                </a>
                <a href="/" class="btn btn-primary btn-sm">
                    <i class="bi bi-house"></i> Return Home
                </a>
            </div>

        </div>
    </div>
</div>

@endsection