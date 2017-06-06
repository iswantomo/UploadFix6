<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchKunciJawaban */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kunci-jawaban-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'jadwal_kelas_id') ?>

    <?= $form->field($model, 'tipe_soal') ?>

    <?= $form->field($model, 'no_soal') ?>

    <?= $form->field($model, 'jawaban') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
