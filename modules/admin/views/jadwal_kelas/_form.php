<style>
div.required label:after {
    content: " *";
    color: red;
}
</style>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\JadwalKelas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jadwal-kelas-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php //echo $form->errorSummary($model); ?>
    
	<div class="col-md-6">
		
		<?= $form->field($model, 'nama_dosen')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'matakuliah')->textInput(['maxlength' => true]) ?>
    
        <?php //echo $form->field($model, 'prodi')->textInput(['maxlength' => true]) ?>
        <?php echo $form->field($model, 'prodi')->dropDownList(array('S1 Matematika'=>'S1 Matematika','S1 Statistika'=>'S1 Statistika','S1 Sistem Informasi'=>'S1 Sistem Informasi','Others...'=>'Others...'), ['prompt'=>':::']); ?>

	    <?php //echo $form->field($model, 'ruang_ujian')->textInput(['maxlength' => true]) ?>
        <?php echo $form->field($model, 'ruang_ujian')->dropDownList(array('Lab_Kom_5'=>'Lab_Kom_5','Lab_Kom_6'=>'Lab_Kom_6','Lab_Kom_7'=>'Lab_Kom_7','Lab_Kom_8'=>'Lab_Kom_8','Others...'=>'Others...'), ['prompt'=>':::']); ?>
    
	</div>
    <div class="col-md-6">

		<?= $form->field($model, 'tanggal')->widget('kartik\date\DatePicker', [
			//'type' => DatePicker::TYPE_COMPONENT_APPEND,
			'removeButton' => false,
			'pluginOptions' => [
				'format'         => 'yyyy-mm-dd',
				'todayHighlight' => true,
				'clearButton'    => false,
			]
		]);	
		?>

		<?= $form->field($model, 'batas_waktu')->widget('kartik\datetime\DateTimePicker', [
			//'type' => DatePicker::TYPE_COMPONENT_APPEND,
			'removeButton' => false,
			'pluginOptions' => [
				'format'         => 'yyyy-mm-dd hh:ii:ss',
				'todayHighlight' => true,
				'clearButton'    => false,
			]
		]);	
		?>

    	<?php echo $form->field($model, 'is_aktif')->dropDownList(array('0'=>'Tutup','1'=>'Aktif / Buka'), ['prompt'=>':::']); ?>

		<?php $model->jenis_ujian=(empty($model->jenis_ujian) ? 1 : $model->jenis_ujian); ?>
    	<?php echo $form->field($model, 'jenis_ujian')->dropDownList(array('1'=>'Upload','2'=>'Multiple Choice','3'=>'Upload dan Multiple Choice'), ['prompt'=>':::']); ?>

        <label>&nbsp;</label>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
	
    </div>
    <?php ActiveForm::end(); ?>

</div>
