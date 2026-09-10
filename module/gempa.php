<script type="text/javascript">
$(document).ready(function(){

    function Playsound(){
        var audio = new Audio('<?php echo base_url(); ?>assets/music/Warning.mp3');
        audio.play();
    }

    function startTime() {
        var today=new Date(),
        curr_hour=today.getHours(),
        curr_min=today.getMinutes(),
        curr_sec=today.getSeconds();
        curr_hour=checkTime(curr_hour);
        curr_min=checkTime(curr_min);
        curr_sec=checkTime(curr_sec);
        cek_wkt = curr_hour+":"+curr_min;
        document.getElementById('clock').innerHTML=curr_hour+":"+curr_min;
        load_gempa(cek_wkt);
        load_gempa2(cek_wkt);
    }
    function checkTime(i) {
        if (i<10) {
            i="0" + i;
        }
        return i;
    }

    function load_gempa(cek_wkt){
        $.ajax({
            url: '<?php echo base_url(); ?>module/url_gempa.php',
            dataType: 'json',
            success: function(json) {
                console.log("communition with server success.");
                $.each(JSON.parse(json), function(idx, obj) {
                    var todate = '<?php echo date("d-M-y"); ?>';
                    //var totime = '<?php echo date("H:i"); ?>';
                    //var totime = '21:29';
                    //var todate = '14-Aug-16';
                    var tgl = obj.Tanggal;
                    var jam = obj.Jam.substring(0,5);
                    var jam2 = obj.Jam;
                    var wkt_gempa = tgl+" "+jam2;
                    var kordinat = obj.point.coordinates;
                    var lintang = obj.Lintang;
                    var bujur = obj.Bujur;
                    var kordinats = kordinat+","+bujur+","+lintang;
                    var magnitude = obj.Magnitude;
                    var kedalaman = obj.Kedalaman;
                    var wil_1 = obj.Wilayah1;
                    var wil_2 = obj.Wilayah2;
                    var wil_3 = obj.Wilayah3;
                    var wil_4 = obj.Wilayah4;
                    var wil_5 = obj.Wilayah5;
                    var wilayah = wil_1+","+wil_2+","+wil_3+","+wil_4+","+wil_5;
                    var potensi = obj.Potensi;
                    //$("#update").text(jam);
                    if(tgl == todate && cek_wkt == jam) {
                        Playsound();
                    }
                    $('#magnitude').text(magnitude);
                    $('#potensi').text(potensi);
                    $('#wkt_gempa').text(wkt_gempa);
                    $('#kordinat').text(kordinats);
                    $('#kedalaman').text(kedalaman);
                    $('#wilayah').text(wilayah);
                });
            },
            error: function(data, status, err) {
              console.log('error communition with server.');
            }
        });
    }

    function load_gempa2(cek_wkt){
        $.ajax({
            url: '<?php echo base_url(); ?>module/url_gempa3.php',
            dataType: 'json',
            success: function(json) {
                console.log("communition with server success.");
                $.each(JSON.parse(json), function(idx, obj) {
                    var todate = '<?php echo date("d/m/Y"); ?>';
                    //var totime = '<?php echo date("H:i"); ?>';
                    //var totime = jam;
                    //var todate = '13/11/2016';
                    var tgl = obj.Tanggal;
                    var jam = obj.Jam.substring(0,5);
                    var jam2 = obj.Jam;
                    var wkt_gempa = tgl+" "+jam2;
                    var lintang = obj.Lintang;
                    var bujur = obj.Bujur;
                    var kordinats = bujur+","+lintang;
                    var magnitude = obj.Magnitude;
                    var kedalaman = obj.Kedalaman;
                    var wil_1 = obj.Dirasakan;
                    var ket = obj.Keterangan;
                    var wilayah = wil_1;
                    var potensi = obj.Linkdetail;
                    if(tgl == todate && cek_wkt == jam) {
                        Playsound();
                    }
                    $('#magnitude2').text(magnitude);
                    $('#keterangan2').text(ket);
                    $('#wkt_gempa2').text(wkt_gempa);
                    $('#kordinat2').text(kordinats);
                    $('#kedalaman2').text(kedalaman);
                    $('#wilayah2').text(wilayah);
                });
            },
            error: function(data, status, err) {
              console.log('error communition with server.');
            }
        });
    }
    load_gempa();
    load_gempa2();
    startTime();
    /*setInterval(function(){
        load_gempa(),
        load_gempa2() // this will run after every 5 seconds
    }, 60000);*/
    setInterval(function(){startTime()},60000);
});
</script>