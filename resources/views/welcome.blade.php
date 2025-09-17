@auth
    <script>
        window.location.href = '{{ url('/dashboard') }}';
    </script>
@endauth

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arsenic Projects | Software Development Solutions</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/homepage.css', 'resources/js/app.js'])
</head>

<body class="homepage">
    <!-- Navigation -->
    <nav class="homepage-navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="#">ARSENIC <span>PROJECTS</span></a>

                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" style="border: none; background: none;">
                    <i class="fas fa-bars" style="color: white; font-size: 1.2rem;"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto d-flex align-items-center">
                        <li class="nav-item">
                            <a class="homepage-nav-link active" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="homepage-nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="homepage-nav-link" href="#services">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="homepage-nav-link" href="#contact">Contact</a>
                        </li>
                        
                        <!-- Authentication Links -->
                        @auth
                            <li class="nav-item ms-3">
                                <a href="{{ url('/dashboard') }}" class="btn-homepage-primary">Dashboard</a>
                            </li>
                            <li class="nav-item ms-2">
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item ms-3">
                                <a href="{{ route('login') }}" class="btn-homepage-primary">Login</a>
                            </li>
                            <li class="nav-item ms-2">
                                <a href="{{ route('register') }}" class="btn btn-outline-light">Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1>Building Digital <span style="color: var(--accent);">Solutions</span> That Matter</h1>
                        <p class="lead">Arsenic Projects delivers cutting-edge software development services. We transform ideas into
                            scalable, high-performance digital products with clean code and innovative approaches.</p>
                        <div class="d-flex gap-3 flex-wrap mt-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-homepage-primary">Go to Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn-homepage-primary">Get Started</a>
                                <a href="{{ route('register') }}" class="btn-homepage-outline">Join Us</a>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://images.unsplash.com/photo-1626785774573-4b799315345d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                        class="img-fluid floating" alt="Code Illustration"
                        style="border-radius: 20px; box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);">
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>About Arsenic Projects</h2>
                    <p class="lead">We are a team of passionate developers creating innovative solutions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Our Services</h2>
                    <p class="lead">Comprehensive software development solutions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Contact Us</h2>
                    <p class="lead">Ready to start your project? Get in touch!</p>
                    @guest
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary me-3">Login to Dashboard</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary">Create Account</a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
