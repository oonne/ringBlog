<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\Category;

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
    NavBar::begin([
        'brandLabel' => Yii::$app->params['blogName'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top ring-nav',
        ],
    ]);

    $menuItems = [];
    $categories = Category::getCategoryList();
    foreach($categories as $category){
        array_push($menuItems, ['label' => $category['category_name'], 'url' => ['/category/'.$category['id']]]);
    };
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">
            Copyright &copy;  by <a href="http://<?= Yii::$app->params['authorUrl'] ?>" target="_blank"><?= Yii::$app->params['author'] ?></a>. All Rights Reserved.
            <?php
                if(Yii::$app->params['beian']){
                    echo '<a href="http://www.miibeian.gov.cn/" target="_blank">'.Yii::$app->params['beian'].'</a>';
                }
            ?>
        </p>
        <p class="pull-right">Powered By <a href="http://blog.oonne.com" target="_blank">RingBlog</a>.</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
