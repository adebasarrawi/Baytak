@extends('layouts.public.app')

@section('title', 'Contact Us')

@section('content')
<style>



@media (max-width: 767.98px) {
    .title-section {
        text-align: center;
        padding: 2rem 0;
    }
    
    .title-section h1 {
        font-size: 2rem;
    }
    
    .title-section .breadcrumb {
        justify-content: center;
    }
    
    .title-section i {
        display: none;
    }
}
    .contact-section {
        padding: 30px 0;
        min-height: 100vh;
    }

    .contact-hero {
        padding: 100px 0 80px;
        text-align: center;
        color: white;
        margin-bottom: 50px;
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3QgZmlsbD0idXJsKCNwYXR0ZXJuKSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIvPjwvc3ZnPg==');
    }

    .contact-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 700;
        margin-bottom: 16px;
        position: relative;
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
        color: white;
        font-weight: 600;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }

    .contact-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 30px 90px rgba(0, 0, 0, 0.15);
        margin-bottom: 30px;
        transition: all 0.4s ease;
    }

    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 35px 100px rgba(0, 0, 0, 0.2);
    }

    .contact-info-item {
        margin-bottom: 25px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .contact-info-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .contact-info-content h4 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .contact-info-content p {
        color: #6b7280;
        font-size: 0.95rem;
        margin: 0;
    }
    .section-header {
    text-align: center;
    margin-bottom: 50px;
}

.section-title {
    font-size: clamp(2rem, 4vw, 2.5rem);
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 16px;
    margin-top: 20px;
}


    .contact-form .form-control, 
    .contact-form .form-select {
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.95rem;
        color: #1f2937;
        background: white;
        transition: all 0.2s ease;
        width: 100%;
        margin-bottom: 20px;
    }

    .contact-form .form-control:focus, 
    .contact-form .form-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .contact-form textarea {
        min-height: 150px;
        resize: vertical;
    }

    .submit-btn {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        color: white;
        transition: all 0.2s ease;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(59, 130, 246, 0.4);
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
    }

    .submit-btn.loading {
        position: relative;
        color: transparent;
        pointer-events: none;
    }

    .submit-btn.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @media (max-width: 991.98px) {
        .contact-hero {
            padding: 80px 0 60px;
        }
        
        .contact-card {
            padding: 25px;
        }
    }

    @media (max-width: 767.98px) {
        .contact-hero {
            padding: 70px 0 50px;
            margin-bottom: 40px;
        }
        
        .contact-card {
            padding: 20px;
            border-radius: 15px;
        }
        
        .contact-info-item {
            flex-direction: column;
        }
    }

    @media (max-width: 575.98px) {
        .contact-hero {
            padding: 60px 0 40px;
            margin-bottom: 30px;
        }
        
        .contact-title {
            font-size: 1.8rem;
        }
        
        .contact-info-icon {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
        }
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
</style>

  <div class="section-header fade-in" style="margin-top: 150px;">
            <h2 class="section-title">Contact Our Team</h2>
            <p class="section-subtitle">Let’s stay connected,Send us your thoughts or inquiries.

</p>
        </div>


    <div class="container" >
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="contact-card fade-in">
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-info-content">
                            <h4>Location</h4>
                            <p>Jordan, Amman</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-info-content">
                            <h4>Open Hours</h4>
                            <p>Sunday-Thursday<br>9:00 AM - 9:00 PM</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-info-content">
                            <h4>Email</h4>
                            <p>adeba.alsarrawi@gmail.com</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-info-content">
                            <h4>Call</h4>
                            <p>+962 772 328 028</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="contact-card fade-in">
                    <h3 class="mb-4" style="color: #1f2937; font-weight: 700;">Send Us a Message</h3>
                    <form action="https://formsubmit.co/adeba.alsarrawi@gmail.com" method="POST" class="contact-form">
                        <input type="hidden" name="_subject" value="New Contact Form Submission">
                        <input type="hidden" name="_captcha" value="false">
                        <input type="hidden" name="_template" value="table">
                        <input type="hidden" name="_next" value="{{ url('/contact-thank-you') }}">
                        <input type="text" name="_honey" style="display:none">

                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Your Name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" placeholder="Your Email" name="email" required>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" placeholder="Subject" name="subject" required>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" placeholder="Your Message" name="message" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="submit-btn" id="submit-btn">
                                    <i class="fas fa-paper-plane me-1"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fade-in animation
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => { entry.target.classList.add('visible'); }, index * 100);
            }
        });
    }, observerOptions);
    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    // Form submission loading state
    const form = document.querySelector('.contact-form');
    const submitBtn = document.getElementById('submit-btn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });
    }

    // Hover effects for cards
    const contactCards = document.querySelectorAll('.contact-card');
    contactCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });

    // Input focus effects
    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('focus', () => {
            input.style.borderColor = '#3b82f6';
            input.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.1)';
        });
        input.addEventListener('blur', () => {
            if(!input.value) {
                input.style.borderColor = '#e5e7eb';
                input.style.boxShadow = 'none';
            }
        });
    });
});
</script>
@endsection