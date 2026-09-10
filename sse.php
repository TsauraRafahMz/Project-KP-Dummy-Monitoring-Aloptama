<?php
// Sertakan koneksi ke database
include 'koneksi/Koneksi.php';
include 'koneksi/koneksi1.php';

// Ambil waktu terakhir data diterima dari client
$lastReceivedTime = isset($_GET['last_time']) ? $_GET['last_time'] : 'null';

// Daftar tabel yang dikecualikan
$excluded_tables = ['tabel_awsdieng3', 'tabel_awsdiengku', 'tabel_awsdiengsoil1', 'tabel_awsdiengsoil2', 'tabel_cobacoba'];

// Fungsi untuk mengambil data terbaru dari tabel
function getLatestData($koneksi, $table, $lastReceivedTime) {
    $query = "SELECT staid, site, date, time, rain, ws, ws_max, wd, temp, temp_max, rh, press, sr, sr_max, lith, batt, waktu, ptemp 
              FROM `$table` 
              WHERE waktu > '$lastReceivedTime' 
              ORDER BY waktu DESC 
              LIMIT 1";
    $result = $koneksi->query($query);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

function getLatestData1($koneksi1, $table1, $lastReceivedTime) {
    $query1 = "SELECT id, site, rr_arg, log_temp, time_arg, date, waktu, batt_arg 
               FROM `$table1` 
               WHERE waktu > '$lastReceivedTime' 
               ORDER BY waktu DESC 
               LIMIT 1";
    $result1 = $koneksi1->query($query1);
    if ($result1 && $result1->num_rows > 0) {
        return $result1->fetch_assoc();
    }
    return null;
}

// Ambil daftar tabel dari database
$tables = $koneksi->query("SHOW TABLES")->fetch_all();
$tables1 = $koneksi1->query("SHOW TABLES")->fetch_all();

$newData = [];

// Loop untuk AWS (koneksi pertama)
foreach ($tables as $table) {
    $tableName = $table[0];

    // Lewati tabel yang dikecualikan
    if (in_array($tableName, $excluded_tables)) {
        continue;
    }

    $data = getLatestData($koneksi, $tableName, $lastReceivedTime);
    if ($data) {
        // Cari koordinat berdasarkan staid
        $staid = $data['staid'];
        if (isset($coordinates[$staid])) {
            $data['latitude'] = $coordinates[$staid]['latitude'];
            $data['longitude'] = $coordinates[$staid]['longitude'];
            $newData[] = $data;
        } else {
            // Jika staid tidak ada di $coordinates, skip data ini
            error_log("Koordinat tidak ditemukan untuk staid: $staid");
        }
    }
}

// Loop untuk ARG (koneksi kedua)
foreach ($tables1 as $table1) {
    $tableName1 = $table1[0];

    // Lewati tabel yang dikecualikan
    if (in_array($tableName1, $excluded_tables)) {
        continue;
    }

    $data1 = getLatestData1($koneksi1, $tableName1, $lastReceivedTime);
    if ($data1) {
        // Cari koordinat berdasarkan id
        $id = $data1['id'];
        if (isset($coordinates1[$id])) {
            $data1['latitude'] = $coordinates1[$id]['latitude'];
            $data1['longitude'] = $coordinates1[$id]['longitude'];
            $newData[] = $data1;
        } else {
            // Jika id tidak ada di $coordinates1, skip data ini
            error_log("Koordinat tidak ditemukan untuk id: $id");
        }
    }
}


// Kirim data ke client dalam format JSON
echo json_encode($newData);
?>
