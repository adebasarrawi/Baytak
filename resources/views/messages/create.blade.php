@extends('layouts.public.app')

@section('title', 'Send Message')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12">
            <h1>Send Message</h1>
            
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    Contact {{ $receiver->name }} about: {{ $property->title }}
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            @if($property->primaryImage)
                                <img src="{{ asset('storage/' . $property->primaryImage->image_path) }}" alt="{{ $property->title }}" class="img-fluid rounded">
                            @else
                                <img src="{{ asset('images/default-property.jpg') }}" alt="{{ $property->title }}" class="img-fluid rounded">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5>{{ $property->title }}</h5>
                            <p class="text-muted mb-1">{{ $property->area->governorate->name ?? '' }}, {{ $property->area->name ?? '' }}</p>
                            <p class="text-primary fw-bold">{{ number_format($property->price) }} {{ $property->purpose == 'rent' ? 'JOD/month' : 'JOD' }}</p>
                        </div>
                    </div>
                
                    <form id="new-message-form" action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
                            <div class="form-text">Feel free to ask any questions about this property.</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Send Message</button>
                        <a href="{{ route('properties.show', $property->id) }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Optional: Submit the form with AJAX instead of standard form submission
    /*
    $('#new-message-form').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    // Show success message
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Message sent successfully!');
                    } else {
                        alert('Message sent successfully!');
                    }
                    
                    // Redirect to inbox or property page
                    setTimeout(function() {
                        window.location.href = "{{ route('messages.index') }}";
                    }, 1500);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error sending message:', error);
                
                if (typeof toastr !== 'undefined') {
                    toastr.error('Failed to send message. Please try again.');
                } else {
                    alert('Failed to send message. Please try again.');
                }
            }
        });
    });
    */
});
</script>
@endpush
@endsection