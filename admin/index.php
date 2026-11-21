<?php
require_once __DIR__ . '/includes/bootstrap.php';

admin_redirect(admin_user() === null ? 'login.php' : 'dashboard.php');
