<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

use yii\widgets\Breadcrumbs;

use frontend\assets\AppAsset;


AppAsset::register($this);

/*if( $this->context->module->requestedRoute ==  'point/view' ){
    //AppMapAsset::register($this);
}else{
    AppAsset::register($this);
}*/


?>
<?php $this->beginPage() ?>


<!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>


</head>
<body>
<?php $this->beginBody() ?>


<?= $this->render(
    'header.php'
) ?>

<main class="main">

    <?= $this->render(
        'sidebar.php'
    ) ?>

    <div class="main-container">
        <div class="main-container-inner">

            <div class="content-window">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>

                <div class="content-window-main">
                    <?= $content ?>
                </div>


            </div>



        </div>
    </div>

</main>

<div class="ajax-preloader">
    <img src="/frontend/web/img/preloader.gif" alt="">
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>