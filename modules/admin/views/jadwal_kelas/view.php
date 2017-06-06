<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\JadwalKelas */

$this->title = $model->kode_ujian;
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jadwal-kelas-view">

    <h1><?= Html::a(Html::encode($this->title), ['/admin/mahasiswa/index','id'=>$model->id], ['title' => 'Kembali ke Detail Kelas / Hasil Tes']); ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'kode_ujian',
            'nama_dosen',
            'matakuliah',
            'prodi',
            'ruang_ujian',
            'tanggal',
			'batas_waktu',
			[
				'label' => 'jenis_ujian',
				'format' => 'raw',
				'value' => $model->TxtJenisUjian($model->jenis_ujian),
			],
			[
				'label' => 'is_aktif',
				'format' => 'raw',
				'value' => ($model->is_aktif==1) ? '1 - Aktif' : $model->is_aktif." - Tertutup",
			],
        ],
    ]) ?>

</div>
