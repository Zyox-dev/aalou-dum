<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Navya Jewels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


    <!-- CSS Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .fancy-link {
            display: inline-block;
            color: #0d6efd;
            font-weight: 500;
            text-decoration: none;
            margin-right: 15px;
            position: relative;
            transition: all 0.3s ease;
        }

        .fancy-link:hover {
            color: #084298;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fffaf5;
            color: #3e2c23;
        }


        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
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

        .product-img {
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
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

    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid px-5">
            <a class="navbar-brand text-dark fw-bold fs-3" href="/">Navya Jewels</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
                            href="/about">About Us</a></li>
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
    <footer>
        <div class="container">
            <div class="row text-start">
                <div class="col-md-4">
                    <h5>About Navya Jewels</h5>
                    <p>YourJewels is dedicated to providing the finest handcrafted gold and diamond jewellery. Trusted
                        by thousands of customers across India for over a decade.</p>
                </div>
                <div class="col-md-4 text-center">
                    {{-- <h5>Quick Links</h5>
                    <div class="footer-links text-center d-flex flex-column align-items-center gap-2">
                        <a href="#" class="footer-btn">
                            <i class="bi bi-house-door-fill me-2"></i> Home
                        </a>
                        <a href="#" class="footer-btn" onclick="toggleSection('contact')">
                            <i class="bi bi-envelope-fill me-2"></i> Contact
                        </a>
                    </div> --}}
                </div>
                <div class="col-md-4">
                    <h5>Follow Us</h5>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                    <p class="mt-3">Email: support@yourjewels.com<br>Phone: +91 9876543210</p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; 2025 Navya Jewels. All Rights Reserved. | <a href="#"
                        class="text-decoration-none">Privacy Policy</a> | <a href="#"
                        class="text-decoration-none">Terms of Service</a></p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
