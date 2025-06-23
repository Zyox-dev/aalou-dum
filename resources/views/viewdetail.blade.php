@extends('layouts.app')

@section('title', $product->name . ' - Product Details')

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
    <!-- Hero Banner -->
    <div class="hero-banner">
        <h1>{{ $company->company_name ?? 'Navya Jewels' }}</h1>
        <p>Elegance. Craftsmanship. Trust. That's the spirit of {{ $company->company_name ?? 'Your Jewels' }}.</p>
    </div>


    <!-- Product Detail Section -->
    <section class="container my-5">
        <div class="row align-items-center g-5">
            <div class="col-md-6 d-flex justify-content-center">
                <img src="{{ asset($product->image ? $product->image[0]->image_path : 'uploads/image1.jpg') }}"
                    class="img-fluid product-img" alt="{{ $product->name }}">
            </div>
            <div class="col-md-6">
                <div class="highlight-box">
                    <h2 class="mb-3">{{ $product->name }}</h2>
                    <h5 class="text-muted">Price: ₹{{ $product->mrp }}</h5>
                    <p class="mt-3">{{ $product->description }}</p>
                    <a href="{{ url('/') }}" class="btn btn-custom mt-3">← Back to Home</a>
                </div>
            </div>
        </div>
    </section>
@endsection
