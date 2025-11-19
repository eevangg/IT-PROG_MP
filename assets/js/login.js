(document.addEventListener('DOMContentLoaded', function() {
    // Handle login form submission via AJAX

    loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
    
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }
    
            const formData = new FormData(this);
            const response = await fetch('../processes/process_login.php', {
                method: 'POST',
                body: formData
            });
    
            const result = await response.json();
            const feedback = document.getElementById('loginFeedback');
            feedback.textContent = ''; // Clear previous text
    
            if (result.success) {
                feedback.classList.remove('text-danger');
                feedback.classList.add('text-success');
                feedback.textContent = `${result.success}`;
    
                // Additional logic based on user role
                if(result.role === 'admin'){
                    feedback.textContent += ' Redirecting to admin dashboard...';
                    window.setTimeout(() => {
                        feedback.textContent  = '';
                        window.location.href = '../pages/admin_dashboad.php';
                    }, 2000);
                }else if(result.role === 'student'){
                    window.setTimeout(() => {
                        feedback.textContent  = '';
                        window.location.href = 'menu.php';
                    }, 2000);
                }else if (result.role === 'staff'){
                    feedback.textContent += ' Redirecting to staff dashboard...';
                    window.setTimeout(() => {
                        feedback.textContent  = '';
                        window.location.href = 'staff.php';
                    }, 2000);
                }
            } else if (result.error) {
                feedback.textContent = `${result.error}`;
            }
        });
    }
    
    
}));