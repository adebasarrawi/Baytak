
@component('mail::message')
# Property Status Update

Your property listing **{{ $property->title }}** has been updated to: 

@if($property->status == 'approved')
<span style="color: green; font-weight: bold;">Approved</span>
@elseif($property->status == 'rejected')
<span style="color: red; font-weight: bold;">Rejected</span>
@else
<span style="color: orange; font-weight: bold;">Pending</span>
@endif

@if($property->status == 'rejected' && $property->rejection_reason)
**Reason for rejection:**  
{{ $property->rejection_reason }}
@endif

@component('mail::button', ['url' => route('properties.show', $property->id)])
View Property
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent