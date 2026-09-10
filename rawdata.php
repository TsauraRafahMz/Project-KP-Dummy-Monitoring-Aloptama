<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: index.php");
    exit();
}

// =====================================================
// KONFIGURASI KONEKSI DATABASE
// =====================================================
// $koneksi  -> AWS -> aws_demo
// $koneksi1 -> ARG -> arg_demo
include "koneksi/Koneksi.php";
include "koneksi/koneksi1.php";


// =====================================================
// MENDAPATKAN DAFTAR TABEL DUMMY
// =====================================================

$tables = [];       // Tabel ARG
$aws_tables = [];   // Tabel AWS


// =====================================================
// MENGAMBIL TABEL ARG
// Hanya tabel dengan prefix arg_site
// =====================================================

$result = $koneksi1->query("SHOW TABLES");

if ($result) {
    while ($row = $result->fetch_array()) {

        if (strpos($row[0], 'arg_site') === 0) {
            $tables[] = $row[0];
        }

    }
}


// =====================================================
// MENGAMBIL TABEL AWS
// Hanya tabel dengan prefix aws_site
// =====================================================

$result = $koneksi->query("SHOW TABLES");

if ($result) {
    while ($row = $result->fetch_array()) {

        if (strpos($row[0], 'aws_site') === 0) {

            // Pastikan tabel memiliki kolom Date
            $column_check_query = "SHOW COLUMNS FROM `{$row[0]}` LIKE 'Date'";
            $has_date_column = $koneksi->query($column_check_query)->num_rows > 0;

            // Pastikan tabel memiliki kolom time
            $column_check_query = "SHOW COLUMNS FROM `{$row[0]}` LIKE 'time'";
            $has_time_column = $koneksi->query($column_check_query)->num_rows > 0;

            if ($has_date_column && $has_time_column) {
                $aws_tables[] = $row[0];
            }
        }
    }
}


// =====================================================
// FUNGSI MEMERIKSA KOLOM TANGGAL DAN WAKTU
// =====================================================

function hasDateAndTimeColumns($table, $connection)
{
    $columns = $connection->query("SHOW COLUMNS FROM `$table`");

    if (!$columns) {
        return false;
    }

    $has_date = false;
    $has_time = false;

    while ($col = $columns->fetch_assoc()) {

        if ($col['Field'] === 'Date' || $col['Field'] === 'date') {
            $has_date = true;
        }

        if ($col['Field'] === 'time' || $col['Field'] === 'time_arg') {
            $has_time = true;
        }
    }

    return $has_date && $has_time;
}


// =====================================================
// MENYUSUN DAFTAR SITE
// =====================================================

$sites = array_merge(
    ['semua_site'],
    $aws_tables,
    $tables
);


// =====================================================
// VARIABEL DATA
// =====================================================

$data_per_site = [];


// =====================================================
// PROSES FORM
// =====================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $selected_tool = $_POST['tool'] ?? null;
    $selected_site = $_POST['site'] ?? null;
    $tanggal_awal = $_POST['tanggal_awal'] ?? null;
    $tanggal_akhir = $_POST['tanggal_akhir'] ?? null;


    if ($tanggal_awal && $tanggal_akhir) {

        $tanggal_awal = date(
            'Y-m-d H:i:s',
            strtotime($tanggal_awal)
        );

        $tanggal_akhir = date(
            'Y-m-d H:i:s',
            strtotime($tanggal_akhir)
        );


        // =====================================================
        // DOWNLOAD CSV
        // =====================================================

        if (isset($_POST['downloadCSV'])) {

            $filename = "data_";

            if ($selected_tool) {
                $filename .= $selected_tool . "_";
            }

            if ($selected_site && $selected_site !== 'semua_site') {
                $filename .= $selected_site . "_";
            }

            $filename .=
                "from_" .
                date('Ymd_His', strtotime($tanggal_awal)) .
                "_to_" .
                date('Ymd_His', strtotime($tanggal_akhir)) .
                ".csv";


            header('Content-Type: text/csv');
            header(
                'Content-Disposition: attachment; filename="' .
                $filename .
                '"'
            );

            if (ob_get_length()) {
                ob_end_clean();
            }

            $output = fopen('php://output', 'w');


            // =================================================
            // INFORMASI CSV
            // =================================================

            fputcsv($output, [
                'Data dari:',
                ucfirst($selected_tool)
            ]);

            fputcsv($output, [
                'Site:',
                $selected_site !== 'semua_site'
                    ? $selected_site
                    : 'Semua Site'
            ]);

            fputcsv($output, [
                'Periode:',
                date('d-m-Y H:i', strtotime($tanggal_awal)) .
                " hingga " .
                date('d-m-Y H:i', strtotime($tanggal_akhir))
            ]);

            fputcsv($output, []);


            // =================================================
            // HEADER CSV ARG
            // =================================================

            if ($selected_tool === 'arg') {

                $csv_headers = [
                    'date',
                    'time_arg',
                    'site',
                    'id',
                    'rr_arg',
                    'batt_arg',
                    'log_temp'
                ];

            }


            // =================================================
            // HEADER CSV AWS
            // =================================================

            elseif ($selected_tool === 'aws') {

                $csv_headers = [
                    'Date',
                    'time',
                    'staid',
                    'site',
                    'rain',
                    'ws',
                    'ws_max',
                    'wd',
                    'temp',
                    'temp_max',
                    'temp_min',
                    'rh',
                    'press',
                    'sr',
                    'sr_max',
                    'lith',
                    'batt',
                    'ptemp',
                    'mdl',
                    'sn',
                    'os',
                    'prog'
                ];

            }

            else {

                fclose($output);
                exit;

            }


            fputcsv($output, $csv_headers);


            // =================================================
            // MENENTUKAN SITE YANG DIPROSES
            // =================================================

            if ($selected_site === 'semua_site') {

                if ($selected_tool === 'aws') {
                    $sites_to_process = $aws_tables;
                } else {
                    $sites_to_process = $tables;
                }

            } else {

                $sites_to_process = [$selected_site];

            }


            // =================================================
            // PROSES DATA CSV
            // =================================================

            foreach ($sites_to_process as $site) {


                // =================================================
                // AWS
                // =================================================

                if ($selected_tool === 'aws') {

                    if (!in_array($site, $aws_tables)) {
                        continue;
                    }


                    $query = "
                        SELECT
                            Date,
                            time,
                            staid,
                            site,
                            rain,
                            ws,
                            ws_max,
                            wd,
                            temp,
                            temp_max,
                            temp_min,
                            rh,
                            press,
                            sr,
                            sr_max,
                            lith,
                            batt,
                            ptemp,
                            mdl,
                            sn,
                            os,
                            prog
                        FROM `$site`
                        WHERE STR_TO_DATE(
                            CONCAT(Date, ' ', time),
                            '%d/%m/%Y %H:%i:%s'
                        )
                        BETWEEN '$tanggal_awal'
                        AND '$tanggal_akhir'
                    ";


                    $result_csv = $koneksi->query($query);

                    if (!$result_csv) {
                        continue;
                    }


                    while ($row = $result_csv->fetch_assoc()) {

                        fputcsv($output, [
                            $row['Date'] ?? '',
                            $row['time'] ?? '',
                            $row['staid'] ?? '',
                            $row['site'] ?? '',
                            $row['rain'] ?? '',
                            $row['ws'] ?? '',
                            $row['ws_max'] ?? '',
                            $row['wd'] ?? '',
                            $row['temp'] ?? '',
                            $row['temp_max'] ?? '',
                            $row['temp_min'] ?? '',
                            $row['rh'] ?? '',
                            $row['press'] ?? '',
                            $row['sr'] ?? '',
                            $row['sr_max'] ?? '',
                            $row['lith'] ?? '',
                            $row['batt'] ?? '',
                            $row['ptemp'] ?? '',
                            $row['mdl'] ?? '',
                            $row['sn'] ?? '',
                            $row['os'] ?? '',
                            $row['prog'] ?? ''
                        ]);

                    }

                    $result_csv->free();

                }


                // =================================================
                // ARG
                // =================================================

                elseif ($selected_tool === 'arg') {

                    if (!in_array($site, $tables)) {
                        continue;
                    }


                    $query = "
                        SELECT
                            date,
                            time_arg,
                            site,
                            id,
                            rr_arg,
                            batt_arg,
                            log_temp
                        FROM `$site`
                        WHERE STR_TO_DATE(
                            CONCAT(date, ' ', time_arg),
                            '%d/%m/%Y %H:%i:%s'
                        )
                        BETWEEN '$tanggal_awal'
                        AND '$tanggal_akhir'
                    ";


                    $result_csv = $koneksi1->query($query);

                    if (!$result_csv) {
                        continue;
                    }


                    while ($row = $result_csv->fetch_assoc()) {

                        fputcsv($output, [
                            $row['date'] ?? '',
                            $row['time_arg'] ?? '',
                            $row['site'] ?? '',
                            $row['id'] ?? '',
                            $row['rr_arg'] ?? '',
                            $row['batt_arg'] ?? '',
                            $row['log_temp'] ?? ''
                        ]);

                    }

                    $result_csv->free();
                }
            }


            fclose($output);
            exit;
        }


        // =====================================================
        // JIKA SEMUA SITE DIPILIH
        // =====================================================

        if ($selected_site === 'semua_site') {

            $unique_data = [];


            foreach ($sites as $site) {

                if ($site === 'semua_site') {
                    continue;
                }


                // =================================================
                // AWS
                // =================================================

                if (
                    $selected_tool === 'aws' &&
                    in_array($site, $aws_tables)
                ) {

                    $query = "
                        SELECT DISTINCT
                            *,
                            '$site' AS source_table
                        FROM `$site`
                        WHERE STR_TO_DATE(
                            CONCAT(Date, ' ', time),
                            '%d/%m/%Y %H:%i:%s'
                        )
                        BETWEEN '$tanggal_awal'
                        AND '$tanggal_akhir'
                    ";

                    $result = $koneksi->query($query);

                }


                // =================================================
                // ARG
                // =================================================

                elseif (
                    $selected_tool === 'arg' &&
                    in_array($site, $tables)
                ) {

                    $query = "
                        SELECT DISTINCT
                            *,
                            '$site' AS source_table
                        FROM `$site`
                        WHERE STR_TO_DATE(
                            CONCAT(date, ' ', time_arg),
                            '%d/%m/%Y %H:%i:%s'
                        )
                        BETWEEN '$tanggal_awal'
                        AND '$tanggal_akhir'
                    ";

                    $result = $koneksi1->query($query);

                }

                else {

                    continue;

                }


                if ($result && $result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {

                        unset($row['No']);
                        unset($row['source_table']);


                        // =================================================
                        // KEY DATA UNIK
                        // =================================================

                        if ($selected_tool === 'aws') {

                            $row_key =
                                $site .
                                '_' .
                                $row['Date'] .
                                '_' .
                                $row['time'];

                        } else {

                            $row_key =
                                $site .
                                '_' .
                                $row['date'] .
                                '_' .
                                $row['time_arg'];

                        }


                        if (!isset($unique_data[$row_key])) {

                            $unique_data[$row_key] = true;

                            $data_per_site[$site][] = $row;

                        }
                    }
                }
            }
        }


        // =====================================================
        // JIKA SITE TERTENTU DIPILIH
        // =====================================================

        else {

            // =================================================
            // AWS
            // =================================================

            if (
                $selected_tool === 'aws' &&
                in_array($selected_site, $aws_tables)
            ) {

                $query = "
                    SELECT DISTINCT
                        *,
                        '$selected_site' AS source_table
                    FROM `$selected_site`
                    WHERE STR_TO_DATE(
                        CONCAT(Date, ' ', time),
                        '%d/%m/%Y %H:%i:%s'
                    )
                    BETWEEN '$tanggal_awal'
                    AND '$tanggal_akhir'
                ";

                $result = $koneksi->query($query);

            }


            // =================================================
            // ARG
            // =================================================

            elseif (
                $selected_tool === 'arg' &&
                in_array($selected_site, $tables)
            ) {

                $query = "
                    SELECT DISTINCT
                        *,
                        '$selected_site' AS source_table
                    FROM `$selected_site`
                    WHERE STR_TO_DATE(
                        CONCAT(date, ' ', time_arg),
                        '%d/%m/%Y %H:%i:%s'
                    )
                    BETWEEN '$tanggal_awal'
                    AND '$tanggal_akhir'
                ";

                $result = $koneksi1->query($query);

            }


            if (
                isset($result) &&
                $result &&
                $result->num_rows > 0
            ) {

                $data_per_site[$selected_site] = [];


                while ($row = $result->fetch_assoc()) {

                    unset($row['No']);
                    unset($row['source_table']);

                    $data_per_site[$selected_site][] = $row;

                }
            }
        }

    }

    else {

        echo "
            <p style='color: red;'>
                Silakan pilih alat, site, dan masukkan tanggal awal serta akhir.
            </p>
        ";
    }


    // =====================================================
    // JIKA DATA KOSONG
    // =====================================================

    if (empty($data_per_site)) {

        echo "
            <p style='color: red;'>
                Tidak ada data yang ditampilkan untuk rentang waktu yang dipilih.
            </p>
        ";
    }


    // =====================================================
    // DOWNLOAD EXCEL
    // =====================================================

    if (
        isset($_POST['downloadXLSX']) &&
        !empty($data_per_site)
    ) {

        $filename = "data_";


        if ($selected_tool) {
            $filename .= $selected_tool . "_";
        }


        if (
            $selected_site &&
            $selected_site !== 'semua_site'
        ) {

            $filename .= $selected_site . "_";

        }


        $filename .=
            "from_" .
            date('Ymd_His', strtotime($tanggal_awal)) .
            "_to_" .
            date('Ymd_His', strtotime($tanggal_akhir)) .
            ".xlsx";


        // =================================================
        // MEMBUAT SPREADSHEET
        // =================================================

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();


        // =================================================
        // INFORMASI HEADER
        // =================================================

        $header_info = [
            [
                "Data dari:",
                ucfirst($selected_tool)
            ],
            [
                "Site:",
                $selected_site !== 'semua_site'
                    ? $selected_site
                    : 'Semua Site'
            ],
            [
                "Periode:",
                date(
                    'd-m-Y',
                    strtotime($tanggal_awal)
                ) .
                " hingga " .
                date(
                    'd-m-Y',
                    strtotime($tanggal_akhir)
                )
            ]
        ];


        $rowNum = 1;


        foreach ($header_info as $info) {

            $sheet->fromArray(
                $info,
                NULL,
                'A' . $rowNum
            );

            $rowNum++;
        }


        // Baris kosong
        $rowNum++;


        // =================================================
        // HEADER EXCEL ARG
        // =================================================

        if ($selected_tool === 'arg') {

            $xlsx_headers = [
                'date',
                'time_arg',
                'id',
                'site',
                'rr_arg',
                'batt_arg',
                'log_temp'
            ];

        }


        // =================================================
        // HEADER EXCEL AWS
        // =================================================

        elseif ($selected_tool === 'aws') {

            $xlsx_headers = [
                'Date',
                'time',
                'staid',
                'site',
                'rain',
                'ws',
                'ws_max',
                'wd',
                'temp',
                'temp_max',
                'temp_min',
                'rh',
                'press',
                'sr',
                'sr_max',
                'lith',
                'batt',
                'ptemp',
                'mdl',
                'sn',
                'os',
                'prog'
            ];

        }

        else {

            $xlsx_headers = [];

        }


        if (!empty($xlsx_headers)) {

            $sheet->fromArray(
                $xlsx_headers,
                NULL,
                'A' . $rowNum
            );

            $rowNum++;
        }


        // =================================================
        // MENULIS DATA KE EXCEL
        // =================================================

        foreach ($data_per_site as $site_data) {

            foreach ($site_data as $row) {


                // =================================================
                // DATA ARG
                // =================================================

                if ($selected_tool === 'arg') {

                    $formatted_row = [
                        $row['date'] ?? '',
                        $row['time_arg'] ?? '',
                        $row['id'] ?? '',
                        $row['site'] ?? '',
                        $row['rr_arg'] ?? '',
                        $row['batt_arg'] ?? '',
                        $row['log_temp'] ?? ''
                    ];

                }


                // =================================================
                // DATA AWS
                // =================================================

                elseif ($selected_tool === 'aws') {

                    $formatted_row = [
                        $row['Date'] ?? '',
                        $row['time'] ?? '',
                        $row['staid'] ?? '',
                        $row['site'] ?? '',
                        $row['rain'] ?? '',
                        $row['ws'] ?? '',
                        $row['ws_max'] ?? '',
                        $row['wd'] ?? '',
                        $row['temp'] ?? '',
                        $row['temp_max'] ?? '',
                        $row['temp_min'] ?? '',
                        $row['rh'] ?? '',
                        $row['press'] ?? '',
                        $row['sr'] ?? '',
                        $row['sr_max'] ?? '',
                        $row['lith'] ?? '',
                        $row['batt'] ?? '',
                        $row['ptemp'] ?? '',
                        $row['mdl'] ?? '',
                        $row['sn'] ?? '',
                        $row['os'] ?? '',
                        $row['prog'] ?? ''
                    ];

                }

                else {

                    $formatted_row = [];

                }


                $sheet->fromArray(
                    $formatted_row,
                    NULL,
                    'A' . $rowNum
                );

                $rowNum++;
            }
        }


        // =================================================
        // DOWNLOAD EXCEL
        // =================================================

        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        header(
            'Content-Disposition: attachment; filename="' .
            $filename .
            '"'
        );

        header('Cache-Control: max-age=0');


        $writer =
            \PhpOffice\PhpSpreadsheet\IOFactory::createWriter(
                $spreadsheet,
                'Xlsx'
            );


        if (ob_get_length()) {
            ob_end_clean();
        }


        $writer->save('php://output');

        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Data Alat</title>

    <link
        rel="icon"
        type="image/png"
        href="https://cdn.bmkg.go.id/Web/Logo-BMKG-new.png"
    >

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        .container {
            max-width: 2000px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            overflow-x: auto;
        }


        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.8rem;
        }


        form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }


        label {
            font-weight: bold;
            margin-bottom: 8px;
            text-align: left;
            display: block;
        }


        input,
        button {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }


        button {
            background-color: rgb(0, 0, 139);
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
        }


        button:hover {
            background-color: rgb(26, 26, 55);
        }


        .full-width {
            grid-column: span 2;
        }


        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }


        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            white-space: nowrap;
        }


        th {
            background-color: #000080;
            color: white;
        }


        tr:nth-child(even) {
            background-color: #f2f2f2;
        }


        tr:hover {
            background-color: #ddd;
        }


        select {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
            width: 100%;
            background-color: #fff;
            height: 40px;
        }

    </style>

</head>


<body>

    <div class="container">

        <h2>Data Monitoring ALOPTAMA</h2>


        <form method="POST">

            <!-- PILIH ALAT -->

            <div style="margin-bottom: 10px;">

                <label for="tool">
                    Pilih Alat:
                </label>

                <select
                    name="tool"
                    id="tool"
                    onchange="updateSites()"
                >

                    <option value="">
                        -- Pilih --
                    </option>

                    <option value="arg">
                        ARG
                    </option>

                    <option value="aws">
                        AWS
                    </option>

                </select>

            </div>


            <!-- TANGGAL AWAL -->

            <div style="margin-bottom: 10px;">

                <label for="tanggal_awal">
                    Tanggal Awal:
                </label>

                <input
                    type="datetime-local"
                    name="tanggal_awal"
                    id="tanggal_awal"
                    required
                    style="width: 100%; padding: 8px;"
                >

            </div>


            <!-- PILIH SITE -->

            <div style="margin-bottom: 10px;">

                <label for="site">
                    Pilih Site:
                </label>

                <select
                    name="site"
                    id="site"
                >

                    <option value="">
                        -- Pilih Site --
                    </option>

                    <option value="semua_site">
                        Semua Site
                    </option>

                    <?php foreach ($sites as $site): ?>

                        <?php if ($site !== 'semua_site'): ?>

                            <option
                                value="<?= htmlspecialchars($site) ?>"
                            >
                                <?= htmlspecialchars($site) ?>
                            </option>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </select>

            </div>


            <!-- TANGGAL AKHIR -->

            <div style="margin-bottom: 10px;">

                <label for="tanggal_akhir">
                    Tanggal Akhir:
                </label>

                <input
                    type="datetime-local"
                    name="tanggal_akhir"
                    id="tanggal_akhir"
                    required
                    style="width: 100%; padding: 8px;"
                >

            </div>


            <!-- DOWNLOAD CSV -->

            <div style="margin-bottom: 10px;">

                <button
                    type="submit"
                    name="downloadCSV"
                    style="width: 100%; padding: 8px;"
                >
                    Download CSV
                </button>

            </div>


            <!-- DOWNLOAD PERSENTASE -->

            <div style="margin-bottom: 10px;">

                <button
                    type="submit"
                    name="downloadpercentage"
                    style="width: 100%; padding: 8px; margin-bottom: 10px;"
                >
                    Download Persentase
                </button>

            </div>


            <!-- DOWNLOAD EXCEL -->

            <div style="margin-bottom: 10px;">

                <button
                    type="submit"
                    name="downloadXLSX"
                    style="width: 100%; padding: 8px; margin-bottom: 10px;"
                >
                    Download Excel
                </button>

            </div>


            <!-- TAMPILKAN DATA -->

            <div style="margin-bottom: 10px;">

                <button
                    type="submit"
                    style="width: 100%; padding: 8px;"
                >
                    Tampilkan Data
                </button>

            </div>

        </form>


        <?php

        // =====================================================
        // MENAMPILKAN DATA DAN PERSENTASE
        // =====================================================

        if (
            $_SERVER["REQUEST_METHOD"] == "POST" &&
            $selected_tool &&
            $selected_site &&
            $tanggal_awal &&
            $tanggal_akhir
        ) {

            $csv_data = [];

            // Target jumlah data per hari
            $target_per_day = 1440;


            // =================================================
            // MENGHITUNG PERSENTASE
            // =================================================

            if ($selected_site === 'semua_site') {

                foreach ($sites as $site) {

                    if ($site === 'semua_site') {
                        continue;
                    }


                    // =================================================
                    // QUERY AWS
                    // =================================================

                    if (
                        $selected_tool === 'aws' &&
                        in_array($site, $aws_tables)
                    ) {

                        $query_count = "
                            SELECT
                                site,
                                DATE(
                                    STR_TO_DATE(
                                        CONCAT(Date, ' ', time),
                                        '%d/%m/%Y %H:%i:%s'
                                    )
                                ) AS date,
                                COUNT(*) AS total
                            FROM `$site`
                            WHERE STR_TO_DATE(
                                CONCAT(Date, ' ', time),
                                '%d/%m/%Y %H:%i:%s'
                            )
                            BETWEEN '$tanggal_awal 00:00:00'
                            AND '$tanggal_akhir 23:59:59'
                            GROUP BY
                                site,
                                DATE(
                                    STR_TO_DATE(
                                        CONCAT(Date, ' ', time),
                                        '%d/%m/%Y %H:%i:%s'
                                    )
                                )
                        ";

                        $result_count =
                            $koneksi->query($query_count);

                    }


                    // =================================================
                    // QUERY ARG
                    // =================================================

                    elseif (
                        $selected_tool === 'arg' &&
                        in_array($site, $tables)
                    ) {

                        $query_count = "
                            SELECT
                                site,
                                DATE(
                                    STR_TO_DATE(
                                        CONCAT(date, ' ', time_arg),
                                        '%d/%m/%Y %H:%i:%s'
                                    )
                                ) AS date,
                                COUNT(*) AS total
                            FROM `$site`
                            WHERE STR_TO_DATE(
                                CONCAT(date, ' ', time_arg),
                                '%d/%m/%Y %H:%i:%s'
                            )
                            BETWEEN '$tanggal_awal 00:00:00'
                            AND '$tanggal_akhir 23:59:59'
                            GROUP BY
                                site,
                                DATE(
                                    STR_TO_DATE(
                                        CONCAT(date, ' ', time_arg),
                                        '%d/%m/%Y %H:%i:%s'
                                    )
                                )
                        ";

                        $result_count =
                            $koneksi1->query($query_count);

                    }


                    else {

                        continue;

                    }


                    if (
                        $result_count &&
                        $result_count->num_rows > 0
                    ) {

                        while (
                            $data =
                            $result_count->fetch_assoc()
                        ) {

                            $site_name =
                                $data['site'];

                            $date =
                                $data['date'];

                            $total_data =
                                $data['total'];

                            $percentage =
                                ($total_data / $target_per_day) * 100;


                            $csv_data[] = [

                                'site' =>
                                    ucfirst($site_name),

                                'date' =>
                                    $date,

                                'total_data' =>
                                    $total_data,

                                'percentage' =>
                                    number_format(
                                        $percentage,
                                        2
                                    ) . "%"

                            ];
                        }
                    }
                }
            }


            // =================================================
            // PERSENTASE SITE TERTENTU
            // =================================================

            else {

                // =================================================
                // AWS
                // =================================================

                if (
                    $selected_tool === 'aws' &&
                    in_array($selected_site, $aws_tables)
                ) {

                    $query_count = "
                        SELECT
                            site,
                            DATE(
                                STR_TO_DATE(
                                    CONCAT(Date, ' ', time),
                                    '%d/%m/%Y %H:%i:%s'
                                )
                            ) AS date,
                            COUNT(*) AS total
                        FROM `$selected_site`
                        WHERE STR_TO_DATE(
                            CONCAT(Date, ' ', time),
                            '%d/%m/%Y %H:%i:%s'
                        )
                        BETWEEN '$tanggal_awal 00:00:00'
                        AND '$tanggal_akhir 23:59:59'
                        GROUP BY
                            site,
                            DATE(
                                STR_TO_DATE(
                                    CONCAT(Date, ' ', time),
                                    '%d/%m/%Y %H:%i:%s'
                                )
                            )
                    ";

                    $result_count =
                        $koneksi->query($query_count);

                }


                // =================================================
                // ARG
                // =================================================

                elseif (
                    $selected_tool === 'arg' &&
                    in_array($selected_site, $tables)
                ) {

                    $query_count = "
                        SELECT
                            site,
                            DATE(
                                STR_TO_DATE(
                                    CONCAT(date, ' ', time_arg),
                                    '%d/%m/%Y %H:%i:%s'
                                )
                            ) AS date,
                            COUNT(*) AS total
                        FROM `$selected_site`
                        WHERE STR_TO_DATE(
                            CONCAT(date, ' ', time_arg),
                            '%d/%m/%Y %H:%i:%s'
                        )
                        BETWEEN '$tanggal_awal 00:00:00'
                        AND '$tanggal_akhir 23:59:59'
                        GROUP BY
                            site,
                            DATE(
                                STR_TO_DATE(
                                    CONCAT(date, ' ', time_arg),
                                    '%d/%m/%Y %H:%i:%s'
                                )
                            )
                    ";

                    $result_count =
                        $koneksi1->query($query_count);

                }


                if (
                    isset($result_count) &&
                    $result_count &&
                    $result_count->num_rows > 0
                ) {

                    while (
                        $data =
                        $result_count->fetch_assoc()
                    ) {

                        $site_name =
                            $data['site'];

                        $date =
                            $data['date'];

                        $total_data =
                            $data['total'];

                        $percentage =
                            ($total_data / $target_per_day) * 100;


                        $csv_data[] = [

                            'site' =>
                                ucfirst($site_name),

                            'date' =>
                                $date,

                            'total_data' =>
                                $total_data,

                            'percentage' =>
                                number_format(
                                    $percentage,
                                    2
                                ) . "%"

                        ];
                    }
                }
            }


            // =================================================
            // INFORMASI DATA
            // =================================================

            if (!empty($data_per_site[$selected_site])) {

                $site_display_name =
                    $data_per_site[$selected_site][0]['site']
                    ?? $selected_site;

            } else {

                $site_display_name =
                    $selected_site !== 'semua_site'
                    ? $selected_site
                    : 'Semua Site';

            }


            echo "
                <p>
                    Data dari: Alat
                    <strong>" .
                    strtoupper($selected_tool) .
                    "</strong>,
                    Site
                    <strong>" .
                    htmlspecialchars($site_display_name) .
                    "</strong>,
                    Periode: dari
                    <strong>" .
                    date(
                        'd-m-Y H:i',
                        strtotime($tanggal_awal)
                    ) .
                    "</strong>
                    hingga
                    <strong>" .
                    date(
                        'd-m-Y H:i',
                        strtotime($tanggal_akhir)
                    ) .
                    "</strong>
                </p>
            ";


            // =================================================
            // MENAMPILKAN TABEL DATA
            // =================================================

            foreach (
                $data_per_site
                as $site_name => $data
            ) {

                if (!empty($data)) {

                    $site_display_name =
                        $data[0]['site']
                        ?? $site_name;


                    echo "
                        <h3>
                            Data untuk Site:
                            " .
                            htmlspecialchars(
                                $site_display_name
                            ) .
                            "
                        </h3>
                    ";


                    echo "<table>";

                    echo "<thead><tr>";


                    foreach (
                        array_keys($data[0])
                        as $key
                    ) {

                        echo "<th>" .
                            htmlspecialchars($key) .
                            "</th>";

                    }


                    echo "</tr></thead>";

                    echo "<tbody>";


                    foreach ($data as $row) {

                        echo "<tr>";


                        foreach ($row as $column) {

                            echo "<td>" .
                                htmlspecialchars(
                                    (string)$column
                                ) .
                                "</td>";

                        }


                        echo "</tr>";

                    }


                    echo "</tbody>";

                    echo "</table>";

                }

                else {

                    echo "
                        <h3>
                            Tidak ada data untuk Site:
                            " .
                            htmlspecialchars($site_name) .
                            "
                        </h3>
                    ";
                }
            }


            // =================================================
            // DOWNLOAD CSV PERSENTASE
            // =================================================

            if (isset($_POST['downloadpercentage'])) {

                $filename =
                    "data_percentage_" .
                    date('Ymd_His') .
                    ".csv";


                header('Content-Type: text/csv');

                header(
                    'Content-Disposition: attachment; filename="' .
                    $filename .
                    '"'
                );


                if (ob_get_length()) {
                    ob_end_clean();
                }


                $output =
                    fopen(
                        'php://output',
                        'w'
                    );


                // Header informasi

                $header_info = [

                    [
                        'Data dari:',
                        ucfirst($selected_tool)
                    ],

                    [
                        'Site:',
                        $selected_site !== 'semua_site'
                            ? $selected_site
                            : 'Semua Site'
                    ],

                    [
                        'Periode:',
                        date(
                            'd-m-Y',
                            strtotime($tanggal_awal)
                        ) .
                        " hingga " .
                        date(
                            'd-m-Y',
                            strtotime($tanggal_akhir)
                        )
                    ]

                ];


                foreach (
                    $header_info
                    as $info
                ) {

                    fputcsv(
                        $output,
                        $info
                    );

                }


                fputcsv(
                    $output,
                    [
                        'Site',
                        'Date',
                        'Total Data',
                        'Percentage'
                    ]
                );


                foreach (
                    $csv_data
                    as $row
                ) {

                    fputcsv(
                        $output,
                        $row
                    );

                }


                fclose($output);

                exit;
            }
        }

        ?>

    </div>


    <script>

        // =====================================================
        // DATA SITE DARI PHP
        // =====================================================

        const argSites =
            <?= json_encode($tables); ?>;

        const awsSites =
            <?= json_encode($aws_tables); ?>;


        // =====================================================
        // UPDATE SITE BERDASARKAN ALAT
        // =====================================================

        function updateSites() {

            const tool =
                document.getElementById('tool').value;

            const siteSelect =
                document.getElementById('site');


            siteSelect.innerHTML =
                '<option value="">-- Pilih Site --</option>' +
                '<option value="semua_site">Semua Site</option>';


            let sites = [];


            if (tool === 'arg') {

                sites = argSites;

            }

            else if (tool === 'aws') {

                sites = awsSites;

            }


            sites.forEach(site => {

                const option =
                    document.createElement('option');

                option.value = site;

                option.textContent = site;

                siteSelect.appendChild(option);

            });

        }


        // =====================================================
        // EVENT PILIH SITE
        // =====================================================

        document
            .getElementById('site')
            .addEventListener(
                'change',
                function () {

                    const site =
                        this.value;

                    const tanggalAwalInput =
                        document.getElementById(
                            'tanggal_awal'
                        );

                    const tanggalAkhirInput =
                        document.getElementById(
                            'tanggal_akhir'
                        );


                    if (site === 'semua_site') {

                        // =================================================
                        // DEFAULT PERIODE UNTUK SEMUA SITE
                        // =================================================
                        // Menggunakan tanggal hari ini
                        // agar cocok dengan data demo terbaru.
                        // =================================================

                        const now =
                            new Date();


                        const year =
                            now.getFullYear();

                        const month =
                            String(
                                now.getMonth() + 1
                            ).padStart(
                                2,
                                '0'
                            );

                        const day =
                            String(
                                now.getDate()
                            ).padStart(
                                2,
                                '0'
                            );


                        tanggalAwalInput.value =
                            `${year}-${month}-${day}T00:00`;


                        tanggalAkhirInput.value =
                            `${year}-${month}-${day}T23:59`;

                    }

                }
            );

    </script>

</body>

</html>