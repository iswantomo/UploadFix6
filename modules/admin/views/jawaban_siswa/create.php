<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\JawabanSiswa */

$this->title = 'Create Jawaban Siswa';
$this->params['breadcrumbs'][] = ['label' => 'Jawaban Siswas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jawaban-siswa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
