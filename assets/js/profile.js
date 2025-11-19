document.addEventListener('DOMContentLoaded', function () {
    // Handle profile edit form submission
    document.getElementById('editProfileForm').addEventListener('submit', async function (e) {
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
            body: formData
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
});