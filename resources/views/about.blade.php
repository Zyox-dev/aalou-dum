@extends('layouts.app')

@push('styles')
    <style>
        .hero-banner {
            background: linear-gradient(to right, #fce3d1, #f7f0e8);
            padding: 100px 20px;
            text-align: center;
        }

        .hero-banner h1 {
            font-size: 3.5rem;
            color: #7c3e2f;
            font-weight: bold;

        }

        .hero-banner p {
            font-size: 1.2rem;
            color: #5e503f;
        }

        .highlight-box {
            background-color: #f7f0e8;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .product-img {
            max-height: 400px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background-color: #7c3e2f;
            color: #fff;
            border-radius: 8px;
            padding: 10px 20px;
        }

        .btn-custom:hover {
            background-color: #5a261c;
        }
    </style>
@endpush

@section('content')
    <div class="hero-banner">
        <h1>Navya Jewels</h1>
        <p>Elegance. Craftsmanship. Trust. That's the spirit of {{ $company->company_name ?? 'Your Jewels' }}.</p>
    </div>

    <section class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                @if ($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" class="rounded shadow"
                        style="max-width: 80%; height: 80%;" alt="Company Logo">
                @else
                    <img src="{{ asset('uploads/image.png') }}" class="rounded shadow" style="max-width: 80%; height: 80%;"
                        alt="Craftsmanship">
                @endif
            </div>

            <div class="col-md-6">
                <div class="highlight-box">
                    <h3 class="section-title">Who We Are</h3>
                    <p>Your Jewels is a luxury jewellery brand founded with the vision of reviving timeless designs
                        while embracing modern elegance.</p>

                    <div class="company-info">
                        <p><strong>Company Name:</strong> {{ $company->company_name ?? '-' }}</p>
                        <p><strong>Address:</strong> {{ $company->address ?? '-' }}</p>
                        <p><strong>GSTIN:</strong> {{ $company->gstin ?? '-' }}</p>
                        <p><strong>PAN No:</strong> {{ $company->pan_no ?? '-' }}</p>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
