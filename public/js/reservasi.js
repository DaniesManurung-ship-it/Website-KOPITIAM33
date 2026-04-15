    // Set minimum date for reservation
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('tanggal');
        if (dateInput) {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const formattedDate = tomorrow.toISOString().split('T')[0];
            dateInput.min = formattedDate;
        }
    });

    // Form validation
    const form = document.getElementById('reservationForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value) {
                    field.classList.add('input-error');
                    isValid = false;
                } else {
                    field.classList.remove('input-error');
                }
            });
            
            const termsCheckbox = document.getElementById('terms');
            if (!termsCheckbox.checked) {
                alert('Anda harus menyetujui syarat dan ketentuan yang berlaku.');
                isValid = false;
            }
            
            if (isValid) {
                alert('Reservasi Anda telah dikirim! Kami akan mengkonfirmasi melalui WhatsApp dalam 1x24 jam.');
                form.reset();
                
                // Reset min date after reset
                const dateInput = document.getElementById('tanggal');
                if (dateInput) {
                    const tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    const formattedDate = tomorrow.toISOString().split('T')[0];
                    dateInput.min = formattedDate;
                }
                
                // Remove error classes
                requiredFields.forEach(field => {
                    field.classList.remove('input-error');
                });
            } else {
                alert('Mohon lengkapi semua field yang wajib diisi.');
            }
        });
        
        // Remove error class on input
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('input-error');
            });
        });
    }
