<?php
include 'koneksi/Koneksi.php'; // include koneksi database
include 'koneksi/koneksi1.php'; // include koneksi database

// Query untuk mengambil data curah hujan dan tanggal
$sql = "SELECT waktu, log_temp FROM tabel_argnguter ORDER BY log_temp ASC";
$result = $koneksi->query($sql);

$data = [];
$labels = [];

// Masukkan hasil query ke dalam array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['waktu']; // tanggal
        $data[] = $row['log_temp']; // curah hujan
    }
}

$koneksi->close(); // Tutup koneksi

// Konversi array ke format JSON
header('Content-Type: application/json'); // Set header JSON
echo json_encode(['labels' => $labels, 'data' => $data]);
?>
