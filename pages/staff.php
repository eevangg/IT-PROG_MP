<?php
// Simple shim to send staff logins to the dashboard
session_start();
header("Location: admin-pages/dashboard.php");
exit();
