<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchMahasiswa */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perserta Ujian';
$this->params['breadcrumbs'][] = $this->title;

echo Html::a("<i class='glyphicon glyphicon-backward'> </i> Kembali", ['/admin/jadwal_kelas/create'], ['class' => 'btn btn-xs btn-info','title' => 'Kembali ke Jadwal Kelas']);
?>
 &nbsp; <a href="" class='btn btn-xs btn-info' ><i class='glyphicon glyphicon-refresh'> </i> Refresh</a>
<div style='clear:both'></div>
<hr />
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="col-md-6" style="overflow:auto">

    <div class="alert alert-info fade in alert-dismissable">
        <strong>Kode Ujian : <?= $searchModel->jadwalKelas->kode_ujian ?> [ <?= $searchModel->jadwalKelas->ruang_ujian ?> ]</strong>
		<small><?php echo Html::a("<i class='glyphicon glyphicon-pencil'> </i> Edit", ['/admin/jadwal_kelas/update','id'=>$searchModel->jadwal_kelas_id], ['class' => 'btn btn-xs btn-info','title' => 'Edit Jadwal Kelas Ujian']); ?></small>
        <br />
        <small>
			<?= $searchModel->jadwalKelas->matakuliah." - ".$searchModel->jadwalKelas->nama_dosen ?><br />
            Tanggal : <?= date('d M Y',strtotime($searchModel->jadwalKelas->tanggal)) ?><br />
            Batas Waktu : <?= date('d M Y, H:i:s',strtotime($searchModel->jadwalKelas->batas_waktu)) ?><br />
            Jenis Ujian : <?= $searchModel->jadwalKelas->jenis_ujian==1 ? 'Upload' : ($searchModel->jadwalKelas->jenis_ujian==2 ? 'Multiple Choice':'not set') ?> <?= ($searchModel->jadwalKelas->jenis_ujian==2 ? " <small>[ Nilai Benar = ".$searchModel->jadwalKelas->nilai_benar.", Nilai Salah = ".$searchModel->jadwalKelas->nilai_salah." ]</small>" : "") ?>
            <br />
		</small>
    </div>
	<h4>Log Mahasiswa <small style="color:#999999; font-size:11px">yang sudah masuk ke sistem</small></h4>
	<?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider_Ipaddress,
            'filterModel' => $searchModel,
			'summary'=>'', 
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
				/*
                [
                    'header' => 'Kode Ujian',
                    'attribute' => 'jadwal_kelas_id',
                    'format' => 'raw',
                    'filter' => false,
                    'value' => function($data){
                        return $data->jadwalKelas->kode_ujian."<br /><small>".$data->jadwalKelas->matakuliah." - ".$data->jadwalKelas->nama_dosen."</small>";
                    },
                ],
				*/
                'nim',
                'nama',
                [
                    'attribute' => 'ip_address',
                    'format' => 'raw',
                    'filter' => false,
                    'value' => function($data){
                        return $data->ip_address;
                    },
                ],
                [
                    'header' => '&nbsp;',
                    'format' => 'raw',
                    'value' => function($data){
                        return "<small>".Html::a('Reset', ['reset_ip', 'id' => $data->id], ['title' => 'Reset IP Address', 'class' => 'btn-xs btn-primary'])."</small>";
                    },
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
<div class="col-md-6"  style="overflow:auto">
    <table class="table table-striped table-bordered"><thead>
        </thead>
            <tr>
                <th>No.</th>
                <th>Hasil :: Uploaded Files - <?= Html::a('Create ZIP', ['/admin/jadwal_kelas/kompres_file', 'kode_ujian' => $searchModel->jadwalKelas->kode_ujian], ['class' => 'btn btn-xs btn-primary']) ?></th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>	
            <?php
            $path=Yii::$app->basePath.'/web/uploads/'.$jadwal_kelas->kode_ujian;
            $files=\yii\helpers\FileHelper::findFiles($path,['except'=>['*.php'],'recursive'=>FALSE]);
            $i=0;
            foreach($files as $data){
				$i++;
				$nama_file=str_replace($path."\\","",$data);
                echo "
                <tr>
                    <td>".$i."</td>
                    <td>".$nama_file."</td>
                    <td>".Html::a('Hapus', ['hapusfile', 'nama_file' => $nama_file, 'kode_ujian' => $searchModel->jadwalKelas->kode_ujian, 'id' => $searchModel->jadwal_kelas_id], ['title' => 'Hapus File'])."</td>
                </tr>
                ";
            }
            ?>
        </tbody>
    </table>

    <div class="panel panel-default">
      <div class="panel-heading"><b>Hasil :: Multiple Choice</b> - <?= Html::a('Set Kunci Jawaban', ['/admin/kunci_jawaban/create', 'jk_id' => $searchModel->jadwalKelas->id], ['class' => 'btn btn-xs btn-primary']) ?> &nbsp; <?= Html::a("<i class='glyphicon glyphicon-download'> </i> Excel", ['xls','id'=>$searchModel->jadwal_kelas_id], ['title' => 'Download Excel']) ?></div>
      <div class="panel-body"  style="display:<?= $jadwal_kelas->jenis_ujian==2 ? 'block' : 'none' ?>">
		<?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider_hasil,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'nim',
					[
						'attribute' => 'nama',
						'format' => 'raw',
						'value' => function($data){
							return $data->nama;
						},
					],
					[
						'attribute' => 'skor',
						'format' => 'raw',
						'value' => function($data){
							$link=Html::a("<i class='glyphicon glyphicon-refresh'> </i>", ['view', 'id' => $data->id, 'refresh' => 1], ['title' => 'Reset IP Address']);
							return $link." &nbsp; &nbsp; ".number_format($data->skor,2,".","");;
						},
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'template' => '{view}',
					],

                ],
            ]); ?>
        <?php Pjax::end(); ?>

      </div>
    </div>

</div>
