<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
	$items_guest = [
		['label' => 'Home', 'url' => ['/site/index']],
		Yii::$app->user->isGuest ? (
			['label' => 'Login', 'url' => ['/site/login']]
		) : (
			'<li>'
			. Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
			. Html::submitButton(
				'Logout (' . Yii::$app->user->identity->username . ')',
				['class' => 'btn btn-link']
			)
			. Html::endForm()
			. '</li>'
		)
	];
	$items_login = [
		['label' => 'Home', 'url' => ['/site/index']],
		['label' => 'Jadwal Kelas', 'url' => ['/admin/jadwal_kelas/create']],
		//['label' => 'Kunci Jawaban', 'url' => ['/admin/kunci_jawaban/index']],
		//['label' => 'Peserta Ujian', 'url' => ['/admin/mahasiswa/index']],
		Yii::$app->user->isGuest ? (
			['label' => 'Login', 'url' => ['/site/login']]
		) : (
			'<li>'
			. Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
			. Html::submitButton(
				'Logout (' . Yii::$app->user->identity->username . ')',
				['class' => 'btn btn-link']
			)
			. Html::endForm()
			. '</li>'
		)
	];

    NavBar::begin([
        'brandLabel' => 'Basic Science ',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => Yii::$app->user->isGuest ? $items_guest : $items_login
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <b>Basic Science</b> </p>

        <p class="pull-right" title="<?= $_SERVER['REMOTE_ADDR'] ?>">Mathematics Laboratory</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
