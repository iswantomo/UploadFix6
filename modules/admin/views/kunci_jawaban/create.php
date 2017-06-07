<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\controllers\Kunci_jawabanController;

/* @var $this yii\web\View */
/* @var $model app\models\KunciJawaban */

$this->title = 'Kunci Jawaban';
//$this->params['breadcrumbs'][] = ['label' => 'Kunci Jawabans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kunci-jawaban-create">

    <h1><?= Html::encode($this->title) ?> #<?= Html::a(Html::encode($jadwal_kelas->kode_ujian), ['/admin/mahasiswa/index','id'=>$jadwal_kelas->id]); ?></h1>
    <hr />
	
    <div class="col-md-5">
    	<label>Kode Ujian : </label> <?= $jadwal_kelas->kode_ujian ?> &nbsp; &nbsp;
        <label>Tanggal : </label> <?= date('d M Y',strtotime($jadwal_kelas->tanggal)) ?><br />

        <label>Nama Dosen : </label> <?= $jadwal_kelas->nama_dosen ?> &nbsp; &nbsp;
        <label>Matakuliah : </label> <?= $jadwal_kelas->matakuliah ?><br />
        
        <label>Prodi : </label> <?= $jadwal_kelas->prodi ?> &nbsp; &nbsp;
        <label>Ruang : </label> <?= $jadwal_kelas->ruang_ujian ?><br />

        <label>Nilai Benar : </label> <?= $jadwal_kelas->nilai_benar ?> &nbsp; &nbsp;
        <label>Nilai Salah : </label> <?= $jadwal_kelas->nilai_salah ?> 

        <div style="clear:both"></div>
        <hr />
		<?= $this->render('_form', [
            'model' => $model,
        ]) ?>
        
	</div>
	<div class="col-md-7">
		<?php Pjax::begin(); ?>
		<?= GridView::widget([
            'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
            'filterModel' => $searchModel,
			'tableOptions' => [
				'class'=>'table table-striped xxx',
			],
            'columns' => [
				/*
                [
					'header' => 'No.',
					'class' => 'yii\grid\SerialColumn'
				],
				*/
				[
					'attribute' => 'tipe_soal',
					'header' => 'Tipe<br />Soal',
					'format' => 'raw',
					'filter'=>Kunci_jawabanController::data_tipe_soal(),
					'value' => function($data){
						return $data->tipe_soal;
					},
					'headerOptions' => ['style' => 'width:15%'],
				],
				[
					'attribute' => 'no_soal',
					'header' => 'No Soal &nbsp; [Jawaban]',
					'format' => 'raw',
					'value' => function($data){
						$kunci=Kunci_jawabanController::data_jawaban();
						return $data->no_soal." &nbsp; ".$kunci[$data->jawaban];
					},
				],
                [
					'class' => 'yii\grid\ActionColumn',
					'template' => '{delete}',
				],
            ],
        ]); ?>
		<?php Pjax::end(); ?>
    </div>
</div>
