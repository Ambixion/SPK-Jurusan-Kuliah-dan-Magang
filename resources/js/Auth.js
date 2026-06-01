// ════════════════════════════════════════════════════════════════
// Auth Page JavaScript
// ════════════════════════════════════════════════════════════════

/**
 * Toggle password visibility
 */
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // Change icon to eye-off
        eyeIcon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1 4.24 4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
    } else {
        passwordInput.type = 'password';
        // Change icon back to eye
        eyeIcon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
    }
}

/**
 * Form submission handler with loading state
 */
document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');

    if (loginForm && submitBtn) {
        loginForm.addEventListener('submit', function (e) {
            // Add loading state to button
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });
    }

    // Restore button state on page load (in case of form validation errors)
    window.addEventListener('load', function () {
        if (submitBtn) {
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
        }
    });

    // Enable password toggle with Enter key when focused on password field
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        // Already handled by button click, this is just for accessibility
        const toggleBtn = document.querySelector('.toggle-password');
        if (toggleBtn) {
            toggleBtn.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    togglePassword();
                }
            });
        }
    }
});

// ════════════════════════════════════════════════════════════════
// Additional Utilities
// ════════════════════════════════════════════════════════════════

/**
 * Validate email or username format
 */
function validateLogin(login) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    // Username: alphanumeric, underscore, hyphen (3-20 chars)
    const usernameRegex = /^[a-zA-Z0-9_-]{3,20}$/;

    return emailRegex.test(login) || usernameRegex.test(login);
}

/**
 * Validate password minimum length
 */
function validatePassword(password) {
    return password.length >= 8;
}
