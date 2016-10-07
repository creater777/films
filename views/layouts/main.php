<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
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
<?php $this->beginBody();
$this->registerJs('
    $(document).ready(function(){
        $("select[name=newsInPage]").on("change", function(){
            document.cookie = "newsInPage="+this.value+";path=/";
            $.pjax.reload({container:"#news"}); 
        });
    });    
');
?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Главная',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $items = [
        ['label' => 'Главная', 'url' => ['/site/index']],
        Yii::$app->user->isGuest ? (
            ['label' => 'Вход', 'url' => ['/access/login']]
        ) : (
            ['label' => 'Выход (' . Yii::$app->user->identity->username . ')', 'url' => ['/access/logout']]
        ),
    ];
    if (Yii::$app->user->isGuest){
        $items[] = ['label' => 'Регистрация', 'url' => ['/access/register']];
    }
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= $content ?>
    </div>
    <div id="notifications"></div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
