@extends('layouts.app')

@push('styles')
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fffaf5;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .hero {
            background: linear-gradient(to right, #f9f4ef, #f0e7dc);
            padding: 0;
            overflow: hidden;
        }

        .carousel-item img {
            height: 550px;
            object-fit: cover;
        }

        .btn-shop {
            background-color: #7c3e2f;
            color: #fff;
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 30px;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            margin: 0 10px;
        }

        .top-bar {
            font-size: 0.9rem;
            background-color: #f8f3ef;
            padding: 5px 0;
            text-align: center;
        }

        footer {
            background-color: #f2e9e4;
            padding: 20px 0;
            text-align: center;
            color: #5e503f;
            font-size: 0.9rem;
        }

        .product-card {
            height: 100%;
            border: none;
            transition: transform 0.3s ease;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            height: 220px;
            object-fit: cover;
            width: 100%;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .product-card img:hover {
            transform: scale(1.05);
        }

        .form-control,
        .form-label {
            font-size: 0.95rem;
        }

        #register,
        #contact {
            display: none;
        }

        .footer-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border: 2px solid #7c3e2f;
            background-color: #fffaf5;
            color: #7c3e2f;
            border-radius: 30px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-btn:hover {
            background-color: #7c3e2f;
            color: #fff;
            transform: translateY(-2px);
        }

        .footer-links .bi {
            font-size: 1.2rem;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Carousel -->
    <div id="carouselHero" class="carousel slide hero" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('uploads/image1.jpg') }}" class="d-block w-100" alt="Jewellery 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('uploads/image2.jpg') }}" class="d-block w-100" alt="Jewellery 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('uploads/image3.jpg') }}" class="d-block w-100" alt="Jewellery 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselHero" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselHero" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Featured Products Section -->
    <section class="container my-3">

        <h2 class="text-center mb-6 animate__animated animate__fadeInDown">Featured Products</h2>
        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-md-3 d-flex">
                    <div class="card product-card animate__animated animate__zoomIn w-100">
                        <img src="{{ asset($product->image ? $product->image[0]->image_path : 'uploads/image1.jpg') }}"
                            class="card-img-top" alt="Product 1">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            {{-- <p class="card-text">18KT Elegant Gold Necklace</p> --}}
                            <a href="{{ url('/product/view/' . $product->id) }}" class="btn btn-outline-dark btn-sm">View
                                Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSection(id) {
            document.getElementById('register')?.style.display = 'none';
            document.getElementById('contact')?.style.display = 'none';
            document.getElementById(id).style.display = 'block';
            window.scrollTo({
                top: document.getElementById(id).offsetTop - 80,
                behavior: 'smooth'
            });
        }
    </script>
@endpush
