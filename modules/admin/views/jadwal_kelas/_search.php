<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchJadwalKelas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jadwal-kelas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kode_ujian') ?>

    <?= $form->field($model, 'nama_dosen') ?>

    <?= $form->field($model, 'matakuliah') ?>

    <?= $form->field($model, 'prodi') ?>

    <?php // echo $form->field($model, 'ruang_ujian') ?>

    <?php // echo $form->field($model, 'tanggal') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
