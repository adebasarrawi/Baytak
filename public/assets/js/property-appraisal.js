// Property Appraisal Booking Script
document.addEventListener('DOMContentLoaded', function() {
    const bookAppointmentBtn = document.getElementById('bookAppointmentBtn');
    const bookingForm = document.getElementById('bookingForm');
    const bookingConfirmation = document.getElementById('bookingConfirmation');
    const confirmedAppraiser = document.getElementById('confirmedAppraiser');
    const confirmedDateTime = document.getElementById('confirmedDateTime');
    const confirmedAddress = document.getElementById('confirmedAddress');
    
    // Format date and time
    function formatDateTime(date, time) {
      const formattedDate = new Date(date);
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      const formattedTime = formatTime(time);
      return `${formattedDate.toLocaleDateString('en-US', options)} at ${formattedTime}`;
    }
    
    // Format time
    function formatTime(timeString) {
      const [hours, minutes] = timeString.split(':');
      const hour = parseInt(hours);
      return hour > 12 ? `${hour - 12}:${minutes} PM` : `${hour}:${minutes} AM`;
    }
    
    // Handle form submission
    if (bookAppointmentBtn) {
      bookAppointmentBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Get form values
        const appraiserRadios = document.querySelectorAll('input[name="appraiser"]');
        let selectedAppraiser = null;
        let appraiserName = '';
        let appraiserId = '';
        
        for (const radio of appraiserRadios) {
          if (radio.checked) {
            selectedAppraiser = radio.value;
            appraiserId = radio.value;
            appraiserName = radio.closest('.appraiser-card').querySelector('.card-title').textContent;
            break;
          }
        }
        
        const appointmentDate = document.getElementById('appointmentDate').value;
        const appointmentTime = document.getElementById('appointmentTime').value;
        const propertyAddress = document.getElementById('propertyAddress').value;
        const contactName = document.getElementById('contactName').value;
        const contactPhone = document.getElementById('contactPhone').value;
        const contactEmail = document.getElementById('contactEmail').value;
        const additionalNotes = document.getElementById('additionalNotes')?.value || '';
        
        // Simple validation
        if (!selectedAppraiser || !appointmentDate || !appointmentTime || !propertyAddress || !contactName || !contactPhone || !contactEmail) {
          alert('Please fill in all required fields.');
          return;
        }
        
        // Prepare data for sending to server
        const formData = {
          appraiser_id: appraiserId,
          client_name: contactName,
          client_email: contactEmail,
          client_phone: contactPhone,
          property_address: propertyAddress,
          appointment_date: appointmentDate,
          appointment_time: appointmentTime,
          additional_notes: additionalNotes,
        };
        
        // Send data to server using fetch API
        fetch('/property-appraisal/book', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Update confirmation details
            confirmedAppraiser.textContent = appraiserName;
            confirmedDateTime.textContent = formatDateTime(appointmentDate, appointmentTime);
            confirmedAddress.textContent = propertyAddress;
            
            // Show confirmation
            bookingForm.style.display = 'none';
            bookingConfirmation.classList.remove('d-none');
            
            // Scroll to confirmation
            bookingConfirmation.scrollIntoView({ behavior: 'smooth' });
          } else {
            alert(data.message || 'Something went wrong. Please try again.');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while submitting your request. Please try again later.');
        });
      });
    }
    
    // Appraiser selection styling
    const appraiserCards = document.querySelectorAll('.appraiser-card');
    appraiserCards.forEach(card => {
      const radio = card.querySelector('.appraiser-radio');
      card.addEventListener('click', function() {
        // Remove active class from all cards
        appraiserCards.forEach(c => c.classList.remove('border-primary'));
        // Add active class to clicked card
        card.classList.add('border-primary');
        // Check the radio
        radio.checked = true;
      });
    });
  });