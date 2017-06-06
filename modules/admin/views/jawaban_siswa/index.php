<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchJawabanSiswa */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jawaban Siswas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jawaban-siswa-index">

<h1><?= Html::encode($this->title) ?></h1>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'tableOptions' => [
			'class'=>'table table-striped xxx',
		],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'mahasiswa_id',
            'tipe_soal',
            'no_soal',
            'jawaban',
            // 'ip_address',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
