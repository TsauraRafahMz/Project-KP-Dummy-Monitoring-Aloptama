<?php
ob_start(); // Memulai buffer output
//session_start(); // Mulai sesi

// Konfigurasi koneksi database
include "koneksi/Koneksi.php";
include "koneksi/koneksi1.php";

// Periksa jika halaman adalah "map"
if (isset($_GET['page']) && $_GET['page'] === 'map') {
    include "map.php"; // Tampilkan halaman map secara penuh
    exit; // Hentikan eksekusi script agar elemen lain tidak dimuat
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring ALOPTAMA</title>
    <link rel="icon" type="image/png" href="https://cdn.bmkg.go.id/Web/Logo-BMKG-new.png">
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #f9f9f9;
            color: #000;
        }

        header {
            background-color: #fff;
            color: navy;
            padding: 20px;
            border-bottom: 2px solid navy;
        }

        #time-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #cce7ff;
            padding: 10px 20px;
            border-radius: 10px;
            margin: 10px;
            color: navy;
            font-size: 16px;
            font-weight: bold;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-text {
            color: #1f5faa;
            font-weight: bold;
        }

        .logout-btn {
            background: #d9534f;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #c9302c;
        }

        .header-content {
            display: flex;
            align-items: center;
        }

        header img {
            width: 100px;
            margin-right: 20px;
        }

        .header-text h1 {
            font-size: 28px;
            margin: 0;
            font-weight: bold;
        }

        nav {
            background-color: navy;
            padding: 10px 0;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
        }

        nav ul li a:hover {
            background-color: #003366;
            border-radius: 5px;
        }

        #contents {
            padding: 20px;
            text-align: center;
        }

        footer {
            background-color: #fff;
            color: navy;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
            font-size: 14px;
            border-top: 2px solid navy;
        }
    </style>

    <script>
        function updateTime() {
            const now = new Date();

           // Format tanggal
           const options = {
                weekday: 'long', 
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                timeZone: 'Asia/Jakarta',
                hour12: false, // Format 24 jam
            };

            const formattedDateTime = now.toLocaleString('id-ID', options);

            // Update HTML
            document.getElementById('date-time').innerHTML = `${formattedDateTime} WIB`;
        }

        setInterval(updateTime, 1000); // Perbarui setiap detik
    </script>

</head>

<body onload="updateTime()">
    <!-- Header -->
    <header>
        <div id="time-container">
            <div id="date-time"></div>

            <!-- Admin Info -->
            <div class="admin-info">
                <?php if (isset($_SESSION['username'])): ?>
                    <span class="admin-text">Halo, Admin <?php echo $_SESSION['username']; ?>!</span>
                    <a href="logout.php" class="logout-btn">Logout</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Logo dan Tulisan Utama -->
        <div class="header-content">
            <img src="https://cdn.bmkg.go.id/Web/Logo-BMKG-new.png" alt="BMKG Logo">
            <div class="header-text">
                <h1>DISPLAY MONITORING ALOPTAMA</h1>
                <p style="font-size: 18px; margin: 5px 0;">BMKG Stasiun Klimatologi Jawa Tengah</p>
                <p style="font-size: 18px; margin: 5px 0;">Jl. Siliwangi No.291, Kalibanteng Kulon, Semarang Barat, Kota Semarang, Jawa Tengah</p>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="index.php?page=map">Sebaran Alat</a></li>
            <li><a href="index.php?page=listaws">AWS</a></li>
            <li><a href="index.php?page=listarg">ARG</a></li>
            <li><a href="index.php?page=contact">Kontak</a></li>
        </ul>
    </nav>

    <!-- Content -->
    <div id="contents">
        <?php 
        if (isset($_GET['page'])) {
            $page = $_GET['page'];

            switch ($page) {
                case 'rawdata':
                    include "rawdata.php";
                    break;
                case 'contact':
                    include "contact.php";
                    break;
                case 'listaws':
                    include "aws/listaws.php";
                    break;
                case 'listarg':
                    include "arg/listarg.php";
                    break;
                default:
                    echo "<h2>Halaman tidak ditemukan!</h2>";
                    break;
            }
        } else {
            include "aws/listaws.php";
        }
        ?>
    </div>

    <!-- Footer -->
    <footer style="background-color: navy; color: white; text-align: center; padding: 10px;">
        &copy; <?php echo date('Y'); ?> BMKG Stasiun Klimatologi Jawa Tengah | All Rights Reserved
    </footer>
</body>
</html>
