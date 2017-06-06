<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use app\modules\admin\controllers\Kunci_jawabanController;


/* @var $this yii\web\View */
/* @var $model app\models\KunciJawaban */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kunci-jawaban-form">

    <?php $form = ActiveForm::begin(); ?>
	<?php //echo $form->errorSummary($model); ?>

    	<?php echo $form->field($model, 'tipe_soal')->dropDownList(Kunci_jawabanController::data_tipe_soal(), ['prompt'=>':::']); ?>
        
        <?= $form->field($model, 'no_soal')->textInput() ?>
    
        <?= $form->field($model, 'jawaban')->dropDownList(Kunci_jawabanController::data_jawaban(), ['prompt'=>':::']); ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
