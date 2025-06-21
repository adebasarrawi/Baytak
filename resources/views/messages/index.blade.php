@extends('layouts.public.app')

@section('title', 'My Messages')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
    line-height: 1.6;
    color: #2c3e50;
    background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
}

.custom-hero {
    background: linear-gradient(to right, #1a1c20, #2c3e50);
    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
}

.custom-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    z-index: 1;
}

.custom-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    color: white;
}

.hero-title {
    font-size: 40px;
    font-weight: 700;
    margin-bottom: 20px;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    letter-spacing: -0.02em;
}

.hero-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 30px;
    font-weight: 300;
}

.hero-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    animation: float 3s ease-in-out infinite;
}

.hero-icon i {
    font-size: 2rem;
    color: white;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-up {
    animation: fadeInUp 0.8s ease-out;
}

.fade-up.delay-1 {
    animation-delay: 0.2s;
    animation-fill-mode: both;
}

.fade-up.delay-2 {
    animation-delay: 0.4s;
    animation-fill-mode: both;
}

.messages-section {
    padding: 50px 0;
    background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
}

.messages-container {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
}

.messages-container:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.messages-header {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 20px 30px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.messages-title {
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.conversation-item {
    display: flex;
    align-items: center;
    padding: 20px 30px;
    border-bottom: 1px solid #f3f4f6;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    position: relative;
}

.conversation-item:hover {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    color: inherit;
    text-decoration: none;
    transform: translateX(5px);
}

.conversation-item.unread {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border-left: 4px solid #3b82f6;
}

.conversation-item.unread:hover {
    background: linear-gradient(135deg, #bfdbfe, #93c5fd);
}

.conversation-item:last-child {
    border-bottom: none;
}

.avatar-container {
    flex-shrink: 0;
    margin-right: 20px;
    position: relative;
}

.user-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e5e7eb;
    transition: all 0.3s ease;
}

.conversation-item:hover .user-avatar {
    border-color: #3b82f6;
    transform: scale(1.05);
}

.avatar-placeholder {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.2rem;
    border: 3px solid #e5e7eb;
    transition: all 0.3s ease;
}

.conversation-item:hover .avatar-placeholder {
    border-color: #3b82f6;
    transform: scale(1.05);
}

.conversation-content {
    flex: 1;
    min-width: 0;
}

.conversation-header {
    display: flex;
    justify-content: between;
    align-items: flex-start;
    margin-bottom: 8px;
    gap: 15px;
}

.user-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    flex: 1;
}

.conversation-item.unread .user-name {
    color: #1e40af;
}

.message-time {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 500;
    white-space: nowrap;
}

.conversation-item.unread .message-time {
    color: #1e40af;
    font-weight: 600;
}

.last-message {
    font-size: 0.95rem;
    color: #4b5563;
    margin-bottom: 5px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}

.conversation-item.unread .last-message {
    color: #1e40af;
    font-weight: 500;
}

.property-reference {
    font-size: 0.8rem;
    color: #6b7280;
    font-style: italic;
}

.conversation-item.unread .property-reference {
    color: #1e40af;
}

.unread-badge {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border-radius: 20px;
    padding: 4px 10px;
    font-size: 0.75rem;
    font-weight: 700;
    margin-left: 15px;
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.empty-state {
    text-align: center;
    padding: 80px 40px;
    background: white;
}

.empty-icon {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 25px;
    animation: float 3s ease-in-out infinite;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 12px;
}

.empty-description {
    color: #6b7280;
    margin-bottom: 30px;
    font-size: 1rem;
}

.btn-browse {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    padding: 12px 30px;
    border-radius: 12px;
    color: white;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}

.btn-browse:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(59, 130, 246, 0.4);
    color: white;
    text-decoration: none;
}

.success-alert {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 15px;
    padding: 15px 20px;
    margin-bottom: 25px;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    animation: slideInDown 0.5s ease-out;
}

@keyframes slideInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.success-alert .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.fade-in {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease;
}

.fade-in.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Responsive Design */
@media (max-width: 767.98px) {
    .custom-hero {
        padding: 80px 0 50px;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-icon {
        width: 60px;
        height: 60px;
        margin-bottom: 15px;
    }
    
    .hero-icon i {
        font-size: 1.5rem;
    }
    
    .messages-header {
        padding: 15px 20px;
    }
    
    .conversation-item {
        padding: 15px 20px;
    }
    
    .avatar-container {
        margin-right: 15px;
    }
    
    .user-avatar,
    .avatar-placeholder {
        width: 50px;
        height: 50px;
    }
    
    .avatar-placeholder {
        font-size: 1rem;
    }
    
    .conversation-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .message-time {
        align-self: flex-start;
    }
    
    .empty-state {
        padding: 60px 20px;
    }
}

@media (max-width: 575.98px) {
    .custom-hero {
        padding: 60px 0 40px;
    }
    
    .hero-title {
        font-size: 1.8rem;
    }
    
    .conversation-item {
        padding: 12px 15px;
    }
    
    .messages-header {
        padding: 12px 15px;
    }
    
    .user-name {
        font-size: 1rem;
    }
    
    .last-message {
        font-size: 0.9rem;
    }
    
    .empty-state {
        padding: 40px 15px;
    }
    
    .empty-icon {
        font-size: 3rem;
    }
    
    .empty-title {
        font-size: 1.3rem;
    }
}
</style>

<!-- Hero Section -->
<div class="custom-hero">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <div class="hero-content">
                 
                    <h1 class="hero-title fade-up delay-1" style="margin-top: 50px;">My Messages</h1>
                    <p class="hero-subtitle fade-up delay-2">Stay connected with property inquiries and conversations</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Messages Section -->
<div class="messages-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if(session('success'))
                    <div class="alert success-alert alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="messages-container fade-in">
                    <div class="messages-header">
                        <h5 class="messages-title">
                            <i class="fas fa-comments"></i>
                            My Messages
                        </h5>
                    </div>
                    
                    <div class="messages-body">
                        @if(count($inbox) > 0)
                            @foreach($inbox as $conversation)
                                <a href="{{ route('messages.show', $conversation['user']->id) }}" 
                                   class="conversation-item {{ $conversation['unread_count'] > 0 ? 'unread' : '' }}">
                                   
                                    <div class="avatar-container">
                                        @if($conversation['user']->profile_image)
                                            <img src="{{ asset('storage/' . $conversation['user']->profile_image) }}" 
                                                 alt="{{ $conversation['user']->name }}" 
                                                 class="user-avatar">
                                        @else
                                            <div class="avatar-placeholder">
                                                {{ substr($conversation['user']->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="conversation-content">
                                        <div class="conversation-header">
                                            <h6 class="user-name">{{ $conversation['user']->name }}</h6>
                                            <small class="message-time">{{ $conversation['last_message']->created_at->diffForHumans() }}</small>
                                        </div>
                                        
                                        <p class="last-message">{{ $conversation['last_message']->message }}</p>
                                        
                                        @if($conversation['last_message']->property)
                                            <div class="property-reference">
                                                <i class="fas fa-home me-1"></i>
                                                Re: {{ $conversation['last_message']->property->title }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @if($conversation['unread_count'] > 0)
                                        <span class="unread-badge">{{ $conversation['unread_count'] }}</span>
                                    @endif
                                </a>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h4 class="empty-title">No messages yet</h4>
                                <p class="empty-description">Your message inbox is empty. Start exploring properties to connect with owners and agents.</p>
                                <a href="{{ route('properties.index') }}" class="btn-browse">
                                    <i class="fas fa-search me-2"></i>Browse Properties
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fade in animations
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('.fade-in').forEach(function(el) {
        observer.observe(el);
    });
    
    // Auto-hide alerts
    document.querySelectorAll('.success-alert').forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Add hover effects to conversation items
    const conversationItems = document.querySelectorAll('.conversation-item');
    conversationItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            const avatar = item.querySelector('.user-avatar, .avatar-placeholder');
            if (avatar) {
                avatar.style.transform = 'scale(1.05)';
                avatar.style.borderColor = '#3b82f6';
            }
        });
        
        item.addEventListener('mouseleave', () => {
            const avatar = item.querySelector('.user-avatar, .avatar-placeholder');
            if (avatar) {
                avatar.style.transform = 'scale(1)';
                avatar.style.borderColor = '#e5e7eb';
            }
        });
    });
});
</script>

@endsection