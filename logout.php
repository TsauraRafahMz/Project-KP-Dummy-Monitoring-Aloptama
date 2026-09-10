<?php
session_start();

// Hapus semua variabel session
//$_SESSION = [];

// Hapus session dari server
session_destroy();

//setcookie(session_name(), '', 0, '/'); // Hapus cookie sesi

//exit();
// Hapus cookie session dari browser
// if (isset($_COOKIE[session_name()])) {
//     setcookie(session_name(), '', time() - 3600, '/');
// }
?>
