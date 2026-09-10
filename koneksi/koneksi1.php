<?php
$koneksi1 = mysqli_connect("localhost","root","","arg_demo");
if (mysqli_connect_errno()) {
    echo "Koneksi Database Gagal". mysqli_connect_errno();
    // code...
}
?>