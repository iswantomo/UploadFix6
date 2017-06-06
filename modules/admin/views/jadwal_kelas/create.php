<?php
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\grid\EditableColumn;
//use yii\widgets\Pjax;
//use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\JadwalKelas */

$this->title = 'Jadwal Kelas';
//$this->params['breadcrumbs'][] = ['label' => 'Jadwal Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<a href="#" onclick="$(this).hide();$('.jadwal-kelas-create').show();return false;" class="btn btn-success">Add New</a>
<div class="jadwal-kelas-create" style="display:none">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<div style="clear:both"></div>

<hr />
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'tableOptions' => [
			'class'=>'table table-striped xxx',
		],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'kode_ujian',
			[
				'attribute' => 'kode_ujian',
				'format' => 'raw',
				'value' => function($data){
					return "<a href='".Yii::$app->urlManager->createUrl(['admin/mahasiswa/index','id'=>$data->id])."'>".$data->kode_ujian."</a>";
				},
			],
			'ruang_ujian',
            'nama_dosen',
            'matakuliah',
            'prodi',
			[
				'attribute' => 'jenis_ujian',
				'format' => 'raw',
				//'filter'=>ArrayHelper::map(ModelTabel::find()->asArray()->all(), 'id', 'name'),
				'filter'=>array("1"=>"Upload","2"=>"Multiple Choice","3"=>"Upload & Multiple Choice"),
				'value' => function($data){
					return $data->TxtJenisUjian($data->jenis_ujian);
				},
			],
			[
				'attribute' => 'tanggal',
				'format' => 'raw',
				'value' => function($data){
					$batas=(empty($data->batas_waktu) ? '#' : date('d M Y H:i:s',strtotime($data->batas_waktu)));
					$ruang=(empty($data->ruang_ujian) ? '#' : $data->ruang_ujian);
					return "<div title='".$batas." &nbsp; ".$ruang."'>".date('d M Y',strtotime($data->tanggal))."</div>";
				},
			],
			[
				'attribute' => 'is_aktif',
				'format' => 'raw',
				'filter'=>array("1"=>"Aktif","0"=>"No"),
				'value' => function($data){
					return ($data->is_aktif==1) ? 'Aktif' : "-";
				},
			],
			[
				'header' => '&nbsp;',
				'format' => 'raw',
				'value' => function($data){
					$setkunci="<a href='".Yii::$app->urlManager->createUrl(['admin/kunci_jawaban/create','jk_id'=>$data->id])."'>".(Html::img('@web/images/key.png',array('width'=>30,'title'=>'Set Kunci Jawaban')))."</a>";
					$setkunci=($data->jenis_ujian==1 ? '-' : $setkunci);
					return $setkunci;
				},
			],
			[
				'header' => '&nbsp;',
				'format' => 'raw',
				'value' => function($data){
					$link_zip=Html::a('Create ZIP', ['kompres_file', 'kode_ujian' => $data->kode_ujian], ['class' => 'btn btn-xs btn-primary']);
					return $link_zip;
				},
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
			],
        ],
    ]); ?>
</div>

