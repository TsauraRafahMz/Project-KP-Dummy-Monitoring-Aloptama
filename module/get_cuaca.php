<?php
	//require_once "cuaca.php";
	$cuaca = json_encode(cuaca());
	$Getcuaca = json_decode($cuaca);
	$status = $Getcuaca->status;
	foreach ($Getcuaca->data as $value) {
		$kota = $value->kota;
		$lat  = $value->maps->latitude;
		$long = $value->maps->longitude;
		/*Get Prakiraaan Cuaca Hari ini */
		$today = $value->prakiraan->sekarang->tgl;
		$weather = $value->prakiraan->sekarang->cuaca;
		$suhu_min = $value->prakiraan->sekarang->suhu->min;
		$suhu_max = $value->prakiraan->sekarang->suhu->max;
		$kelembaban_min = $value->prakiraan->sekarang->kelembaban->min;
		$kelembaban_max = $value->prakiraan->sekarang->kelembaban->max;
		$Gettoday[] = "[".$lat.",".$long.",'".$kota."','".$today."','".$weather."',".$suhu_min.",".$suhu_max.",".$kelembaban_min.",".$kelembaban_max."]";

		/*Get Prakiraan Cuaca Hari Esok */
		$todays = $value->prakiraan->besok->tgl;
		$weathers = $value->prakiraan->besok->cuaca;
		$suhu_mins = $value->prakiraan->besok->suhu->min;
		$suhu_maxs = $value->prakiraan->besok->suhu->max;
		$kelembaban_mins = $value->prakiraan->besok->kelembaban->min;
		$kelembaban_maxs = $value->prakiraan->besok->kelembaban->max;
		$Gettodays[] = "[".$lat.",".$long.",'".$kota."','".$todays.",'".$weathers."',".$suhu_mins.",".$suhu_maxs.",".$kelembaban_mins.",".$kelembaban_maxs."]";
	}
?>
<script type="text/javascript">
  var gmarkers1 = [];
  var markers1 = [];
  
  // Our markers
  markers1 = [<?php echo implode(',',$Gettoday) ?>];

  /**
   * Function to init map
   */

  function initialize() {
      var center = new google.maps.LatLng(-2.548926,118.0148634);
      var mapOptions = {
          zoom: 5,
          center: center,
          mapTypeId: google.maps.MapTypeId.TERRAIN
      };

      map = new google.maps.Map(document.getElementById('map'), mapOptions);
      for (i = 0; i < markers1.length; i++) {
          addMarker(markers1[i]);
      }
  }

  //getIcon
  var iconSrc = {}
  iconSrc['Cerah Berawan'] = '<?php echo base_url(); ?>assets/images/cerah_berawan2.gif';
  iconSrc['Cerah'] = '<?php echo base_url(); ?>assets/images/cerah2.gif';
  iconSrc['Berawan'] = '<?php echo base_url(); ?>assets/images/berawan2.gif';
  iconSrc['Berawan Tebal'] = '<?php echo base_url(); ?>assets/images/berawan2.gif';
  iconSrc['Hujan Lebat'] = '<?php echo base_url(); ?>assets/images/hujan_lebat2.gif';
  iconSrc['Hujan Ringan'] = '<?php echo base_url(); ?>assets/images/hujan_ringan2.gif';
  iconSrc['Hujan Sedang'] = '<?php echo base_url(); ?>assets/images/hujan_sedang2.gif';
  iconSrc['Hujan Lokal'] = '<?php echo base_url(); ?>assets/images/hujan_sedang2.gif';

  var infowindow = new google.maps.InfoWindow({
      content: '',
      kota: '',
      tgl: '',
      weather: '',
      suhu_min: '',
      suhu_max: '',
      lembab_min: '',
      lembab_max: '',
      maxWidth: 250
  });
  /**
   * Function to add marker to map
  */
  function addMarker(marker) {
      var weather = marker[4];
      var pos = new google.maps.LatLng(marker[0], marker[1]);
      var kota = marker[2];
      var tgl = marker[3];
      var suhu_min = marker[5];
      var suhu_max = marker[6];
      var lembab_min = marker[7];
      var lembab_max = marker[8];
      var content = 'Informasi Detail';
      marker1 = new google.maps.Marker({
          title: kota,
          position: pos,
          category: weather,
          map: map,
          icon : iconSrc[marker[4]],
          optimized: false,
          labelContent: kota
      });
      
      gmarkers1.push(marker1);

      // Marker click listener
      google.maps.event.addListener(marker1, 'click', (function (marker1, content,kota,tgl,weather,suhu_min,suhu_max,lembab_min,lembab_max) {
          return function () {
              console.log('Gmarker 1 gets pushed');
              infowindow.setContent(
              	'<table border="0"><tr><td colspan="2">'+content+"</td></tr>"+
              	'<tr><td>Kota</td><td>'+kota+'</td></tr>'+
              	'<tr><td>Tanggal</td><td>'+tgl+'</td></tr>'+
              	'<tr><td>Cuaca</td><td>'+weather+'</td></tr>'+
              	'<tr><td>Suhu</td><td>Min: '+suhu_min+' Max: '+suhu_max+'</td></tr>'+
              	'<tr><td>Kelembaban</td><td>Min: '+lembab_min+' Max: '+lembab_max+'</td></tr>'+
              	'</table>'
                );
              infowindow.open(map, marker1);
              //map.panTo(this.getPosition());
              //map.setZoom(15);
          }
      })(marker1, content,kota,tgl,weather,suhu_min,suhu_max,lembab_min,lembab_max));
  }

  /**
   * Function to filter markers by category
   */
   /*
  filterMarkers = function (category) {
      for (i = 0; i < markers1.length; i++) {
          marker = gmarkers1[i];
          // If is same category or category not picked
          if (marker.category == category || category.length === 0) {
              marker.setVisible(true);
              //marker.setIcon(blue);
          }
          // Categories don't match 
          else {
              marker.setVisible(false);
          }
      }
  }
  */
  // Init map
  initialize();
</script>