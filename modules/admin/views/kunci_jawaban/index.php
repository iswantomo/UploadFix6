<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\controllers\Kunci_jawabanController;


/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchKunciJawaban */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kunci Jawabans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kunci-jawaban-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

		<?php Pjax::begin(); ?>
		<?= GridView::widget([
            'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
            'filterModel' => $searchModel,
			'tableOptions' => [
				'class'=>'table table-striped xxx',
			],
            'columns' => [
                [
					'header' => 'No.',
					'class' => 'yii\grid\SerialColumn',
					'headerOptions' => ['style' => 'width:5%'],
				],
				[
					'attribute' => 'kode_ujian',
					'header' => 'Kode Ujian',
					'format' => 'raw',
					'value' => function($data){
						return Html::a($data->jadwalKelas->kode_ujian, ['create','jk_id'=>$data->jadwal_kelas_id]);
					},
					'headerOptions' => ['style' => 'width:20%'],
				],
				[
					'attribute' => 'tipe_soal',
					'header' => 'Tipe<br />Soal',
					'format' => 'raw',
					'value' => function($data){
						return $data->tipe_soal;
					},
					'headerOptions' => ['style' => 'width:5%'],
				],
				[
					'attribute' => 'no_soal',
					'header' => 'No Soal - Jawaban',
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
