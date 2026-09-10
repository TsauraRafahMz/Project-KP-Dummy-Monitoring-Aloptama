<?php
header("Content-type: text/json");
require_once "../config/func_config.php";
$Title = pg_query("SELECT min(confidence) as conf_min,max(confidence) as conf_max,min(acq_date) as tgl_min,max(acq_date) as tgl_max FROM hotspot2");
$row_title = pg_fetch_row($Title);
$min_conf = $row_title[0];
$max_conf = $row_title[1];
$min_tgl = $row_title[2];
$max_tgl = $row_title[3];
//$print_title = "Confidence ".$min_conf." - ".$max_conf."  pertanggal ".$max_tgl;
//echo "min tgl ".$max_tgl;
$querys = pg_query("SELECT provinsi, count(provinsi) as total FROM hotspot2 where acq_date='$max_tgl' GROUP BY provinsi ");
//$prov = array();

while($row=pg_fetch_array($querys)){
	$prov = "'".$row['provinsi']."'";
	$total = $row['total'];
	//echo "prov : ".$row['provinsi']."<br>";
  	//echo "Prov : ".$row['provinsi']."<br>";
	$ret = array($prov, $total);
	echo json_encode($ret);
}
?>