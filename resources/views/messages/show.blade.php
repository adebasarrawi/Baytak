@extends('layouts.public.app')

@section('title', 'Conversation with ' . $otherUser->name)

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

/* Hero Section Styles */
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

.custom-breadcrumb {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    padding: 12px 30px;
    display: inline-flex;
    align-items: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.custom-breadcrumb .breadcrumb {
    margin: 0;
    padding: 0;
    background: none;
}

.custom-breadcrumb .breadcrumb-item {
    font-size: 0.9rem;
    font-weight: 500;
}

.custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255, 255, 255, 0.6);
    font-weight: 600;
}

.custom-breadcrumb .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.2s ease;
}

.custom-breadcrumb .breadcrumb-item a:hover {
    color: white;
    text-decoration: underline;
}

.custom-breadcrumb .breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.7);
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

/* Conversation Section Styles */
.conversation-section {
    padding: 50px 0;
    background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
}

.back-btn {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 30px;
}

.back-btn:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

.conversation-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    max-width: 900px;
    margin: 0 auto;
    transition: all 0.3s ease;
}

.conversation-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.chat-header {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 25px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-avatar img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 3px solid rgba(255, 255, 255, 0.3);
    object-fit: cover;
    transition: all 0.3s ease;
}

.user-avatar img:hover {
    transform: scale(1.05);
    border-color: rgba(255, 255, 255, 0.5);
}

.user-initial {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.3rem;
    transition: all 0.3s ease;
}

.user-initial:hover {
    transform: scale(1.05);
    border-color: rgba(255, 255, 255, 0.5);
}

.user-name {
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0;
}

.property-btn {
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 8px 16px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.property-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.messages-area {
    height: 500px;
    overflow-y: auto;
    padding: 25px 30px;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
}

.messages-area::-webkit-scrollbar {
    width: 6px;
}

.messages-area::-webkit-scrollbar-track {
    background: transparent;
}

.messages-area::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #d1d5db, #9ca3af);
    border-radius: 3px;
}

.messages-area::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #9ca3af, #6b7280);
}

.message {
    margin-bottom: 20px;
    display: flex;
    animation: fadeIn 0.4s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

.message.sent {
    justify-content: flex-end;
}

.message.received {
    justify-content: flex-start;
    gap: 12px;
}

.message-avatar {
    flex-shrink: 0;
    align-self: flex-end;
}

.message-avatar img {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e5e7eb;
}

.message-avatar .avatar-circle {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 600;
    border: 2px solid #e5e7eb;
}

.message-bubble {
    max-width: 70%;
    padding: 15px 20px;
    border-radius: 20px;
    font-size: 0.95rem;
    line-height: 1.5;
    position: relative;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.message.sent .message-bubble {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-bottom-right-radius: 6px;
}

.message.received .message-bubble {
    background: white;
    color: #1f2937;
    border: 1px solid #e5e7eb;
    border-bottom-left-radius: 6px;
}

.property-context {
    font-size: 0.85rem;
    opacity: 0.8;
    margin-bottom: 8px;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.message.received .property-context {
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    color: #6b7280;
    border-color: #d1d5db;
}

.message-time {
    font-size: 0.8rem;
    opacity: 0.7;
    margin-top: 6px;
    text-align: right;
}

.message.sent .message-time {
    color: rgba(255, 255, 255, 0.8);
}

.message.received .message-time {
    color: #9ca3af;
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    text-align: center;
    color: #9ca3af;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    color: #d1d5db;
    animation: float 3s ease-in-out infinite;
}

.empty-state h5 {
    color: #6b7280;
    margin-bottom: 10px;
    font-size: 1.2rem;
    font-weight: 600;
}

.empty-state p {
    color: #9ca3af;
    font-size: 1rem;
}

.message-form {
    background: white;
    padding: 25px 30px;
    border-top: 1px solid #e5e7eb;
}

.message-input-group {
    display: flex;
    gap: 15px;
    align-items: center;
}

.message-input {
    flex: 1;
    padding: 15px 20px;
    border: 2px solid #e5e7eb;
    border-radius: 15px;
    font-size: 0.95rem;
    background: #f9fafb;
    transition: all 0.3s ease;
}

.message-input:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.send-button {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    border-radius: 15px;
    color: white;
    padding: 15px 25px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.send-button:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

.send-button:active {
    transform: translateY(0);
}

.success-alert {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 15px;
    padding: 15px 20px;
    margin-bottom: 25px;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    animation: slideDown 0.4s ease;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-15px); }
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
    
    .custom-breadcrumb {
        padding: 10px 20px;
        font-size: 0.85rem;
    }
    
    .conversation-section {
        padding: 30px 0;
    }
    
    .conversation-card {
        margin: 0 15px;
        border-radius: 15px;
    }
    
    .chat-header {
        padding: 20px 25px;
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .user-avatar img,
    .user-initial {
        width: 45px;
        height: 45px;
    }
    
    .user-name {
        font-size: 1.2rem;
    }
    
    .messages-area {
        height: 400px;
        padding: 20px 25px;
    }
    
    .message-bubble {
        max-width: 80%;
        padding: 12px 16px;
        font-size: 0.9rem;
    }
    
    .message-form {
        padding: 20px 25px;
    }
    
    .message-input {
        padding: 12px 16px;
        font-size: 0.9rem;
    }
    
    .send-button {
        padding: 12px 20px;
        font-size: 0.9rem;
    }
    
    .property-btn {
        font-size: 0.85rem;
        padding: 6px 12px;
    }
}

@media (max-width: 575.98px) {
    .custom-hero {
        padding: 60px 0 40px;
    }
    
    .hero-title {
        font-size: 1.8rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .custom-breadcrumb {
        padding: 8px 16px;
        font-size: 0.8rem;
    }
    
    .conversation-card {
        margin: 0 10px;
    }
    
    .messages-area {
        height: 350px;
        padding: 15px 20px;
    }
    
    .chat-header {
        padding: 15px 20px;
    }
    
    .message-form {
        padding: 15px 20px;
    }
    
    .message-bubble {
        max-width: 85%;
        padding: 10px 14px;
    }
    
    .message-input-group {
        gap: 10px;
    }
    
    .user-avatar img,
    .user-initial {
        width: 40px;
        height: 40px;
    }
    
    .message-avatar img,
    .message-avatar .avatar-circle {
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }
}
</style>

<!-- Hero Section -->
<div class="custom-hero">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <div class="hero-content">
                   
                    <h1 class="hero-title fade-up delay-1" style="margin-top: 50px;">Conversation</h1>
                    <p class="hero-subtitle fade-up delay-2">Stay connected and reply instantly to your conversations</p>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Conversation Section -->
<div class="conversation-section">
    <div class="container">
        <!-- Back Button -->
        <a href="{{ route('messages.index') }}" class="back-btn fade-in">
            <i class="fas fa-arrow-left"></i>
            Back to Inbox
        </a>
    
        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert success-alert alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Conversation Card -->
        <div class="conversation-card fade-in">
            <!-- Header -->
            <div class="chat-header">
                <div class="user-info">
                    <div class="user-avatar">
                        @if($otherUser->profile_image)
                            <img src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="{{ $otherUser->name }}">
                        @else
                            <div class="user-initial">
                                {{ substr($otherUser->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h5 class="user-name">{{ $otherUser->name }}</h5>
                </div>
                
                @if(isset($property))
                    <a href="{{ route('properties.show', $property->id) }}" class="property-btn">
                        <i class="fas fa-home me-1"></i>
                        View Property
                    </a>
                @endif
            </div>
            
            <!-- Messages Area -->
            <div class="messages-area" id="message-container">
                @if(count($messages) > 0)
                    @foreach($messages as $message)
                        <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                            @if($message->sender_id != Auth::id())
                                <div class="message-avatar">
                                    @if($otherUser->profile_image)
                                        <img src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="{{ $otherUser->name }}">
                                    @else
                                        <div class="avatar-circle">
                                            {{ substr($otherUser->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="message-bubble">
                                @if($message->property_id && $message === $messages->first() && $message->sender_id != Auth::id())
                                    <div class="property-context">
                                        <i class="fas fa-home me-1"></i>
                                        Regarding: {{ $message->property->title ?? 'Property' }}
                                    </div>
                                @endif
                                
                                <div class="message-content">{{ $message->message }}</div>
                                <div class="message-time">
                                    {{ $message->created_at->format('M d, g:i A') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-comments"></i>
                        <h5>No messages yet</h5>
                        <p>Start the conversation!</p>
                    </div>
                @endif
            </div>
            
            <!-- Message Form -->
            <div class="message-form">
                <form action="{{ route('messages.store') }}" method="POST" id="messageForm">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                    @if(isset($property))
                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                    @endif
                    
                    <div class="message-input-group">
                        <input type="text" name="message" class="message-input" placeholder="Type your message..." required>
                        <button type="submit" class="send-button">
                            <i class="fas fa-paper-plane"></i>
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll to bottom of messages
    const messageContainer = document.getElementById('message-container');
    if (messageContainer) {
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }
    
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
    
    // Form submission
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.querySelector('.message-input');
    const sendButton = document.querySelector('.send-button');
    
    if (messageInput) {
        messageInput.focus();
        
        // Send on Enter
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                messageForm.submit();
            }
        });
    }
    
    if (messageForm && sendButton) {
        messageForm.addEventListener('submit', function() {
            sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            sendButton.disabled = true;
        });
    }
    
    // Auto-hide alerts
    document.querySelectorAll('.success-alert').forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 4000);
    });
});
</script>
@endpush

@endsection