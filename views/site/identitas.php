<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\modules\admin\controllers\Kunci_jawabanController;

$this->title = 'Peserta Ujian / Tes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-identitas">
    <h1><?= Html::encode($this->title) ?></h1>
</div>

<div class="jadwal-kelas-form">
    <div class="col-md-6">
    		<hr />
            <label>Kode Ujian : </label> <?= $jadwal_kelas->kode_ujian ?> &nbsp; &nbsp;<br />
            <label>Ruang : </label> <?= $jadwal_kelas->ruang_ujian ?> &nbsp; &nbsp;<br />
            <label>Tanggal : </label> <?= date('d M Y',strtotime($jadwal_kelas->tanggal)) ?><br />
            <label>Batas Waktu : </label> <?= date('d M Y H:i:s',strtotime($jadwal_kelas->batas_waktu)) ?><br /><br />
    
            <label>Nama Dosen : </label> <?= $jadwal_kelas->nama_dosen ?> &nbsp; &nbsp;<br />
            <label>Matakuliah : </label> <?= $jadwal_kelas->matakuliah ?><br />
            
            <label>Prodi : </label> <?= $jadwal_kelas->prodi ?> &nbsp; &nbsp;<br /><br />

            <label>Jenis Ujian / Tes : </label> <?= $jadwal_kelas->TxtJenisUjian($jadwal_kelas->jenis_ujian) ?> &nbsp; &nbsp;<br />
            <div style="clear:both"></div>
            <hr />
			<?php if( ! empty($jadwal_kelas->batas_waktu) ) {?>
                <div style="height:25px;"><?php include_once('time.php'); ?></div>
                <hr />
            <?php } ?>

    </div>

    <div class="col-md-6">
        <?php $form = ActiveForm::begin(); ?>
        
        <?php //echo $form->errorSummary($model); ?>

        <?php //echo $form->field($model, 'nim')->textInput(['maxlength' => true]) ?>
        
        <label title="<?= str_replace('.','',$_SERVER['REMOTE_ADDR']) ?>">Security Key</label>
        <div class="form-control" style="background-color:#999999; color:#FFFFFF"><?= md5($_SERVER['REMOTE_ADDR']) ?></div>
        
        <?= $form->field($model, 'nim')->textInput(['maxlength' => true, 'style'=>'background-color:#eeeeee']) ?>
        <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    	<?php 
		if($jadwal_kelas->jenis_ujian != 1){
			echo $form->field($model, 'tipe_soal')->dropDownList(Kunci_jawabanController::data_tipe_soal(), ['prompt'=>':::']); 
		}
		?>

		<?php echo $form->field($model, "pernyataan")->checkbox(['checked' => false, 'required' => true]); ?>
        
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan & Lanjutkan' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

