<?php
// Menyertakan file koneksi database
include "koneksi.php";

// Mengecek apakah form sudah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $name = $koneksi->real_escape_string($_POST['name']);
    $email = $koneksi->real_escape_string($_POST['email']);
    $message = $koneksi->real_escape_string($_POST['message']);

    // Query untuk menyimpan data ke tabel contacts
    $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($koneksi->query($sql) === TRUE) {
        // Redirect kembali ke halaman contact.php dengan pesan sukses
        echo "<script>
                alert('Pesan berhasil dikirim!');
                window.location.href = 'index.php?page=contact';
              </script>";
    } else {
        // Menampilkan error jika query gagal
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

// Menutup koneksi database
$koneksi->close();
?>
