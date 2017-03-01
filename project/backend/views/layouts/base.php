<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\BaseAsset;

/* @var $this \yii\web\View */
/* @var $content string */

BaseAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="baseurl" content="<?= Url::base() ?>">
    <meta name="author" content="JAY">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
</body>
<?php $this->endPage() ?>
</html>