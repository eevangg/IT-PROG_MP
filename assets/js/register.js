(document.addEventListener('DOMContentLoaded', function() {

    // Ensure passwords are identical
    document.getElementById("confirm_password").addEventListener("input", function () {
        const password = document.getElementById("password").value;
        const confirmPassword = this.value;
        const feedback = document.querySelector(".confirm_password .invalid-feedback");

        if (confirmPassword === "") {
            feedback.textContent = "Please confirm your password";
        } else if (password !== confirmPassword) {
            feedback.textContent = "Passwords do not match";
        } else {
            feedback.textContent = ""; // Clear feedback if passwords match
        }
    });


    // Handle registration form submission via AJAX
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            e.stopPropagation();
            this.classList.add('was-validated');
            return;
        }

        const formData = new FormData(this);
        const response = await fetch('../processes/process_register.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        const msgDiv = document.getElementById('message');
        const errorDiv = document.getElementById('registerError');
        errorDiv.textContent = ''; // Clear previous error

        if (result.success) {
            msgDiv.innerHTML = `<div class="alert alert-success">${result.success}</div>`;
            window.setTimeout(() => {
                msgDiv.innerHTML = '';
                window.location.href = 'login.php';
            }, 2000);
        } else if (result.error) {
            errorDiv.textContent = `${result.error}`;
        }
    });

}));