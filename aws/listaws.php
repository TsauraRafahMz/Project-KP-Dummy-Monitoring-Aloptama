<?php 
//include "session.php";

session_start();
//session_destroy();

// Jika sesi ada, cek apakah sesi sudah kadaluarsa
// if (!isset($_SESSION['last_activity'])) {
//     session_destroy();
// } else {
//     $_SESSION['last_activity'] = time(); // Perbarui aktivitas
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data AWS Jawa Tengah</title>
    <link rel="icon" type="image/png" src="https://cdn.bmkg.go.id/Web/Logo-BMKG-new.png" alt="Image" width="16" height="16">
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

<h1>Data AWS Jawa Tengah</h1>

<!-- Tombol Show Raw Data -->
<button id="showRawDataBtn" class="btn btn-login">Show raw data</button>

<!-- Modal Login -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Login</h2>
        <form id="loginForm">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
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

    // Ketika tombol "Show Raw Data" diklik
    btn.onclick = function() {
        <?php if (!isset($_SESSION['logged_in'])): ?>
            modal.style.display = "block";
        <?php else: ?>
            window.location.href = "index.php?page=rawdata";
        <?php endif; ?>
    }

    // Ketika tombol "X" ditekan, modal ditutup
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
include 'koneksi/Koneksi.php';

// Fungsi untuk mengambil nama-nama tabel
function getTableNames($koneksi) {
    $sql = "SHOW TABLES";
    $result = mysqli_query($koneksi, $sql);
    $tables = [];
    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }
    return $tables;
}
// Fungsi untuk mengecek apakah tabel memiliki kolom 'site'
function hasSiteColumn($koneksi, $table) {
    $sql = "DESCRIBE $table";
    $result = mysqli_query($koneksi, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['Field'] == 'site') {
            return true;
        }
    }
    return false;
}

// Fungsi untuk mengambil data terbaru
function getLatestData($koneksi, $table) {
    $sql = "SELECT rain, time, date,ws_max,temp_max,temp_min,sr_max,lith,ptemp,mdl,sn,os,prog, wd, ws, temp, rh, press, batt, sr, site FROM $table ORDER BY waktu DESC LIMIT 1";
    $result = mysqli_query($koneksi, $sql);
    return mysqli_fetch_assoc($result);
}

// Fungsi untuk mengambil 10 data terakhir untuk line chart
function getRecentData($koneksi, $table, $limit = 10) {
    $sql = "SELECT waktu, temp, sr,rh,rain FROM $table ORDER BY waktu DESC LIMIT $limit";
    $result = mysqli_query($koneksi, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return array_reverse($data);
}

$tables = getTableNames($koneksi);

foreach ($tables as $table) {
    if (hasSiteColumn($koneksi, $table)) {
        $latestData = getLatestData($koneksi, $table);  
        $recentData = getRecentData($koneksi, $table);

        if ($latestData) {
            $rain = $latestData['rain'];
            $time = $latestData['time'];
            $press = $latestData['press'];
            $date = $latestData['date'];
            $wd = $latestData['wd'];
            $ws = $latestData['ws'];
            $tempData = array_column($recentData, 'temp');
            $srData = array_column($recentData, 'sr');
            $timestamps = array_column($recentData, 'waktu');
            $rhData = array_column($recentData, 'rh');
            $rainData = array_column($recentData, 'rain');
            ?>

            <div class="card">
                <h3><?php echo htmlspecialchars($latestData['site']); ?></h3>
                <p><strong>Waktu: </strong><?php echo htmlspecialchars($latestData['time']); ?></p>
                <p><strong>Tanggal: </strong><?php echo htmlspecialchars($latestData['date']); ?></p>

                <!-- Gauge Charts -->
                <div style="text-align: center;">
                    <canvas id="gaugeRain-<?php echo $table; ?>" width="200" height="200"></canvas>
                    <p><strong>Rain: </strong><?php echo htmlspecialchars($rain); ?> mm</p>
                </div>
                <div style="text-align: center;">
                    <canvas id="gaugeWD-<?php echo $table; ?>" width="200" height="200"></canvas>
                    <p><strong>Wind Direction: </strong><?php echo htmlspecialchars($wd); ?>°</p>
                </div>
                <div style="text-align: center;">
                    <canvas id="gaugeWS-<?php echo $table; ?>" width="200" height="200"></canvas>
                    <p><strong>Wind Speed: </strong><?php echo htmlspecialchars($ws); ?> m/s</p>
                </div>
                <div style="text-align: center;">
                    <canvas id="gaugePress-<?php echo $table; ?>" width="200" height="200"></canvas>
                    <p><strong>press: </strong><?php echo htmlspecialchars($press); ?> Pa</p>
                </div>

                <!-- Line Charts -->
                <canvas id="lineTemp-<?php echo $table; ?>" width="400" height="200"></canvas>
                <canvas id="lineSR-<?php echo $table; ?>" width="400" height="200"></canvas>
                <canvas id="lineRh-<?php echo $table; ?>" width="400" height="200"></canvas>
                <canvas id="linerain-<?php echo $table; ?>" width="400" height="200"></canvas>
            </div>

            <script>
                // Plugin untuk menambahkan teks di tengah-tengah gauge chart
                Chart.register({
                    id: 'centerText',
                    beforeDraw(chart) {
                        const ctx = chart.ctx;
                        const width = chart.width;
                        const height = chart.height;
                        const text = chart.config.options.centerText;

                        if (text) {
                            ctx.save();
                            ctx.font = '16px Arial';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillStyle = '#000';
                            ctx.fillText(text, width / 2, height / 1.6);
                            ctx.restore();
                        }
                    }
                });

                // Gauge Chart for Rain
                new Chart(document.getElementById('gaugeRain-<?php echo $table; ?>'), {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [<?php echo $rain; ?>, 100 - <?php echo $rain; ?>],
                            backgroundColor: ['#3498db', '#ecf0f1']
                        }]
                    },
                    options: {
                        circumference: 180,
                        rotation: 270,
                        cutout: '70%',
                        centerText: '<?php echo $rain; ?> mm',
                        plugins: {
                            tooltip: {enabled: false},
                            legend: {display: false}
                        }
                    }
                });
                new Chart(document.getElementById('gaugePress-<?php echo $table; ?>'), {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [<?php echo $press; ?>, 100 - <?php echo $press; ?>],
                            backgroundColor: ['#3498db', '#ecf0f1']
                        }]
                    },
                    options: {
                        circumference: 180,
                        rotation: 270,
                        cutout: '70%',
                        centerText: '<?php echo $press; ?> Pa',
                        plugins: {
                            tooltip: {enabled: false},
                            legend: {display: false}
                        }
                    }
                });

                new Chart(document.getElementById('gaugeWD-<?php echo $table; ?>'), {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [1], // Dummy data untuk menggambar lingkaran
            backgroundColor: ['#ecf0f1']
        }]
    },
    options: {
        circumference: 360, // Membuat lingkaran penuh
        rotation: 270,
        cutout: '60%', // Lebih kecil untuk ruang kompas
        plugins: {
            tooltip: { enabled: false },
            legend: { display: false }
        }
    },
    plugins: [{
        afterDraw: function (chart) {
            const ctx = chart.ctx;
            const { width, height } = chart;
            const centerX = width / 2;
            const centerY = height / 2;
            const radius = chart.chartArea.width / 2.5; // Radius kompas
            
            // Wind Direction dari PHP
            const wd = <?php echo $wd; ?>;
            const angle = (wd - 90) * (Math.PI / 180); // Konversi derajat ke radian
            
            // Gambar lingkaran luar kompas
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
            ctx.strokeStyle = '#000';
            ctx.lineWidth = 2;
            ctx.stroke();
            
            // Gambar arah mata angin
            const directions = ['N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW'];
            for (let i = 0; i < 8; i++) {
                const dirAngle = (i * 45 - 90) * (Math.PI / 180);
                const textX = centerX + (radius + 15) * Math.cos(dirAngle);
                const textY = centerY + (radius + 15) * Math.sin(dirAngle);
                
                ctx.fillStyle = '#000';
                ctx.font = '16px Arial';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(directions[i], textX, textY);
            }
            
            // Gambar anak panah arah angin
            const arrowLength = radius * 0.8;
            const arrowHead = 10;

            const endX = centerX + arrowLength * Math.cos(angle);
            const endY = centerY + arrowLength * Math.sin(angle);

            ctx.strokeStyle = '#e74c3c';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.lineTo(endX, endY);
            ctx.stroke();

            // Gambar kepala panah
            ctx.beginPath();
            ctx.moveTo(endX, endY);
            ctx.lineTo(endX - arrowHead * Math.cos(angle - Math.PI / 6), endY - arrowHead * Math.sin(angle - Math.PI / 6));
            ctx.lineTo(endX - arrowHead * Math.cos(angle + Math.PI / 6), endY - arrowHead * Math.sin(angle + Math.PI / 6));
            ctx.closePath();
            ctx.fillStyle = '#e74c3c';
            ctx.fill();
        }
    }]
});


                // Gauge Chart for Wind Speed
                new Chart(document.getElementById('gaugeWS-<?php echo $table; ?>'), {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [<?php echo $ws; ?>, 20 - <?php echo $ws; ?>],
                            backgroundColor: ['#e74c3c', '#ecf0f1']
                        }]
                    },
                    options: {
                        circumference: 180,
                        rotation: 270,
                        cutout: '80%',
                        centerText: '<?php echo $ws; ?> m/s',
                        plugins: {
                            tooltip: {enabled: false},
                            legend: {display: false}
                        }
                    }
                });

                // Line Chart for Temperature
                new Chart(document.getElementById('lineTemp-<?php echo $table; ?>'), {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($timestamps); ?>,
                        datasets: [{
                            label: 'Temperature (°C)',
                            data: <?php echo json_encode($tempData); ?>,
                            borderColor: '#3498db',
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
                // Line Chart For RH
                new Chart(document.getElementById('lineRh-<?php echo $table; ?>'), {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($timestamps); ?>,
                        datasets: [{
                            label: 'rh (°C)',
                            data: <?php echo json_encode($rhData); ?>,
                            borderColor: '#006600',
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

                // Line Chart for Solar Radiation
                new Chart(document.getElementById('lineSR-<?php echo $table; ?>'), {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($timestamps); ?>,
                        datasets: [{
                            label: 'Solar Radiation (W/m²)',
                            data: <?php echo json_encode($srData); ?>,
                            borderColor: '#f1c40f',
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
                // line chart for rain 
                new Chart(document.getElementById('linerain-<?php echo $table; ?>'), {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($timestamps); ?>,
                        datasets: [{
                            label: 'rain (mm)',
                            data: <?php echo json_encode($rainData); ?>,
                            borderColor: '#00979D',
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