<?php
//Yii::$app->user->identity->id
if (empty($_REQUEST['id'])) {
	$batas=null;
}else{
	$batas=Yii::$app->db->createCommand("
		select jk.batas_waktu from mahasiswa m 
		left join jadwal_kelas jk on m.jadwal_kelas_id=jk.id
		where m.id='".$_REQUEST['id']."' limit 1
	")->queryScalar();
}

$waktu_skrg  = strtotime(date("Y-m-d H:i:s"));
$waktu_akhir = strtotime((empty($batas) ? date("Y-m-d H:i:s") : $batas));
$differenceInSeconds =$waktu_akhir - $waktu_skrg;
?>
<div id="countdown" class="timer" style="text-align:center; font-size:16px; font-weight:bold; "></div>
<script>
var seconds = <?php echo $differenceInSeconds ?>;
function secondPassed() {
    var minutes = Math.round((seconds - 30)/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds;  
    }
    document.getElementById('countdown').innerHTML = "Sisa Waktu &nbsp; &nbsp; " + minutes + ":" + remainingSeconds;
    if (seconds <= 0) {
        clearInterval(countdownTimer);
        document.getElementById('countdown').innerHTML = "00:00";
		document.getElementById('konten_utama').innerHTML = "<div class='alert alert-danger'><strong>Time Out!</strong> <br />Waktu habis, silakan meninggalkan ruangan.</div>";
    } else {
        seconds--;
    }
}
 
var countdownTimer = setInterval('secondPassed()', 1000);
</script>
