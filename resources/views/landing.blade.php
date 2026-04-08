<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ScholarHub – Organize Your Academic Life</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    :root {
      --primary: #2c3e50;
      --secondary: #3498db;
      --accent: #e67e22;
      --light: #f8f9fa;
      --dark: #1e2a36;
    }
    body {
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      scroll-behavior: smooth;
    }
    .hero {
      background: linear-gradient(135deg, #f5f7fa 0%, #e9edf2 100%);
      padding: 100px 0;
    }
    .hero-title {
      font-size: 3.5rem;
      font-weight: 800;
      color: var(--primary);
      line-height: 1.2;
    }
    .hero-subtitle {
      font-size: 1.25rem;
      color: #5a6e7c;
      max-width: 500px;
    }
    .btn-primary-custom {
      background-color: var(--primary);
      border-color: var(--primary);
      padding: 12px 30px;
      font-weight: 600;
      border-radius: 40px;
    }
    .btn-primary-custom:hover {
      background-color: #1a2a36;
      border-color: #1a2a36;
    }
    .btn-outline-custom {
      border: 2px solid var(--primary);
      color: var(--primary);
      border-radius: 40px;
      padding: 12px 30px;
      font-weight: 600;
    }
    .btn-outline-custom:hover {
      background-color: var(--primary);
      color: white;
    }
    .feature-icon {
      font-size: 2.5rem;
      color: var(--secondary);
      margin-bottom: 1rem;
    }
    .feature-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: none;
      border-radius: 20px;
    }
    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 30px -10px rgba(0,0,0,0.1);
    }
    .section-title {
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 3rem;
      text-align: center;
    }
    .about-text {
      font-size: 1.1rem;
      line-height: 1.7;
      color: #4a5b68;
    }
    .contact-card {
      background-color: var(--light);
      border-radius: 24px;
      padding: 2rem;
      border: none;
    }
    footer {
      background-color: var(--primary);
      color: white;
      padding: 40px 0 20px;
    }
    .footer-link {
      color: #cddbe9;
      text-decoration: none;
      transition: color 0.2s;
    }
    .footer-link:hover {
      color: white;
    }
    .navbar {
      background-color: white;
      box-shadow: 0 2px 15px rgba(0,0,0,0.05);
      padding: 15px 0;
    }
    .nav-link {
      font-weight: 500;
      color: var(--dark);
      margin: 0 8px;
    }
    .nav-link:hover {
      color: var(--secondary);
    }
    .btn-login {
      background-color: transparent;
      border: 1px solid var(--primary);
      color: var(--primary);
      border-radius: 30px;
      padding: 6px 20px;
      font-weight: 500;
      transition: all 0.2s;
    }
    .btn-login:hover {
      background-color: var(--primary);
      color: white;
    }
    .btn-signup {
      background-color: var(--primary);
      border: none;
      color: white;
      border-radius: 30px;
      padding: 6px 20px;
      font-weight: 500;
      margin-left: 8px;
    }
    .btn-signup:hover {
      background-color: #1a2a36;
    }
    @media (max-width: 768px) {
      .hero-title {
        font-size: 2.2rem;
      }
      .hero {
        padding: 60px 0;
        text-align: center;
      }
      .hero-subtitle {
        margin-left: auto;
        margin-right: auto;
      }
    }
  </style>
</head>
<body>

  {{-- NAVBAR --}}
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold fs-4" href="/">
        <i class="fas fa-book-open me-2"></i>ScholarHub
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        </ul>
        <div class="d-flex">
          <a href="{{ route('login') }}" class="btn btn-login">Log In</a>
          <a href="{{ route('register') }}" class="btn btn-signup">Sign Up</a>
        </div>
      </div>
    </div>
  </nav>

  {{-- HERO SECTION --}}
  <section class="hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="hero-title">Your Academic Life, Beautifully Organized</h1>
          <p class="hero-subtitle my-4">
            ScholarHub brings together everything you need to succeed academically — tasks,
            notes, study materials, and resources — all in one elegant, distraction‑free workspace.
          </p>
          <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('register') }}" class="btn btn-primary-custom">Start Free Today <i class="fas fa-arrow-right ms-2"></i></a>
            <a href="#features" class="btn btn-outline-custom">Explore Features</a>
          </div>
        </div>
        <div class="col-lg-6 text-center">
          <img src="https://placehold.co/600x400/2c3e50/white?text=ScholarHub+Preview" alt="ScholarHub Dashboard Preview" class="img-fluid rounded-4 shadow-lg" style="max-width: 100%;">
        </div>
      </div>
    </div>
  </section>

  {{-- FEATURES SECTION --}}
  <section id="features" class="py-5" style="background-color: white;">
    <div class="container py-5">
      <h2 class="section-title">Everything you need, perfectly integrated</h2>
      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="card feature-card h-100 p-4 text-center shadow-sm">
            <i class="fas fa-tasks feature-icon"></i>
            <h5 class="fw-bold">Smart Tasks</h5>
            <p class="text-muted">Track pending, in‑progress, and completed tasks with due dates and subject labels.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card feature-card h-100 p-4 text-center shadow-sm">
            <i class="fas fa-sticky-note feature-icon"></i>
            <h5 class="fw-bold">Rich Notes</h5>
            <p class="text-muted">Create beautiful pages with a Notion‑like editor. Your ideas, formatted your way.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card feature-card h-100 p-4 text-center shadow-sm">
            <i class="fas fa-link feature-icon"></i>
            <h5 class="fw-bold">Resource Library</h5>
            <p class="text-muted">Save URLs, articles, and references – all organized and searchable.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card feature-card h-100 p-4 text-center shadow-sm">
            <i class="fas fa-chart-line feature-icon"></i>
            <h5 class="fw-bold">Progress Insights</h5>
            <p class="text-muted">Visual summaries of your productivity and task completion trends.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ABOUT SECTION --}}
  <section id="about" class="py-5 bg-light">
    <div class="container py-5">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <img src="https://placehold.co/500x400/white/2c3e50?text=Our+Story" alt="About ScholarHub" class="img-fluid rounded-4 shadow">
        </div>
        <div class="col-lg-6">
          <h2 class="fw-bold mb-3" style="color: var(--primary);">Designed for students, by students</h2>
          <p class="about-text">
            ScholarHub started as a small project to solve the chaos of managing multiple courses, deadlines, and digital resources. 
            We believe that academic success shouldn't require complex tools. Our platform gives you a clean, intuitive space to 
            focus on what really matters – learning and creating.
          </p>
          <p class="about-text mt-3">
            Join thousands of students who have transformed the way they study. No distractions, no clutter – just your academic life, 
            beautifully organized.
          </p>
          <a href="{{ route('register') }}" class="btn btn-primary-custom mt-3">Start your journey →</a>
        </div>
      </div>
    </div>
  </section>

  {{-- CONTACT SECTION --}}
  <section id="contact" class="py-5">
    <div class="container py-5">
      <h2 class="section-title">Get in touch</h2>
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="contact-card shadow-sm">
            <div class="row text-center">
              <div class="col-md-4 mb-3 mb-md-0">
                <i class="fas fa-envelope fa-2x mb-2" style="color: var(--secondary);"></i>
                <h6>Email</h6>
                <p class="text-muted">hello@scholarhub.com</p>
              </div>
              <div class="col-md-4 mb-3 mb-md-0">
                <i class="fas fa-map-marker-alt fa-2x mb-2" style="color: var(--secondary);"></i>
                <h6>Office</h6>
                <p class="text-muted">Manila, Philippines</p>
              </div>
              <div class="col-md-4">
                <i class="fab fa-twitter fa-2x mb-2" style="color: var(--secondary);"></i>
                <h6>Twitter</h6>
                <p class="text-muted">@ScholarHub</p>
              </div>
            </div>
            <hr class="my-4">
            <form action="#" method="POST" class="mt-3">
              @csrf
              <div class="row g-3">
                <div class="col-md-6">
                  <input type="text" class="form-control" placeholder="Your name" required>
                </div>
                <div class="col-md-6">
                  <input type="email" class="form-control" placeholder="Email address" required>
                </div>
                <div class="col-12">
                  <textarea class="form-control" rows="4" placeholder="Message..."></textarea>
                </div>
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-primary-custom px-5">Send Message</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- FOOTER --}}
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-5 mb-4">
          <i class="fas fa-book-open fs-3 mb-2"></i>
          <h5 class="mt-2 fw-bold">ScholarHub</h5>
          <p class="small" style="opacity: 0.8;">Empowering students to achieve more with less clutter.</p>
        </div>
        <div class="col-md-2 mb-4">
          <h6>Product</h6>
          <ul class="list-unstyled">
            <li><a href="#features" class="footer-link">Features</a></li>
            <li><a href="#about" class="footer-link">About</a></li>
            <li><a href="#" class="footer-link">Pricing</a></li>
          </ul>
        </div>
        <div class="col-md-2 mb-4">
          <h6>Support</h6>
          <ul class="list-unstyled">
            <li><a href="#contact" class="footer-link">Contact</a></li>
            <li><a href="#" class="footer-link">Help Center</a></li>
            <li><a href="#" class="footer-link">Privacy</a></li>
          </ul>
        </div>
        <div class="col-md-3 mb-4">
          <h6>Follow Us</h6>
          <div class="d-flex gap-3">
            <a href="#" class="footer-link"><i class="fab fa-facebook-f fa-lg"></i></a>
            <a href="#" class="footer-link"><i class="fab fa-twitter fa-lg"></i></a>
            <a href="#" class="footer-link"><i class="fab fa-instagram fa-lg"></i></a>
            <a href="#" class="footer-link"><i class="fab fa-github fa-lg"></i></a>
          </div>
        </div>
      </div>
      <hr class="opacity-25">
      <div class="text-center small" style="opacity: 0.7;">
        &copy; {{ date('Y') }} ScholarHub. All rights reserved.
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>