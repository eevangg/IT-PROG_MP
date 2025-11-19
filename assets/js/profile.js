document.addEventListener('DOMContentLoaded', function () {
    // Handle profile edit form submission
    const editForm = document.getElementById('editProfileForm');
    if (editForm) {
        editForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            const feedback = document.getElementById('editMessage');
            feedback.innerHTML = '';

            const formData = new FormData(this);
            await fetch('../processes/update_profile.php', {
                method: 'POST',
                body: formData,
            })
            .then (response => response.json())
            .then (data => {
                if (data.status === 'success') {
                    feedback.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    setTimeout(() => {
                        feedback.innerHTML = '';
                        window.location.href = 'profile.php';
                    }, 2000);
                } else {
                    feedback.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch (error => {
                feedback.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again later.</div>`;
                console.error('Error:', error.message);
            });
            
        });
    }


    // Ensure passwords are identical
    const confirmField = document.getElementById("confirm_password");
    const passwordField = document.getElementById("new_password");

    if (confirmField && passwordField) {
        confirmField.addEventListener("input", function () {
            const password = passwordField.value;
            const confirmPassword = this.value;

            const feedback = document.querySelector(".confirm_password .invalid-feedback");

            if (feedback) {
                if (confirmPassword === "") {
                    feedback.textContent = "Please confirm your password";
                } else if (password !== confirmPassword) {
                    feedback.textContent = "Passwords do not match";
                } else {
                    feedback.textContent = ""; // Clear feedback if passwords match
                }
            }
        });
    }

    // Handle password change form submission
    const passwordForm = document.getElementById('changePasswordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            const feedback = document.getElementById('password_message');
            const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
            feedback.innerHTML = '';

            const formData = new FormData(this);
            await fetch('../processes/change_password.php', {
                method: 'POST',
                body: formData,
            })
            .then (response => response.json())
            .then (data => {
                if (data.status === 'success') {
                    feedback.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    setTimeout(() => {
                        feedback.innerHTML = '';
                        modal.hide();
                    }, 2000);
                } else {
                    feedback.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch (error => {
                feedback.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again later.</div>`;
                console.error('Error:', error.message);
            });
            
        });
    }

    // ==== Handle account deletion ====

    // Show toast on delete button click
    const deleteBtn = document.getElementById('deleteAccountBtn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function () {
            const toast = new bootstrap.Toast(document.getElementById('deleteToast'));
            toast.show();
        });
    }

    // Handle account deletion form submission
    const deleteForm = document.getElementById('deleteToastForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            const feedback = document.getElementsByClassName('toast-body');
            feedback.innerHTML = '';

            await fetch('../processes/delete_account.php', {
                method: 'POST',
                body: formData,
            })
            .then (response => response.json())
            .then (data => {
                if (data.status === 'success') {
                    feedback.innerHTML = `<p>${data.message}</p>`;
                    setTimeout(() => {
                        window.location.href = 'login.php';
                    }, 2000);
                } else {
                    feedback.innerHTML = `<p>${data.message}</p>`;
                }
            })
            .catch (error => {
                feedback.innerHTML = `<p>An error occurred. Please try again later.<p>`;
                console.error('Error:', error.message);
            });
            
        });
    }

});