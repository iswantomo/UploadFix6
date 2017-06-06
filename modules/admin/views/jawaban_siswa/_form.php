<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JawabanSiswa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jawaban-siswa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mahasiswa_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipe_soal')->textInput() ?>

    <?= $form->field($model, 'no_soal')->textInput() ?>

    <?= $form->field($model, 'jawaban')->textInput() ?>

    <?= $form->field($model, 'ip_address')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
