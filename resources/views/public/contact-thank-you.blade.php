@extends('layouts.public.app')

@section('title', 'Thank You for Contacting Us')

@section('content')
<style>
    .thank-you-section {
        background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
        padding: 30px 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .thank-you-hero {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        padding: 100px 0;
        text-align: center;
        color: white;
        margin-bottom: 50px;
        position: relative;
        overflow: hidden;
    }

    .thank-you-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3QgZmlsbD0idXJsKCNwYXR0ZXJuKSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIvPjwvc3ZnPg==');
    }

    .thank-you-title {
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

    .thank-you-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        padding: 50px;
        box-shadow: 0 30px 90px rgba(0, 0, 0, 0.15);
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        transition: all 0.4s ease;
    }

    .thank-you-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 35px 100px rgba(0, 0, 0, 0.2);
    }

    .thank-you-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto 30px;
        transition: all 0.5s ease;
    }

    .thank-you-icon i {
        transition: all 0.5s ease;
    }

    .thank-you-content h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
    }

    .thank-you-content p {
        color: #6b7280;
        font-size: 1.1rem;
        margin-bottom: 30px;
    }

    .message-details {
        background: #f8fafc;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        border: 1px solid #e5e7eb;
    }

    .message-details p {
        margin-bottom: 0;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-home {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        color: white;
        transition: all 0.2s ease;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-home:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(59, 130, 246, 0.4);
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
    }

    .btn-properties {
        background: white;
        border: 2px solid #3b82f6;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        color: #3b82f6;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-properties:hover {
        background: #f3f4f6;
        transform: translateY(-2px);
        color: #2563eb;
    }

    @media (max-width: 991.98px) {
        .thank-you-hero {
            padding: 80px 0;
        }
        
        .thank-you-card {
            padding: 40px;
        }
    }

    @media (max-width: 767.98px) {
        .thank-you-hero {
            padding: 70px 0;
            margin-bottom: 40px;
        }
        
        .thank-you-card {
            padding: 30px;
            border-radius: 15px;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 10px;
        }
        
        .btn-home, .btn-properties {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 575.98px) {
        .thank-you-hero {
            padding: 60px 0;
            margin-bottom: 30px;
        }
        
        .thank-you-title {
            font-size: 1.8rem;
        }
        
        .thank-you-icon {
            width: 80px;
            height: 80px;
            font-size: 2.5rem;
        }
        
        .thank-you-content h2 {
            font-size: 1.5rem;
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



    <div class="container" style="margin-top: 200px; margin-bottom: 70px;">
        <div class="thank-you-card fade-in">
            <div class="thank-you-icon">
                <i class="fas fa-check"></i>
            </div>
            
            <div class="thank-you-content">
                <h2>Message Sent Successfully!</h2>
                <p>
                    Thank you for reaching out to us. We've received your message and will get back to you as soon as possible.
                </p>
                
                <div class="message-details">
                    <p><strong>Our team typically responds within 24 hours during business days.</strong></p>
                    <p>If you have an urgent matter, please feel free to call us directly.</p>
                </div>
                
                <div class="action-buttons">
                    <a href="{{ url('/') }}" class="btn-home">
                        <i class="fas fa-home me-1"></i> Return to Homepage
                    </a>
                    <a href="{{ url('/properties') }}" class="btn-properties">
                        <i class="fas fa-building me-1"></i> Browse Properties
                    </a>
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

    // Icon animation
    const icon = document.querySelector('.thank-you-icon i');
    if (icon) {
        setTimeout(() => {
            icon.style.transform = 'scale(1.2)';
            setTimeout(() => { icon.style.transform = 'scale(1)'; }, 300);
        }, 500);
    }

    // Card hover effect
    const thankYouCard = document.querySelector('.thank-you-card');
    if (thankYouCard) {
        thankYouCard.addEventListener('mouseenter', () => {
            thankYouCard.style.transform = 'translateY(-5px)';
        });
        thankYouCard.addEventListener('mouseleave', () => {
            thankYouCard.style.transform = 'translateY(0)';
        });
    }
});
</script>
@endsection