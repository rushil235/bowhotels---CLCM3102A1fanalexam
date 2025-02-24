document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactForm');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const messageInput = document.getElementById('message');

    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const messageError = document.getElementById('messageError');
    
    const modal = document.getElementById('confirmationModal');
    const modalMessage = document.getElementById('modalMessage');
    const confirmBtn = document.getElementById('confirmSubmit');
    const cancelBtn = document.getElementById('cancelSubmit');
    
    const notification = document.getElementById('notification'); // New notification element
    let formData = null; // To store form data before submission

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission
        let isValid = true;

        // Name validation
        if (nameInput.value.trim() === '') {
            nameError.textContent = 'Name is required';
            isValid = false;
        } else if (nameInput.value.trim().length < 3) {
            nameError.textContent = 'Name must be at least 3 characters long';
            isValid = false;
        } else {
            nameError.textContent = '';
        }

        // Email validation
        if (emailInput.value.trim() === '') {
            emailError.textContent = 'Email is required';
            isValid = false;
        } else if (!validateEmail(emailInput.value)) {
            emailError.textContent = 'Invalid email format';
            isValid = false;
        } else {
            emailError.textContent = '';
        }

        // Message validation
        if (messageInput.value.trim() === '') {
            messageError.textContent = 'Message is required';
            isValid = false;
        } else if (messageInput.value.trim().length < 10) {
            messageError.textContent = 'Message must be at least 10 characters long';
            isValid = false;
        } else {
            messageError.textContent = '';
        }

        // If validation fails, stop submission
        if (!isValid) {
            return;
        }

        // Store form data and show the modal for confirmation
        formData = new FormData(form);
        modalMessage.textContent = "Are you sure you want to submit the form?";
        modal.style.display = "block";
    });

    // Confirm form submission
    confirmBtn.addEventListener('click', function () {
        modal.style.display = "none";
        if (formData) {
            fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'Content-Security-Policy': "upgrade-insecure-requests" // Ensuring secure requests
                }
            }).then(response => {
                if (response.ok) {
                    showNotification("Form submitted successfully!", "success");
                    form.reset();
                } else {
                    showNotification("Error submitting form. Please try again.", "error");
                }
            }).catch(error => {
                console.error("Submission error:", error);
                showNotification("Network error. Please check your connection.", "error");
            });
        }
    });

    // Cancel submission
    cancelBtn.addEventListener('click', function () {
        modal.style.display = "none";
    });

    // Email validation function
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    // Function to show notifications
    function showNotification(message, type) {
        notification.textContent = message;
        notification.className = type === "success" ? "notification success" : "notification error";
        notification.style.display = "block";
        setTimeout(() => {
            notification.style.display = "none";
        }, 5000);
    }
});
