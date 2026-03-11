@extends('layouts.app')

@section('title', 'Welcome to RC Admin')

@section('styles')
<style>
    .hero-section {
        padding: 100px 0;
        background: linear-gradient(135deg, #ffffff 0%, #f0f4f8 100%);
        overflow: hidden;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        background: linear-gradient(45deg, #0d6efd, #00d4ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: #6c757d;
        margin-bottom: 2rem;
    }

    .card-feature {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        background: #fff;
        padding: 30px;
        height: 100%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .card-feature:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }

    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 1.5rem;
    }

    .bg-soft-primary { background-color: #e7f1ff; color: #0d6efd; }
    .bg-soft-success { background-color: #e8fadf; color: #198754; }
    .bg-soft-info { background-color: #e1f6fc; color: #0dcaf0; }
    .bg-soft-warning { background-color: #fff9e6; color: #ffc107; }

    .glow-img {
        border-radius: 20px;
        box-shadow: 0 0 50px rgba(13, 110, 253, 0.2);
    }
</style>
@endsection

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title animate__animated animate__fadeInUp">Modern Gaming Center Management</h1>
                <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
                    Streamline your business operations with RC Admin. Manage records, inventory, and outcomes all in one powerful dashboard.
                </p>
                <div class="d-flex gap-3 animate__animated animate__fadeInUp animate__delay-2s">
                    <a href="{{ url('/admin') }}" class="btn btn-premium">Get Started</a>
                    <a href="#features" class="btn btn-outline-secondary rounded-pill px-4">Learn More</a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 text-center">
                <img src="https://img.freepik.com/free-vector/gaming-concept-landing-page_23-2148235255.jpg?w=826" alt="Dashboard Preview" class="img-fluid glow-img animate__animated animate__zoomIn">
            </div>
        </div>
    </div>
</section>

<section id="features" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="badge bg-soft-primary rounded-pill px-3 py-2 mb-3">Features</span>
            <h2 class="fw-bold h1">Everything you need to thrive</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card-feature">
                    <div class="icon-box bg-soft-primary">
                        <i class="fa fa-chart-line"></i>
                    </div>
                    <h4>Analytics</h4>
                    <p class="text-muted">Real-time data visualization of your center performance.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card-feature">
                    <div class="icon-box bg-soft-success">
                        <i class="fa fa-boxes-stacked"></i>
                    </div>
                    <h4>Inventory</h4>
                    <p class="text-muted">Keep track of your drinks and stock levels effortlessly.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card-feature">
                    <div class="icon-box bg-soft-info">
                        <i class="fa fa-users"></i>
                    </div>
                    <h4>Member Mgmt</h4>
                    <p class="text-muted">Detailed records of members and online sessions.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card-feature">
                    <div class="icon-box bg-soft-warning">
                        <i class="fa fa-wallet"></i>
                    </div>
                    <h4>Financials</h4>
                    <p class="text-muted">Track outcomes and debts with precision.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="bg-primary rounded-4 p-5 text-white text-center position-relative overflow-hidden">
            <div class="position-relative z-1">
                <h2 class="fw-bold h1 mb-3">Ready to transform your center?</h2>
                <p class="mb-4 opacity-75">Join dozens of gaming centers already using RC Admin.</p>
                <a href="{{ url('/admin') }}" class="btn btn-light rounded-pill px-5 fw-bold text-primary">Join RC Admin</a>
            </div>
        </div>
    </div>
</section>
@endsection
