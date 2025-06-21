@extends('layouts.public.app')

@section('title', 'About Us')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
.about-hero {
    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
    color: white;
    text-align: center;
}

.about-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    opacity: 0.15;
    z-index: 1;
}

.about-hero-content {
    position: relative;
    z-index: 2;
}

.about-hero h1 {
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    font-weight: 800;
    margin-bottom: 20px;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.breadcrumb {
    justify-content: center;
    background: transparent;
    padding: 0;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
}

.breadcrumb-item a:hover {
    color: white;
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.6);
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.6);
}

.about-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
}

.section-title {
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 30px;
    position: relative;
    display: inline-block;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 2px;
}

.about-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #4b5563;
    margin-bottom: 20px;
}

.feature-section {
    padding: 60px 0;
    background: white;
}

.feature-card {
    background: white;
    border-radius: 20px;
    padding: 40px 30px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid rgba(229, 231, 235, 0.7);
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.12);
}

.feature-icon {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(37, 99, 235, 0.1));
    border-radius: 20px;
    margin-bottom: 25px;
    color: #3b82f6;
    font-size: 2rem;
}

.feature-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 15px;
}

.about-image-container {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
}

.about-image {
    width: 100%;
    height: auto;
    transition: transform 0.5s ease;
}

.about-image-container:hover .about-image {
    transform: scale(1.05);
}

.highlight-text {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    font-weight: 700;
}

.team-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
}

.team-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    margin-bottom: 30px;
}

.team-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.team-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
}

.team-info {
    padding: 25px;
    text-align: center;
}

.team-name {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 5px;
}

.team-position {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 15px;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.social-link {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f3f4f6;
    color: #6b7280;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: #3b82f6;
    color: white;
    transform: translateY(-3px);
}

.stats-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.stat-item {
    text-align: center;
    padding: 30px;
    position: relative;
    z-index: 2;
}

.stat-number {
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    font-weight: 800;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 1.1rem;
    opacity: 0.9;
}

.fade-in {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
}

.fade-in.visible {
    opacity: 1;
    transform: translateY(0);
}

@media (max-width: 991.98px) {
    .about-section, .feature-section, .team-section, .stats-section {
        padding: 60px 0;
    }
    
    .feature-card {
        padding: 30px 20px;
    }
}

@media (max-width: 767.98px) {
    .about-hero {
        padding: 100px 0 60px;
    }
    
    .about-section, .feature-section, .team-section, .stats-section {
        padding: 50px 0;
    }
    
    .about-text {
        font-size: 1rem;
    }
    
    .feature-icon {
        width: 70px;
        height: 70px;
        font-size: 1.8rem;
        margin-bottom: 20px;
    }
    
    .feature-title {
        font-size: 1.2rem;
    }
}

@media (max-width: 575.98px) {
    .about-hero {
        padding: 80px 0 40px;
    }
    
    .about-section, .feature-section, .team-section, .stats-section {
        padding: 40px 0;
    }
    
    .feature-card {
        padding: 25px 15px;
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
}
</style>




<div class="about-section" style="margin-top: 100px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0 fade-in">
                <h2 class="section-title">Our Story</h2>
                <p class="about-text">
                    Welcome to <span class="highlight-text">Baytak</span>, your trusted online platform for real estate rental and sales. At Baytak, we empower property owners and sellers by allowing them to easily register on our website, list their properties, and manage their listings directly — all in one place, with full control to update and modify their property details anytime.
                </p>
                <p class="about-text">
                    Our mission is to simplify the property market by connecting buyers, renters, and sellers efficiently and transparently. We combine technology with professionalism to provide an intuitive, user-friendly experience that saves you time and effort.
                </p>
            </div>
            <div class="col-lg-6 fade-in">
                <div class="about-image-container">
                    <img src="https://cdn.pixabay.com/photo/2020/05/09/09/13/house-5148865_1280.jpg" alt="Modern House" class="about-image">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="feature-section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center fade-in">
                <h2 class="section-title">Why Choose Baytak?</h2>
                <p class="about-text">We combine innovation with expertise to deliver exceptional real estate services</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4 fade-in">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3 class="feature-title">Quality Properties</h3>
                    <p class="about-text">We carefully vet all listings to ensure you only see high-quality, legitimate properties that meet our standards.</p>
                </div>
            </div>
            
            <div class="col-md-4 fade-in" style="transition-delay: 0.1s">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Property Valuation</h3>
                    <p class="about-text">Our unique valuation tool gives instant estimates and connects you with professional appraisers for accurate assessments.</p>
                </div>
            </div>
            
            <div class="col-md-4 fade-in" style="transition-delay: 0.2s">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="feature-title">Trusted Network</h3>
                    <p class="about-text">We work with verified agents and property owners to ensure safe and reliable transactions for all parties.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2 mb-5 mb-lg-0 fade-in">
                <h2 class="section-title">Our Unique Value</h2>
                <p class="about-text">
                    A unique feature we proudly offer is our <strong>"Guess Your Property Value"</strong> tool. Property owners can enter key details about their property and receive an immediate preliminary valuation.
                </p>
                <p class="about-text">
                    Additionally, they can schedule an appointment with a professional appraiser to visit their property at a convenient time, ensuring an accurate and personalized assessment. These appraisers are an integral part of the Baytak team, working closely with us to deliver trustworthy and expert service.
                </p>
                <p class="about-text">
                    At Baytak, we are committed to making real estate transactions smoother, smarter, and more reliable for everyone involved.
                </p>
            </div>
            <div class="col-lg-6 order-lg-1 fade-in">
                <div class="about-image-container">
                    <img src="https://cdn.pixabay.com/photo/2016/10/06/17/28/architecture-1719526_1280.jpg" alt="Property Valuation" class="about-image">
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => { entry.target.classList.add('visible'); }, index * 100);
            }
        });
    }, observerOptions);
    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    // Animation for feature cards on hover
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            const icon = card.querySelector('.feature-icon');
            icon.style.transform = 'rotate(5deg) scale(1.1)';
            icon.style.boxShadow = '0 10px 25px rgba(59, 130, 246, 0.3)';
        });
        card.addEventListener('mouseleave', () => {
            const icon = card.querySelector('.feature-icon');
            icon.style.transform = 'rotate(0) scale(1)';
            icon.style.boxShadow = 'none';
        });
    });
});

// Add some dynamic styling
const style = document.createElement('style');
style.textContent = `
    .feature-icon {
        transition: all 0.3s ease;
    }
    .about-image-container {
        transition: all 0.3s ease;
    }
    .stat-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 1px;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
    }
    .stat-item:first-child::before {
        display: none;
    }
    @media (max-width: 767.98px) {
        .stat-item::before {
            display: none;
        }
    }
`;
document.head.appendChild(style);
</script>

@endsection