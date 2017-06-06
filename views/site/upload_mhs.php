<?php
use yii\helpers\Html;
use yii\helpers\FileHelper;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\modules\admin\controllers\Kunci_jawabanController;
use yii\db\Command;

$this->title = 'LJK';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jadwal-kelas-form">
    <div class="col-md-4">
			<h2 style="padding:0px; margin:0px;">Jadwal Ujian / Tes</h2><br />
            
            <label>Token / Kode Ujian : </label> <?= $mahasiswa->jadwalKelas->kode_ujian ?> &nbsp; &nbsp;<br />
            <label>Ruang : </label> <?= $mahasiswa->jadwalKelas->ruang_ujian ?> &nbsp; &nbsp;<br />
            <label>Batas Waktu : </label> <?= empty($mahasiswa->jadwalKelas->batas_waktu) ? ' - ' : (date('d M Y H:i:s',strtotime($mahasiswa->jadwalKelas->batas_waktu))) ?><br /><br />
    
            <label>Nama Dosen : </label> <?= $mahasiswa->jadwalKelas->nama_dosen ?> &nbsp; &nbsp;<br />
            <label>Matakuliah : </label> <?= $mahasiswa->jadwalKelas->matakuliah ?><br />
            
            <label>Prodi : </label> <?= $mahasiswa->jadwalKelas->prodi ?> &nbsp; &nbsp;<br />
            <div style="clear:both"></div>
            <hr />
		<h2 style="padding:0px; margin:0px;">Peserta</h2><br />
        <label>NIM : </label> <?= $mahasiswa->nim ?> &nbsp; &nbsp;<br />
        <label>NAMA : </label> <?= $mahasiswa->nama ?> &nbsp; &nbsp;<br />
        
        <hr />
        <?php if( ! empty($mahasiswa->jadwalKelas->batas_waktu) ) {?>
        	<div style="height:25px;"><?php include_once('time.php'); ?></div>
			<hr />
		<?php } ?>
    </div>

    <div class="col-md-8" >        
        <div id="konten_utama">
        
			<?php $form = ActiveForm::begin(); ?>
            
            <?php echo $form->field($mhs_upload, "file_mhs")->fileInput(); ?>
            <div class="form-group">
                <?= Html::submitButton(':: Kirim ::', ['class' => 'btn btn-sm btn-success']) ?>
            </div>
            
            <?php ActiveForm::end(); ?>    
        </div>

        <table class="table table-striped table-bordered"><thead>
            </thead>
                <tr>
                    <th>No.</th>
                    <th>Uploaded Files</th>
                </tr>
            </thead>
            <tbody>	
                <?php
				$path=Yii::$app->basePath.'/web/uploads/'.$mahasiswa->jadwalKelas->kode_ujian;
				$files=\yii\helpers\FileHelper::findFiles($path,['except'=>['*.php'],'recursive'=>FALSE]);
                $i=0;
                foreach($files as $data){
                    $i++;
                    echo "
                    <tr>
                        <td>".$i."</td>
                        <td>".str_replace($path."\\","",$data)."</td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
        
    </div>
</div>

