<?php
ini_set('session.save_path', __DIR__ . '/sessions');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 1440);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // Jika pakai HTTPS, ubah jadi 1
ini_set('session.use_only_cookies', 1);

session_start();
session_regenerate_id(true);

session_start();
header('Content-Type: application/json');

$response = [
    "session_id" => session_id(),
    "session_data" => $_SESSION
];

echo json_encode($response);
?>
