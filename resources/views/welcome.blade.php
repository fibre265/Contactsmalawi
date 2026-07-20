<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Contactsmw - Find Emergency Contacts</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top header-transparent">
        <div class="container d-flex align-items-center justify-content-between position-relative">

            <div class="logo">
                <h1 class="text-light"><a href="/"><span>Contactsmw</span></a></h1>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto" href="/donate">Donate</a></li>

                    <div class="dropdown">
                        <a href="#"><span>about menu</span> <i class="bi bi-chevron-down"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuOne">
                            <li><a class="dropdown-item" href="/stories"> Success Stories</a></li>
                            <li><a class="dropdown-item" href="/about">About Contact Malawi</a></li>
                        </ul>
                    </div>

                    <!-- Categories Dropdown -->
                    <li class="dropdown">
                        <a href="#"><span>Categories</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="/allCategories/">all categories</a></li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="/search_category/{{ $category->id ?? $category->category }}">
                                        {{ $category->category }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    
                    <!-- Districts Megamenu Dropdown -->
                    <li class="dropdown megamenu">
                        <a href="#"><span>Go To District</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li>
                                <strong>Southern Region <i class="bx bx-phone-call"></i></strong>
                                @foreach($southerndistricts as $southerndistrict)
                                    <a href="/search_region/1">{{ $southerndistrict->district }}</a>
                                @endforeach
                            </li>
                            <li>
                                <strong>Central Region <i class="bx bx-phone-call"></i></strong>
                                @foreach($centraldistricts as $centraldistrict)
                                    <a href="/search_region/2">{{ $centraldistrict->district }}</a>
                                @endforeach
                            </li>
                            <li>
                                <strong>Northern Region <i class="bx bx-phone-call"></i></strong>
                                @foreach($notherndistricts as $notherndistrict)
                                    <a href="/search_region/3">{{ $notherndistrict->district }}</a>
                                @endforeach
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Authentication Links -->
                    @if (Route::has('login'))
                        @auth
                            <li><a class="nav-link scrollto" href="/dashboard">Dashboard</a></li>
                        @else
                            <li><a class="nav-link scrollto" href="{{ route('login') }}">Login</a></li> 
                            @if (Route::has('register'))
                                <li><a class="nav-link scrollto" href="{{ route('register') }}">Register</a></li>  
                            @endif
                        @endauth
                    @endif
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>

        </div>
    </header>

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center justify-content-center py-5" style="min-height: 100vh; background-size: cover;">
        <div class="hero-container pt-5 mt-4 d-flex flex-column align-items-center justify-content-center text-center mx-auto" data-aos="fade-up" style="max-width: 600px; width: 100%; padding-left: 15px; padding-right: 15px; float: none;">
            <h1 class="mb-2 text-center w-100"><i>Contactsmalawi</i></h1>
            <h2 class="mb-4 fs-5 text-center w-100"><i>Find the emergency contact within your area</i></h2>

            <div class="main-form-wrapper bg-black bg-opacity-25 p-4 rounded-3 shadow-sm w-100 text-start">
                <form method="POST" action="{{ route('submit_searches') }}">
                    @csrf

                    <div class="mb-3">
                        <select name="district" class="form-select form-control-lg">
                            <option disabled selected>-------- district --------</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->district }}">{{ $district->district }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <select name="category" class="form-select form-control-lg">
                            <option disabled selected>-------- category --------</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4"> 
                        <input name="name" type="text" class="form-control form-control-lg" placeholder="-Name- e.g Kawale Police">
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg" type="submit">
                            <i class="bx bx-search align-middle me-1"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- ======= Main Content Wrapper ======= -->
    <main id="main">

        <!-- ======= Quick Emergency Contacts Section ======= -->
        <section id="contacts" class="contacts section-bg">
            <div class="container">
                <div class="row">
                    <h2 class="col-12 text-center mb-5">Quick Emergency Contacts</h2>

                    @foreach ($users as $user)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="count-box mb-3">
                                        <i class="bi bi-headset mb-2 d-inline-block fs-3 text-primary"></i>
                                        <span data-purecounter-start="0" data-purecounter-end="{{ $user->email }}" data-purecounter-duration="1" class="purecounter d-block fs-5 fw-bold mb-1"></span>
                                        <p class="card-text">
                                            <strong>{{ $user->name }}</strong><br>
                                            <span class="text-muted text-sm">{{ $user->township }} from {{ $user->district->district ?? '' }}</span>
                                        </p>
                                    </div>
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-primary w-100">
                                        call now <i class="bx bx-phone-call ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ======= Regions Section ======= -->
        <section id="services" class="services">
            <div class="container">
                <div class="section-title" data-aos="fade-in" data-aos-delay="100">
                    <h2>Narrow your search</h2>
                    <p>Choose a region where the contact you are looking for is located</p>
                </div>

                <div class="row justify-content-center">
                    @foreach ($regions as $region)
                        <div class="col-md-4 col-lg-3 d-flex align-items-stretch mb-4">
                            <a href="/search_region/{{ $region->id }}" class="w-100 text-decoration-none">
                                <div class="icon-box w-100 p-4 border rounded shadow-sm text-center" data-aos="fade-up">
                                    <div class="icon mb-3 fs-2 text-primary">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>
                                    <h4 class="title fw-bold text-dark mb-2">
                                        {{ $region->region }} Region
                                    </h4>
                                    <p class="description text-muted small mb-0">
                                        View emergency contacts in the {{ strtolower($region->region) }} Region.
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top py-5 border-top bg-light text-dark">
            <div class="container">
                <div class="row justify-content-between">
                    
                    <!-- Brand & Info Column -->
                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                        <div class="footer-info">
                            <h3 class="text-primary fw-bold mb-3">Contactsmw</h3>
                            <p class="text-muted mb-4 small">
                                The unified directory platform bridging communities, professional networks, and local emergency services across Malawi.
                            </p>
                            <p class="mb-1 text-muted"><strong>Phone:</strong> +265 88 170 40 32</p>
                            <p class="text-muted"><strong>Email:</strong> info@contactsmw.com</p>
                            
                            <div class="social-links mt-3">
                                <a href="#" class="twitter btn btn-outline-secondary btn-sm me-1 rounded-circle"><i class="bx bxl-twitter"></i></a>
                                <a href="#" class="facebook btn btn-outline-secondary btn-sm me-1 rounded-circle"><i class="bx bxl-facebook"></i></a>
                                <a href="#" class="instagram btn btn-outline-secondary btn-sm rounded-circle"><i class="bx bxl-instagram"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Navigation Links Column -->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h4 class="h6 text-uppercase fw-bold mb-3 text-dark">Useful Links</h4>
                        <ul class="list-unstyled footer-links text-sm">
                            <li class="mb-2"><a href="/" class="text-muted text-decoration-none hover-primary"><i class="bi bi-chevron-right me-1 text-primary small"></i> About Us</a></li>
                            <li class="mb-2"><a href="/donate" class="text-muted text-decoration-none hover-primary"><i class="bi bi-chevron-right me-1 text-primary small"></i> Donate Platform</a></li>
                            <li class="mb-2"><a href="/stories" class="text-muted text-decoration-none hover-primary"><i class="bi bi-chevron-right me-1 text-primary small"></i> Success Stories</a></li>
                            <li class="mb-2"><a href="/allCategories/" class="text-muted text-decoration-none hover-primary"><i class="bi bi-chevron-right me-1 text-primary small"></i> Directory Categories</a></li>
                        </ul>
                    </div>

                    <!-- Newsletter Form Column -->
                    <div class="col-lg-4 col-md-12">
                        <h4 class="h6 text-uppercase fw-bold mb-3 text-dark">Our Newsletter</h4>
                        <p class="text-muted small mb-3">Subscribe to stay updated with regional directory additions and community alerts.</p>
                        
                        @if(session('success'))
                            <div class="alert alert-success py-2 px-3 mb-3 small" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('newsletter.subscribe') }}" method="post">
                            @csrf
                            <div class="input-group mb-1 shadow-sm">
                                <input type="email" name="email" class="form-control rounded-start" placeholder="Email Address" required>
                                <button class="btn btn-primary" type="submit">Subscribe</button>
                            </div>
                            @error('email')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Copyright Block -->
        <div class="container text-center py-4 border-top border-light-subtle">
            <div class="copyright small text-muted">
                &copy; {{ date('Y') }} <strong><span>Contactsmw</span></strong>. All Rights Reserved.
            </div>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>
</html>