<?php
session_start();

// Debug: Simpan data POST yang diterima
file_put_contents("debug.txt", json_encode($_POST) . PHP_EOL, FILE_APPEND);

// Demo credentials for repository example
$valid_username = "admin";
$valid_password = "demo_password";

// Ambil data dari request dan hilangkan spasi ekstra
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$user_captcha = trim($_POST['captcha']);

// Cek Captcha
if (!isset($_SESSION['captcha']) || $_SESSION['captcha'] != $user_captcha) {
    echo "captcha_failed";
    exit; // Tambahkan ini biar berhenti di sini kalau captcha salah
}

// Cek username dan password
if ($username === $valid_username && $password === $valid_password) {
    $_SESSION['logged_in'] = true;

    // Debug: Simpan session yang dibuat
    file_put_contents("session_debug.txt", json_encode($_SESSION) . PHP_EOL, FILE_APPEND);

    echo "success";
} else {
    // Debug: Simpan pesan jika login gagal
    file_put_contents("session_debug.txt", "Login gagal: " . json_encode($_SESSION) . PHP_EOL, FILE_APPEND);
    echo "failed";
}
?>
