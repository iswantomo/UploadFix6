<?php

use yii\helpers\Html;

$this->title = 'Kompres ZIP ';
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jadwal-kelas-update">

    <h3><?= Html::encode($this->title) ?></h3>
    <hr>
    
    <b>Sukses Mengkompres Folder . <?= $kode_ujian ?></b><br><br>
	<a class="btn btn-success" href="uploads/<?= $kode_ujian ?>/<?= $kode_ujian."_".$ket_file.".zip" ?>" >Klik Untuk Download</a>
</div>
