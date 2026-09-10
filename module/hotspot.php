<?php
//require_once "../config/func_config.php";
$Title = pg_query("SELECT min(confidence) as conf_min,max(confidence) as conf_max,min(acq_date) as tgl_min,max(acq_date) as tgl_max FROM hotspot2");
$row_title = pg_fetch_row($Title);
$min_conf = $row_title[0];
$max_conf = $row_title[1];
$min_tgl = $row_title[2];
$max_tgl = $row_title[3];
$print_title =$min_conf." - ".$max_conf." pertgl ".$max_tgl;
//echo "min tgl ".$max_tgl;
$querys = pg_query("SELECT provinsi, count(provinsi) as total FROM hotspot2 where acq_date='$max_tgl' GROUP BY provinsi ");
//$prov = array();
while($row=pg_fetch_array($querys)){
  $prov[] = "'".$row['provinsi']."'";
  $total[] = $row['total'];
  //echo "prov : ".$row['provinsi']."<br>";
  //echo "Prov : ".$row['provinsi']."<br>";
}
/*
$query = pg_query("SELECT date_part('year',acq_date) as tahun,count(kab_kota) as total,kab_kota FROM hotspot2
                  where 1=1
                  GROUP BY kab_kota,tahun
                  ORDER BY tahun ASC");
$KabKotaArray = array();
$tahun   = array();
$tahuns   = array();
$Total = array();
$Tahun = array();
while($row=pg_fetch_array($query)){
  if(!in_array($row['tahun'], $Tahun)){
    $Tahun[] = $row['tahun']; //cek value berdasarkan tahun
  }
  $tahun[$row['kab_kota']][$row['tahun']] = $row['total']; //cek value berdasarkan tahun dan kab_kota per baris
  $tahuns[$row['tahun']][$row['kab_kota']] = $row['total']; //cek value berdasarkan tahun dan kab_kota per kolom
}
foreach($Tahun as $key){
  $print_tahun[] = "'".$key."'"; //cetak data tahun sekaligus sebagai header
}
foreach ($tahun as $kabkota => $Vkabkota) {
  $print_kabkota = $kabkota; //cetak value kab_kota
  foreach ($Tahun as $tahun) {
    if(!array_key_exists($tahun, $Vkabkota)){ //cek data, apakah data kab_kota dan tahun sama, jika tidak
      $print_value = 0; //cetak nilai 0
    }else{ //jika iya
      $print_value = number_format($Vkabkota[$tahun]); //cetak nilai total berdasarkan tahun dan kab_kota
    }
  }
  //$Gtotal += array_sum($Vkabkota); //grand total
  $print_total_baris = number_format(array_sum($Vkabkota)); //array_assosiative
}
//cetak perkolom

foreach ($tahuns as $kabkota => $Vkabkota) {
  $print_value_baris[] = array_sum($Vkabkota); //array_assosiative
}
*/
  //$print_total_kolom = number_format($Gtotal);
?>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
  
    //grafiktahun
    chart = new Highcharts.Chart({
      chart: {
          renderTo: 'grafikhotpsot',
          type: 'bar',  
          marginRight: 130,
          marginBottom: 25,
          width: null,
          height: 220
      },
      title: {
          text: '<?php echo $print_title; ?>',
          x: -20 //center
      },
      credits: {
        enabled: false
      },
      subtitle: {
          text: '',
          x: -20
      },
      xAxis: {
        labels: {
          //rotation: -90,
          style: {
              fontSize: '9px',
              fontFamily: 'Arial'
          }
        },
          //categories: ['2006', '2007', '2008','2009','2010','2011']
          //categories:[<?php //echo implode(',',$print_tahun); ?>]
          categories:[<?php echo implode(',',$prov); ?>]       
      },
      yAxis: {
          title: {  //label yAxis
              text: 'Total Titik Hotspot'
          }
          /*,
          plotLines: [{
              value: 0,
              width: 1,
              color: '#808080' //warna dari grafik line
          }]
          */
      },
      tooltip: {
          formatter: function() {
            return '<b>'+ this.series.name +'</b><br/>'+
              this.x +': '+ this.y ;
          }
      },
      legend: {
          /*layout: 'horizontal',
          align: 'right',
          verticalAlign: 'left',
          x: -10,
          y: 100,
          borderWidth: 0
          */
          enabled: false
      },
      series: [{  
          name: 'Hotspot',
          //data: [1660, 1946,2271,2590,3004,3550]
          //data:[<?php //echo implode(',',$print_value_baris); ?>]
          data:[<?php echo implode(',',$total); ?>]
      }],
      plotOptions: {
        bar: {
            dataLabels: {
              enabled: true,
              style:{
                color: '#000',
                font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
              }
            }
        }
      },
    });
  });
});

</script>