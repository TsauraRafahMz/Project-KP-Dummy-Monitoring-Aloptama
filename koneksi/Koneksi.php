<?php
$koneksi = mysqli_connect("localhost","root","","aws_demo");
if (mysqli_connect_errno()) {
    echo "Koneksi Database Gagal". mysqli_connect_errno();
    // code...
}
?>