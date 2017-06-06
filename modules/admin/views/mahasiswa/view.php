<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\controllers\MahasiswaController;
use app\models\JadwalKelas;
//use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\JadwalKelas */

$this->title = 'Detail Jawaban ';
//$this->params['breadcrumbs'][] = ['label' => 'Jadwal Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$jwb_siswa=['','A','B','C','D','E'];
$kunci=['','.',':',':.','::','::.'];
$benar=0;$salah=0;$tdk_diisi=0;
$total_skor=0;
$list_jawaban="";
for($i=1;$i<=$jumlah_soal;$i++){
	if(empty($kunci_jawaban[$i])){
		$benar=$benar + 1;
	}else{
		if(empty($jawaban_siswa[$i])){
			$tdk_diisi=$tdk_diisi+1;
		}else{
			if($kunci_jawaban[$i] == $jawaban_siswa[$i] ){
				$benar=$benar + 1;
			}else{
				$salah=$salah + 1;
			}			
		}
	}

	$title=(empty($kunci_jawaban[$i]) ? '#' : $kunci[$kunci_jawaban[$i]]);
	$list_jawaban .= "<div title='$title' >No. ".$i." ".(empty($jawaban_siswa[$i]) ? '-':"[".$jwb_siswa[$jawaban_siswa[$i]]."]")."</div>";
}
$nilai=empty($jumlah_soal) ? 0 : ($benar*100) / $jumlah_soal;

?>
<div class="jadwal-kelas-create">

    <h1><?= Html::encode($this->title) ?></h1>
	<a href="#" onclick="window.history.back()" class="btn btn-warning" > << Kembali</a>

</div>
<div style="clear:both"></div>
<hr />

<div class="col-md-6">
	<label>Peserta Ujian :</label> <?= $mahasiswa->nim . " - " . $mahasiswa->nama ?> &nbsp; &nbsp;
	<?= Html::a('Update', ['update', 'id' => $mahasiswa->id], ['class' => 'btn btn-xs btn-primary']) ?>
    <hr />
    
    <label>Kode Ujian : </label> <?= $mahasiswa->jadwalKelas->kode_ujian ?> &nbsp; &nbsp;
    <label>Tanggal : </label> <?= date('d M Y',strtotime($mahasiswa->jadwalKelas->tanggal)) ?><br />

    <label>Nama Dosen : </label> <?= $mahasiswa->jadwalKelas->nama_dosen ?> &nbsp; &nbsp;
    <label>Matakuliah : </label> <?= $mahasiswa->jadwalKelas->matakuliah ?><br />
    
    <label>Prodi : </label> <?= $mahasiswa->jadwalKelas->prodi ?> &nbsp; &nbsp;    
    <label>Ruang : </label> <?= $mahasiswa->jadwalKelas->ruang_ujian ?>    
    <hr />
    <div class="col-md-6">
        <label>Jenis Tes / Ujian : </label> <?= JadwalKelas::TxtJenisUjian($mahasiswa->jadwalKelas->jenis_ujian) ?><br />
        <label>Tipe Soal : </label> <?= $mahasiswa->tipe_soal ?><br />
        <label>Jumlah Soal : </label> <?= $jumlah_soal; ?><br />
        <div style="clear:both"></div>
        <hr />
    
        <label>Skor / Nilai :</label> <?= number_format($nilai,2,".",""); ?> &nbsp; &nbsp;
        <?php 
			$mahasiswa->skor=$nilai;
			$mahasiswa->save();
		?>
        <hr />

    </div>
    <div class="col-md-6">
        <label>Benar : </label> <?= $benar; ?><br />
        <label>Salah : </label> <?= $salah; ?><br />
        <label>Tidak Menjawab : </label> <?= $tdk_diisi; ?><br />
    </div>

</div>
<div class="col-md-6">
	Jawaban Siswa :<br />
    <?= $list_jawaban ?>
</div>