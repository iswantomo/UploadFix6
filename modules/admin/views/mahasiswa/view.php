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
    <label>Ruang : </label> <?= $mahasiswa->jadwalKelas->ruang_ujian ?><br />

    <label>Nilai Benar : </label> <?= $mahasiswa->jadwalKelas->nilai_benar ?> &nbsp; &nbsp;
    <label>Nilai Salah : </label> <?= $mahasiswa->jadwalKelas->nilai_salah ?> 

    <hr />
    <div class="col-md-6">
        <label>Jenis Tes / Ujian : </label> <?= JadwalKelas::TxtJenisUjian($mahasiswa->jadwalKelas->jenis_ujian) ?><br />
        <label>Tipe Soal : </label> <?= $mahasiswa->tipe_soal ?><br />
        <label>Jumlah Soal : </label> <?= $jumlah_soal; ?><br />
        <div style="clear:both"></div>
        <hr />
    
        <label>Skor / Nilai :</label> <?= number_format($mahasiswa->skor,2,".",""); ?> &nbsp; &nbsp;
        <hr />

    </div>
    <div class="col-md-6">
        <label>Benar : </label> <?= $mahasiswa->benar; ?><br />
        <label>Salah : </label> <?= $mahasiswa->salah; ?><br />
        <label>Tidak Menjawab : </label> <?= $mahasiswa->tidak_menjawab; ?><br />
    </div>

</div>
<div class="col-md-6">
	Jawaban Siswa :<br />
    <?= $list_jawaban ?>
</div>