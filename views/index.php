<?php include('header.php'); ?>

<section class="container auth-section">
  <h2>Welcome to the School Canteen Pre-order System</h2>

  <div class="auth-tabs">
    <button class="tab-btn active" onclick="showTab('login')">Login</button>
    <button class="tab-btn" onclick="showTab('register')">Register</button>
  </div>

  <!-- Login Form -->
  <form id="loginForm" class="card tab-content" data-tab="login">
    <input type="text" placeholder="Student/Staff ID" required>
    <input type="password" placeholder="Password" required>
    <button type="submit" class="btn primary">Login</button>
  </form>

  <!-- Registration Form -->
  <form id="registerForm" class="card tab-content hidden" data-tab="register">
    <input type="text" placeholder="Student/Staff ID" required>
    <input type="text" placeholder="Full Name" required>
    <input type="email" placeholder="Email" required>
    <input type="password" placeholder="Create Password" required>
    <button type="submit" class="btn">Register</button>
  </form>
</section>

<script>
function showTab(tab) {
  document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
  document.querySelectorAll('.tab-content').forEach(form => form.classList.add('hidden'));
  document.querySelector(`[data-tab="${tab}"]`).classList.remove('hidden');
  event.target.classList.add('active');
}
</script>

<?php include('footer.php'); ?>
