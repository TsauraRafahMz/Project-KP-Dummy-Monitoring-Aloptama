<?php
error_reporting(0);

function gempa(){
	//$url = simplexml_load_file("http://data.bmkg.go.id/autogempa.xml");
	$url = simplexml_load_file("http://data.bmkg.go.id/en_autogempa.xml");

	$json = json_encode($url);

	return $json;
}
echo json_encode(gempa());
?>