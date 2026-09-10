<?php
// Menyertakan file koneksi database
include "koneksi/Koneksi.php";
include "koneksi/koneksi1.php";

//include "session.php";
include "logout.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informasi Staklim Jateng</title>
        <!-- Link CSS Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Link Font Google -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <!-- Link Font Awesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <style>
            body {
                background-color: #f4f4f9;
                font-family:  'Arial', sans-serif;
                margin: 0;
                color: #000;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            .contact-card {
                margin: 30px auto;
                max-width: 1000px;
                border: none;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .card-header {
                background-color: #000080;
                color: white;
                text-align: center;
                font-size: 1.4rem;
                font-weight: 600;
                font-weight: bold;
                padding: 15px;
                border-radius: 10px 10px 0 0;
            }
            .card-body {
                padding: 20px;
                border-radius: 0 0 10px 10px;
            }

            .info-section {
                display: flex;
                gap: 20px;
                margin-bottom: 30px;
            }

            .info-card {
                flex: 1;
                background: #ffffff;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                height: 200px; /* Sesuaikan tinggi card kecil */
            }

            .info-card-header{
                background-color: #000080; /* Warna biru pastel */
                padding: 15px;
                text-align: center;
                font-weight: 600;
            }

            .info-card-header h5 {
                color: white;
                font-weight: bold; /* Tambahkan gaya tebal */
            }

            .info-card-content {
                padding: 15px;
                margin-bottom: 8px;
                /* border-top: 1px solid #ddd; */
            }

            .info-card-content p {
                margin: 5px 0;
                font-size: 1rem;
                line-height: 1.5;
                text-align: center;
            }

            .description-text {
                text-align: center;
                margin-bottom: 8px;
                color: #555;
            }

            .full-width {
                width: 100%; /* Pastikan card memenuhi lebar container */
            }
        </style>
</head>

<body>
        <div class="container">
            <!-- Bagian Informasi Jam Operasional dan Alamat -->
            <div class="info-section">
                <!-- Bagian Jam Operasional -->
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-clock text-primary" style="font-size: 2.5rem;"></i>
                        <h5>Jam Operasional</h5>
                    </div>
                    <div class="info-card-content">
                        <p>Senin - Jum'at</p>
                        <p>08.00 - 15.30</p>
                    </div>
                </div>
                <!-- Bagian Alamat -->
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-map-marker-alt text-danger" style="font-size: 2.5rem;"></i>
                        <h5>Alamat</h5>
                    </div>
                    <div class="info-card-content">
                        <p>Jl. Siliwangi No.291, Kalibanteng Kulon</p>
                        <p>Kec. Semarang Barat, Kota Semarang</p>
                        <p>Jawa Tengah 50145</p>
                    </div>
                </div>
            </div>

            <!-- Bagian Tentang Kami -->
            <div class="card contact-card full-width">
                <div class="card-header">
                    Tentang Kami
                </div>
                <div class="card-body">
                    <p class="description-text">Website ini dikembangkan oleh Mahasiswa Kerja Praktik UIN Walisongo Semarang sebagai bagian dari proyek monitoring ALOPTAMA AWS & ARG BMKG Staklim Jawa Tengah. Proyek ini bertujuan untuk mendukung pemantauan data meteorologi secara real-time dan memberikan kontribusi terhadap layanan informasi cuaca yang lebih baik.</p>
                    
                    <div class="info-card-content">
                        <p>M. Dain Jaddun Uzzais (2208096052)</p>
                        <p>Aulia Sekar Johar (2208096056)</p>
                        <p>Achrijal Shohib Arya Syifa (2208096061)</p>
                        <p>Tsaura Rafah Masuzzahra (2208096080)</p>
                    </div>

                    <p class="description-text">Periode 16 Desember 2024 - 7 Februari 2025</p>
                </div>
            </div>
        </div>
</body>
</html>