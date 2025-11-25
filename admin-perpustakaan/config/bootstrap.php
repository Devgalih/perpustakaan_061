<?php
/**
 * Bootstrap file - loads session, database connection, and helpers.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/helpers.php';

// Seed default admin if table still empty
$adminCheck = db()->query("SELECT id_admin FROM admin LIMIT 1");
if ($adminCheck && $adminCheck->num_rows === 0) {
    $defaultPass = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = db()->prepare("INSERT INTO admin (email, username, password, nama_lengkap) VALUES ('admin@perpus.local', 'admin', ?, 'Administrator')");
    $stmt->bind_param('s', $defaultPass);
    $stmt->execute();
    $stmt->close();
}



