<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'LJK-Elektronik';
?>

<style>
.jumbotron .help-block-error {font-size:14px;}
</style>

<div class="site-index">
	<div class="col-md-3">
    </div>

    <div class="jumbotron col-md-6">
        <h2><b>Lembar Jawaban Elektronik</b></h2>

        <br />
		
		<?php $form = ActiveForm::begin(); ?>
        
        <?php //echo $form->errorSummary($model); ?>
        <?php echo $form->field($model, 'kode_ujian')->dropDownList($item_jadwal_kelas, ['prompt'=>'::: Token / Kode Ujian'])->label(false); ?>

        <?php echo $form->field($model, 'nim')->textInput(['maxlength' => true, 'style'=>'','placeholder'=>'Masukkan NIM', 'onkeypress'=>'return event.charCode <= 57'])->label(false) ?>
    
        <label>&nbsp;</label>
        <div class="form-group">
            <?= Html::submitButton('Lanjutkan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        
        </div>
        <?php ActiveForm::end(); ?>

    </div>

	<div class="col-md-3">
    </div>
	
    <div style="clear:both"></div>
    
    <div class="body-content">
    	<div align="center">
    	<!-- <small>Your IP Address : <?= $_SERVER['REMOTE_ADDR'] ?></small> -->
        </div>
    </div>
</div>
