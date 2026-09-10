<?php
// Menyertakan koneksi ke database
include 'koneksi/Koneksi.php';
include 'koneksi/koneksi1.php';

//include "session.php";
include "logout.php";

// Fungsi untuk mendapatkan nama tabel dari database
function getTableNames($koneksi) {
    $tables = [];
    $result = $koneksi->query("SHOW TABLES");
    if ($result) {
        while ($row = $result->fetch_array()) {
            $tables[] = $row[0];
        }
    }
    return $tables;
}

function getTableNames1($koneksi1) {
    $tables1 = [];
    $result1 = $koneksi1->query("SHOW TABLES");
    if ($result1) {
        while ($row1 = $result1->fetch_array()) {
            $tables1[] = $row1[0];
        }
    }
    return $tables1;
}

// Fungsi untuk mengecek apakah tabel memiliki kolom 'site'
function hasSiteColumn($koneksi, $table) {
    $result = $koneksi->query("SHOW COLUMNS FROM `$table` LIKE 'site'");
    return $result && $result->num_rows > 0;
}
function hasSiteColumn1($koneksi1, $table1) {
    $result1 = $koneksi1->query("SHOW COLUMNS FROM `$table1` LIKE 'site'");
    return $result1 && $result1->num_rows > 0;
}
// Fungsi untuk mengambil data terbaru dari tabel
function getLatestData($koneksi, $table) {
    $query = "SELECT staid, site, date, time, rain, ws, ws_max, wd, temp, temp_max, rh, press, sr, sr_max, lith, batt, waktu, ptemp FROM `$table` ORDER BY waktu DESC LIMIT 1";
    $result = $koneksi->query($query);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}
function getLatestData1($koneksi1, $table1) {
    $query1 = "SELECT id, site, rr_arg, log_temp, time_arg, date, waktu, batt_arg FROM `$table1` ORDER BY waktu DESC LIMIT 1";
    $result1 = $koneksi1->query($query1);
    if ($result1 && $result1->num_rows > 0) {
        return $result1->fetch_assoc();
    }
    return null;
}

// Fungsi untuk mengambil data tabel beserta koordinat berdasarkan staid
function getTableData($koneksi, $coordinates) {
    $tables = getTableNames($koneksi);
    $data = [];

    foreach ($tables as $table) {
        if (hasSiteColumn($koneksi, $table)) {
            $latestData = getLatestData($koneksi, $table);
            if ($latestData) {
                // Cari koordinat berdasarkan staid
                $staid = $latestData['staid'];
                $latitude = isset($coordinates[$staid]) ? $coordinates[$staid]['latitude'] : null;
                $longitude = isset($coordinates[$staid]) ? $coordinates[$staid]['longitude'] : null;

                // Tambahkan data hanya jika koordinat tersedia
                if ($latitude !== null && $longitude !== null) {
                    $data[] = [
                        'site' => $latestData['site'],
                        'waktu' => $latestData['waktu'],
                        'date' => $latestData['date'],
                        'time' => $latestData['time'],
                        'rain' => $latestData['rain'],
                        'ws' => $latestData['ws'],
                        'ws_max' => $latestData['ws_max'],
                        'wd' => $latestData['wd'],
                        'temp' => $latestData['temp'],
                        'temp_max' => $latestData['temp_max'],
                        'rh' => $latestData['rh'],
                        'press' => $latestData['press'],
                        'sr' => $latestData['sr'],
                        'sr_max' => $latestData['sr_max'],
                        'lith' => $latestData['lith'],
                        'batt' => $latestData['batt'],
                        'ptemp' => $latestData['ptemp'],
                        'latitude' => $latitude,
                        'longitude' => $longitude
                    ];
                }
            }
        }
    }

    return $data;
}

function getTableData1($koneksi1, $coordinates1) {
    $tables1 = getTableNames1($koneksi1);
    $data1 = [];

    foreach ($tables1 as $table1) {
        if (hasSiteColumn1($koneksi1, $table1)) {
            $latestData1 = getLatestData1($koneksi1, $table1);
            if ($latestData1) {
                // Cari koordinat berdasarkan staid
                $staid1 = $latestData1['id'];
                $latitude1 = isset($coordinates1[$staid1]) ? $coordinates1[$staid1]['latitude'] : null;
                $longitude1 = isset($coordinates1[$staid1]) ? $coordinates1[$staid1]['longitude'] : null;

                // Tambahkan data hanya jika koordinat tersedia
                if ($latitude1 !== null && $longitude1 !== null) {
                    $data1[] = [
                        'site' => $latestData1['site'],
                        'waktu' => $latestData1['waktu'],
                        'date' => $latestData1['date'],
                        'time_arg' => $latestData1['time_arg'],
                        'rr_arg' => $latestData1['rr_arg'],
                        'log_temp' => $latestData1['log_temp'],
                        'batt_arg' => $latestData1['batt_arg'],
                        'latitude' => $latitude1,
                        'longitude' => $longitude1
                    ];
                }
            }
        }
    }

    return $data1;
}

// Mapping staid ke koordinat
$coordinates = [
    'DEMO01' => ['latitude' => -6.95, 'longitude' => 109.80],
    'DEMO02' => ['latitude' => -7.10, 'longitude' => 110.10],
    'DEMO03' => ['latitude' => -7.25, 'longitude' => 110.35],
    'DEMO04' => ['latitude' => -7.40, 'longitude' => 110.60],
    'DEMO05' => ['latitude' => -7.55, 'longitude' => 110.85],

    'DEMO06' => ['latitude' => -6.85, 'longitude' => 110.20],
    'DEMO07' => ['latitude' => -7.00, 'longitude' => 110.70],
    'DEMO08' => ['latitude' => -7.35, 'longitude' => 109.95],
    'DEMO09' => ['latitude' => -7.60, 'longitude' => 110.40],
]; 
     // nilai titik sesuai awscenter
    // Tambahkan lainnya...


$coordinates1 = [
    'DEMO_ARG_01' => ['latitude' => -6.90, 'longitude' => 109.95],
    'DEMO_ARG_02' => ['latitude' => -7.05, 'longitude' => 110.25],
    'DEMO_ARG_03' => ['latitude' => -7.20, 'longitude' => 110.50],
    'DEMO_ARG_04' => ['latitude' => -7.45, 'longitude' => 110.75],
    'DEMO_ARG_05' => ['latitude' => -7.65, 'longitude' => 110.00],

    'DEMO_ARG_06' => ['latitude' => -6.80, 'longitude' => 110.45],
    'DEMO_ARG_07' => ['latitude' => -7.15, 'longitude' => 109.75],
    'DEMO_ARG_08' => ['latitude' => -7.30, 'longitude' => 110.90],
    'DEMO_ARG_09' => ['latitude' => -7.70, 'longitude' => 110.55],
];    
    // nilai titik sesuai awscenter, keterangan setelah nama arg sesuai yang ada di database
    // Tambahkan lainnya...


// Ambil data tabel beserta koordinat
$markerData = getTableData($koneksi, $coordinates);

$markerData1 = getTableData1($koneksi1, $coordinates1);

echo "<script>var markerData1 = " . json_encode($markerData1) . ";</script>";
// Konversi data ke format JSON
echo "<script>var markerData = " . json_encode($markerData) . ";</script>";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring ALOPTAMA Jawa Tengah</title>
    <link rel="icon" type="image/png" src="https://cdn.bmkg.go.id/Web/Logo-BMKG-new.png" alt="Image" width="16" height="16" href="image.png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        #map {
            height: 100%; /* Pastikan memenuhi tinggi layar */
            width: 100%;  /* Pastikan memenuhi lebar layar */
            margin: 0;
            padding: 0;
        }
        /* Header */
        .header-container {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.7); /* Warna biru muda dengan transparansi */
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            max-width: 80%; /* Agar tidak terlalu lebar */
            text-align: center; /* Rata tengah teks */
        }

        /* Logo */
        .header-container img {
            height: 40px;
            width: auto;
            margin-right: 15px;
        }

        /* Teks */
        .header-container .text-container {
            text-align: center;
        }

        .header-container .text-container h1 {
            margin: 0;
            font-weight: bold;
            font-size: 12px;
            color: #003366;
        }

        .header-container .text-container p {
            margin: 0;
            font-size: 12px;
            color: #003366;
            align-item: center;
        }
        .custom-controls {
            position: absolute;
            top: 80px; /* Posisi di bawah kontrol zoom */
            left: 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            z-index: 1000;
        }

        .custom-controls button {
            width: 32px;
            height: 32px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .custom-controls button:hover {
            background-color: #f0f0f0;
            border: black;
        }

        .custom-controls button:active {
            background-color: #e0e0e0;
            border: black;
        }

        .reseticon {
            width: 20px;
            height: 20px;
        }
        
        .refreshicon {
            width: 20px;
            height: 20px;
        }

        .chart-container {
            position: absolute;
            bottom: 110px; /* Beri jarak lebih jauh dari atas */
            right: 20px; /* Beri jarak lebih jauh dari kanan */
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 170px;
            height: 170px;
            display: flex;
            justify-content: center;
            align-items: left;
        }
        .triangle-marker {
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 20px solid red; /* Warna segitiga */
            transform: translate(-10px, -20px); /* Pusatkan segitiga */
            opacity: 0.8;
        }

        .cat-container {
            position: absolute;
            bottom: 10px; 
            right: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            /* transform: translateX(-50%); */
            z-index: 1000; /* Agar di atas peta */
            display: flex;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            gap: 10px;
        }

        .btn-category {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-category:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .btn-icon {
            width: 30px;
            height: 30px;
            margin-bottom: 5px;
        }

        .btn-category span {
            font-size: 12px;
            font-weight: bold;
            color: #000;
        }

        /* Gambar dalam tombol aktif */
        .btn-category.active .btn-icon {
            filter: brightness(1) saturate(1); /* Efek pada gambar */
        }

        .btn-category .btn-icon {
            filter: saturate(0);
        }
        .menu {
        position: absolute;
        top: 10px; /* Jarak dari atas container peta */
        right: 10px; /* Jarak dari kanan container peta */
        display: flex;
        background-color: rgba(255, 255, 255, 0.0); /* Latar belakang dengan transparansi */
        z-index: 1000; /* Pastikan elemen berada di atas peta */
        }

        .menu button {
        margin: 0 5px;
        padding: 8px 15px;
        font-size: 10px;
        font-weight: bold;
        color: #333;
        background-color: #f8f9fa;
        border: 1px solid #ccc;
        border-radius: 3px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        }

        .menu button:hover {
            background-color: #f0f0f0;
            border: black;
        }

        .menu button:active {
            background-color: #e0e0e0;
        }

        .listaws {
            width: 20px;
            height: 20px;
        }
        .listarg {
            width: 20px;
            height: 20px;
        }

    </style>
</head>
<body>
    <div id="map"></div>
    <!-- Header -->
    <div class="header-container">
    <img src="https://awscenter.bmkg.go.id/public/assets/img/logo_bmkg_with_text.png" >
        <div class="text-container">
            <h1>BADAN METEOROLOGI KLIMATOLOGI DAN GEOFISIKA</h1>
            <p>MONITORING ALOPTAMA JAWA TENGAH</p>
        </div>
    </div>

    <div class="chart-container">
        <canvas id="markerChart"></canvas>
    </div>
        
    <div class="cat-container">
        <button class="btn-category" id="btn-all">
            <img src="https://awscenter.bmkg.go.id/public/assets/img/icon/all_actived.png" alt="ALL Icon" class="btn-icon">
            <span>ALL</span>
        </button>
        <button class="btn-category" id="btn-aws">
            <img src="https://awscenter.bmkg.go.id/public/assets/img/icon/aws_actived.png" alt="AWS Icon" class="btn-icon">
            <span>AWS</span>
        </button>
        <button class="btn-category" id="btn-arg">
            <img src="https://awscenter.bmkg.go.id/public/assets/img/icon/arg_actived.png" alt="ARG Icon" class="btn-icon">
            <span>ARG</span>
        </button>
    </div>

    <div class="menu">
        <a href="index.php?page=listaws"><button>
            <img src="https://img.icons8.com/?size=100&id=ER7HcTmmnbw5&format=png&color=000000" class="listaws">
            <span><br>AWS</span>
        </button></a>
        <a href="index.php?page=listarg"><button>
            <img src="https://img.icons8.com/?size=100&id=npVgN54wo6N4&format=png&color=000000" class="listarg">
            <span><br>ARG</span>
        </button></a>
    </div>

    <div class="custom-controls">
        <button id="resetView" title="Reset View">
            <img src="https://img.icons8.com/?size=100&id=8209&format=png&color=000000" alt="resetView" class="reseticon">
        </button>
        <button id="refreshMap" title="Refresh Map">
            <img src="https://img.icons8.com/?size=100&id=59872&format=png&color=000000" alt="refreshView" class="refreshicon">
        </button>
    </div>

    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        const map = L.map('map').setView([-7.25, 110.2], 9); // Koordinat Jawa Tengah
        // Pastikan peta diperbarui setelah elemen dimuat sepenuhnya
        setTimeout(() => {
            map.invalidateSize();
        }, 100);

        // Tambahkan peta dasar dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Fungsi untuk menghitung perbedaan waktu dan menentukan warna
        function getColorByTimeDifference(waktu) {
            const now = new Date(); // Waktu sekarang
            const dataTime = new Date(waktu); // Waktu dari data
            const diffInMs = now - dataTime; // Selisih waktu dalam milidetik
            const diffInDays = diffInMs / (1000 * 60 * 60 * 24); // Selisih waktu dalam hari

            if (diffInDays < 1) {
                return 'green'; // Kurang dari 1 hari
            } else if (diffInDays <= 7) {
                return 'yellow'; // Antara 1 hari - 7 hari
            } else {
                return 'red'; // Lebih dari 7 hari
            }
        }

        // Custom marker bulat
        function createCircleMarker(lat, lng, color) {
            return L.circleMarker([lat, lng], {
                radius: 10, // Ukuran marker
                fillColor: color,
                weight: 1,
                opacity: 0,
                fillOpacity: 0.7
            });
        }

        // Custom marker bulat
        function createTriangleMarker(lat, lng, color) {
            const triangleIcon = L.divIcon({
                className: '', // Tidak perlu class CSS tambahan
                html: `
                    <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="10,0 0,20 20,20" fill="${color}" opacity="0.7"/>
                    </svg>
                `,
                iconSize: [20, 20], // Ukuran ikon segitiga
                iconAnchor: [10, 20] // Posisi anchor (bagian bawah segitiga)
            });

            return L.marker([lat, lng], { icon: triangleIcon });
        }

        // Variabel untuk menghitung jumlah warna marker
        let markerCount = { green: 0, yellow: 0, red: 0 };

        let awsMarkers = [];
        let argMarkers = [];
        // Tambahkan marker AWS ke peta dan simpan ke array awsMarkers
        markerData.forEach((data) => {
            const { latitude, longitude, site, date, time, batt, rain, ws, ws_max, wd, temp, temp_max, rh, press, sr, sr_max, lith, ptemp, waktu } = data;
            const color = getColorByTimeDifference(waktu);
            markerCount[color]++;
            const popupContent = `
                <b>Site: ${site}</b><br>
                <b>Latitude: ${latitude}</b><br>
                <b>Longitude: ${longitude}</b><br>
                <b>Tanggal: ${date}</b><br>
                <b>Waktu: ${time}</b><br>
                <b>Rain: ${rain}</b><br>
                <b>WS: ${ws}</b><br>
                <b>WS Max: ${ws_max}</b><br>
                <b>WD: ${wd}</b><br>
                <b>Temp: ${temp}</b><br>
                <b>Temp Max: ${temp_max}</b><br>
                <b>RH: ${rh}</b><br>
                <b>Press: ${press}</b><br>
                <b>SR: ${sr}</b><br>
                <b>SR Max: ${sr_max}</b><br>
                <b>Lith: ${lith}</b><br>
                <b>Baterai: ${batt}</b><br>
                <b>PTEMP: ${ptemp}</b>
            `;
            const marker = createCircleMarker(latitude, longitude, color).bindPopup(popupContent);
            awsMarkers.push(marker); // Simpan marker ke array
        });

        // Tambahkan marker ARG ke peta dan simpan ke array argMarkers
        markerData1.forEach((data1) => {
            const { latitude, longitude, site, date, time_arg, rr_arg, log_temp, batt_arg, waktu } = data1;
            const color = getColorByTimeDifference(waktu);
            markerCount[color]++;
            const popupContent = `
                <b>Site: ${site}</b><br>
                <b>Latitude: ${latitude}</b><br>
                <b>Longitude: ${longitude}</b><br>
                <b>Tanggal: ${date}</b><br>
                <b>Waktu: ${time_arg}</b><br>
                <b>RR_ARG: ${rr_arg}</b><br>
                <b>Log Temp: ${log_temp}</b><br>
                <b>Baterai: ${batt_arg}</b>
            `;
            const marker = createTriangleMarker(latitude, longitude, color).bindPopup(popupContent);
            argMarkers.push(marker); // Simpan marker ke array
        });

        let awsLayer = L.layerGroup(awsMarkers);
        let argLayer = L.layerGroup(argMarkers);

        // Fungsi untuk toggle tombol
        function toggleButton(buttonId, forceActive = null) {
            const button = document.getElementById(buttonId);
            const isActive = button.classList.contains('active');

            if (forceActive === true) {
                button.classList.add('active'); // Paksa ke status aktif
            } else if (forceActive === false) {
                button.classList.remove('active'); // Paksa ke status tidak aktif
            } else {
                if (isActive) {
                    button.classList.remove('active'); // Toggle ke tidak aktif
                } else {
                    button.classList.add('active'); // Toggle ke aktif
                }
            }

            return button.classList.contains('active'); // Return status akhir
        }

        // Fungsi untuk menampilkan marker berdasarkan status tombol
        function updateMarkers() {
            const allActive = document.getElementById('btn-all').classList.contains('active');
            const awsActive = document.getElementById('btn-aws').classList.contains('active');
            const argActive = document.getElementById('btn-arg').classList.contains('active');

            // Hapus semua marker terlebih dahulu
            map.eachLayer((layer) => {
                if (layer instanceof L.LayerGroup) {
                    map.removeLayer(layer);
                }
            });

            // Tampilkan marker sesuai status
            if (allActive) {
                awsLayer.addTo(map);
                argLayer.addTo(map);
            } else {
                if (awsActive) awsLayer.addTo(map);
                if (argActive) argLayer.addTo(map);
            }
        }

        // Fungsi untuk set default semua tombol dan marker aktif
        function setDefaultActive() {
            toggleButton('btn-all', true);
            toggleButton('btn-aws', true);
            toggleButton('btn-arg', true);
            updateMarkers();
        }

        // Set default saat halaman dimuat
        setDefaultActive();

        // Koordinat awal dan zoom level awal peta
        const initialView = [ -7.25, 110.2 ]; // Ganti dengan koordinat awal
        const initialZoom = 9; // Ganti dengan zoom awal

        // Tambahkan event listener untuk tombol Reset View
        document.getElementById('resetView').addEventListener('click', () => {
            map.setView(initialView, initialZoom); // Reset posisi dan zoom ke awal
        });

        // Tambahkan event listener untuk tombol Refresh Map
        document.getElementById('refreshMap').addEventListener('click', () => {
            location.reload(); // Reload halaman untuk merefresh peta
        });

        // Buat grafik donat menggunakan Chart.js
        const ctx = document.getElementById('markerChart').getContext('2d');
        const markerChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Hijau (< 1 hari)', 'Kuning (1-7 hari)', 'Merah (> 7 hari)'],
                datasets: [{
                    label: 'Jumlah Marker',
                    data: [markerCount.green, markerCount.yellow, markerCount.red],
                    backgroundColor: ['green', 'yellow', 'red'],
                    borderColor: ['#ffffff', '#ffffff', '#ffffff'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });

        function updateChart(selection) {
    let greenCount = 0, yellowCount = 0, redCount = 0;

    // Cek layer yang aktif pada peta
    const allActive = document.getElementById('btn-all').classList.contains('active');
    const awsActive = document.getElementById('btn-aws').classList.contains('active');
    const argActive = document.getElementById('btn-arg').classList.contains('active');

    // Jika "all" atau "aws" aktif, hitung marker AWS
    if (allActive || awsActive) {
        awsMarkers.forEach(marker => {
            if (map.hasLayer(awsLayer) && awsLayer.hasLayer(marker)) { // Pastikan marker ada di layer AWS yang aktif
                const color = marker.options.fillColor || marker.options.color; // Menggunakan fillColor atau color jika ada
                if (color === 'green') greenCount++;
                else if (color === 'yellow') yellowCount++;
                else if (color === 'red') redCount++;
            }
        });
    }

    // Jika "all" atau "arg" aktif, hitung marker ARG
    if (allActive || argActive) {
        argMarkers.forEach(marker => {
            if (map.hasLayer(argLayer) && argLayer.hasLayer(marker)) {
                // Ambil elemen DOM marker dan periksa warna dari atribut 'fill' di dalam elemen SVG
                const markerElement = marker._icon.querySelector('svg polygon');
                if (markerElement) {
                    const color = markerElement.getAttribute('fill'); // Ambil warna dari atribut fill
                    if (color === 'green') greenCount++;
                    else if (color === 'yellow') yellowCount++;
                    else if (color === 'red') redCount++;
                }
            }
        });
    }

    // Perbarui chart dengan jumlah marker yang terlihat di peta
    markerChart.data.datasets[0].data = [greenCount, yellowCount, redCount];
    markerChart.update(); // Perbarui chart dengan data yang baru
}



        // Event listener untuk tombol ALL
        document.getElementById('btn-all').addEventListener('click', () => {
            const isActive = toggleButton('btn-all');
            toggleButton('btn-aws', isActive); // Ikuti status ALL
            toggleButton('btn-arg', isActive); // Ikuti status ALL
            updateMarkers();
            updateChart('all');
        });

        // Event listener untuk tombol AWS
        document.getElementById('btn-aws').addEventListener('click', () => {
            const awsActive = toggleButton('btn-aws');
            if (!awsActive) toggleButton('btn-all', false); // Matikan ALL jika AWS nonaktif
            updateMarkers();
            updateChart('aws');
        });

        // Event listener untuk tombol ARG
        document.getElementById('btn-arg').addEventListener('click', () => {
            const argActive = toggleButton('btn-arg');
            if (!argActive) toggleButton('btn-all', false); // Matikan ALL jika ARG nonaktif
            updateMarkers();
            updateChart('arg'); 
        });

        let refreshInterval;
        let refreshTimeout;

        function startAutoRefresh() {
            function refreshAtNext37() {
                let now = new Date();
                let seconds = now.getSeconds();
                let millisecondsToNext37;

                if (seconds < 59) {
                    millisecondsToNext37 = (59 - seconds) * 1000;
                } else {
                    millisecondsToNext37 = ((60 - seconds) + 59) * 1000;
                }

                refreshTimeout = setTimeout(() => {
                    location.reload();
                    refreshInterval = setInterval(() => {
                        location.reload();
                    }, 60000);
                }, millisecondsToNext37);
            }

            refreshAtNext37();
        }

        // Hentikan auto-refresh saat pengguna berpindah halaman
        window.addEventListener("beforeunload", () => {
            clearTimeout(refreshTimeout); // Hentikan refresh pertama jika belum terjadi
            clearInterval(refreshInterval); // Hentikan interval refresh yang berjalan
        });

        // Hentikan auto-refresh ketika pengguna mengklik link
        document.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", () => {
                clearTimeout(refreshTimeout);
                clearInterval(refreshInterval);
            });
        });

        // Jalankan auto-refresh saat halaman dimuat
        startAutoRefresh();        
            </script>
</body>
</html>
    
