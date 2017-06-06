<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KunciJawaban */

$this->title = 'Update Kunci Jawaban: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kunci Jawabans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kunci-jawaban-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
