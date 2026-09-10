<?php 
//include "session.php"; 

session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data ARG Jawa Tengah</title> 
    <link rel="icon" type="image/png" alt="Image" width="16" height="16" href="image.png">
    <link rel="stylesheet" href="dist/css/list.css" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .maincontent {
        display: flex;
        flex-wrap: wrap; /* Agar elemen yang terlalu panjang turun ke bawah */
        gap: 10px; /* Spasi antar elemen */
        justify-content: center;
        }
        /* ---- Styling Modal ---- */
        .modal {
            display: none; /* Awalnya modal tersembunyi */
            position: fixed;
            z-index: 1000; /* Pastikan modal ada di atas */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Background hitam transparan */
        }

        /* Modal box */
        .modal-content {
            background-color: white;
            width: 350px; /* Lebar modal */
            margin: 10% auto; /* Agar muncul di tengah */
            padding: 20px;
            border-radius: 10px; /* Bikin sudut melengkung */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* Tombol close (X) */
        .close {
            color: #aaa;
            float: right;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: red;
        }

        /* Styling input field */
        .modal-content input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Tombol login */
        .modal-content button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-login {
            background: #007bff;
            color: white;
        }

        /* Hover efek */
        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<h1>Data ARG Jawa Tengah</h1>

<!-- Tombol Show Raw Data -->
<button id="showRawDataBtn" class="btn btn-login">Show raw data</button>

<!-- Modal Login -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Login</h2>
        <form id="loginForm">
            <label for="username">Username:</label>
            <input type="text" id="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" required><br><br>
            <!--CAPTCHA-->
            <label>Are you a Human?</label>
            <?php
                require "captcha.php";
                $PHPCAP -> prime();
                $PHPCAP -> draw();
            ?>
            <input id="captcha" name="captcha" type="text" required><br><br>
            <button type="submit">Login</button>
        </form>
    </div>
</div>

<script>
    // Ambil elemen modal
    var modal = document.getElementById("loginModal");
    var btn = document.getElementById("showRawDataBtn");
    var span = document.getElementsByClassName("close")[0];

    // Saat tombol diklik, tampilkan modal
    btn.onclick = function() {
        <?php if (!isset($_SESSION['logged_in'])): ?>
            modal.style.display = "block";
        <?php else: ?>
            window.location.href = "index.php?page=rawdata";
        <?php endif; ?>
    }

    // Saat tombol close atau klik luar modal, tutup modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    // Tutup modal jika klik di luar kotak modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Handle form login
    document.getElementById("loginForm").onsubmit = function(event) {
        event.preventDefault();
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var captcha = document.getElementById("captcha").value;

        // Kirim data ke PHP untuk login
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "login.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText == "success") {
                    alert("Login berhasil!");
                    window.location.href = "index.php?page=rawdata";
                } else if (xhr.responseText == "captcha_failed") {
                    alert("Kode CAPTCHA salah! Silahkan coba lagi.");
                } else if (xhr.responseText == "failed"){
                    alert("Login gagal! Periksa username dan password.");
                }
            }
        };
        xhr.send("username=" + username + "&password=" + password + "&captcha=" + captcha);
    };
</script>

<div class="maincontent">
<?php
include 'koneksi/koneksi1.php';

// Fungsi untuk mengambil nama-nama tabel
function getTableNames1($koneksi1) {
    $sql1 = "SHOW TABLES";
    $result1 = mysqli_query($koneksi1, $sql1);
    $tables1 = [];
    while ($row1 = mysqli_fetch_row($result1)) {
        $tables1[] = $row1[0];
    }
    return $tables1;
}

// Fungsi untuk mengecek apakah tabel memiliki kolom 'site'
function hasSiteColumn1($koneksi1, $table1) {
    $sql1 = "DESCRIBE $table1";
    $result1 = mysqli_query($koneksi1, $sql1);
    while ($row1 = mysqli_fetch_assoc($result1)) {
        if ($row1['Field'] == 'site') {
            return true;
        }
    }
    return false;
}

// Fungsi untuk mengambil data terbaru
function getLatestData1($koneksi1, $table1) {
    $sql1 = "SELECT rr_arg, time_arg, date, batt_arg, log_temp, site 
             FROM $table1
             ORDER BY waktu DESC 
             LIMIT 1";
    $result1 = mysqli_query($koneksi1, $sql1);
    return mysqli_fetch_assoc($result1);
}

// Fungsi untuk mengambil 10 data terakhir untuk line chart
function getRecentData1($koneksi1, $table1, $limit = 10) {
    $sql1 = "SELECT time_arg, rr_arg FROM $table1 ORDER BY waktu DESC LIMIT $limit";
    $result1 = mysqli_query($koneksi1, $sql1);
    $data1 = [];
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $data1[] = $row1;
    }
    return array_reverse($data1);
}

$tables1 = getTableNames1($koneksi1);

foreach ($tables1 as $table1) {
    if (hasSiteColumn1($koneksi1, $table1)) {
        $latestData1 = getLatestData1($koneksi1, $table1);
        $recentData1 = getRecentData1($koneksi1, $table1);

        if ($latestData1) {
            $rrArg = $latestData1['rr_arg'];
            $timeArg = $latestData1['time_arg'];
            $dateArg = $latestData1['date'];
            $logArg = $latestData1['log_temp'];
            $battArg = $latestData1['batt_arg'];
            $rrData = array_column($recentData1, 'rr_arg');
            $timestamps = array_column($recentData1, 'time_arg');
            ?>

            <div class="card">
                <h3><?php echo htmlspecialchars($latestData1['site']); ?></h3>
                <p><strong>Waktu: </strong><?php echo htmlspecialchars($timeArg); ?></p>
                <p><strong>Tanggal: </strong><?php echo htmlspecialchars($dateArg); ?></p>
                <p><strong>Suhu Logger: </strong><?php echo htmlspecialchars($logArg); ?>℃</p>
                <p><strong>Baterai: </strong><?php echo htmlspecialchars($battArg); ?></p>
              
                <!-- Line Chart for Rain -->
                <div style="text-align: center;">
                    <canvas id="lineRR-<?php echo $table1; ?>" width="400" height="200"></canvas>
                    <p><strong>Hujan: </strong><?php echo htmlspecialchars($rrArg); ?> mm</p>
                </div>
            </div>

            <script>
                // Line Chart for RR
                new Chart(document.getElementById('lineRR-<?php echo $table1; ?>'), {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($timestamps); ?>,
                        datasets: [{
                            label: 'Rainfall Rate',
                            data: <?php echo json_encode($rrData); ?>,
                            borderColor: '#007bff',
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {display: true}
                        }
                    }
                });
            </script>
            <?php
        }
    }
}
?>
</div>
</body>
</html>