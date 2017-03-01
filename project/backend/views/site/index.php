<?php

/* @var $this yii\web\View */
$this->title = Yii::$app->params['blogName'];
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::$app->params['blogName']; ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-success">Welcome to <?php echo Yii::$app->name; ?>!  (Base on Yii <?php echo Yii::getVersion(); ?>)</div>
    </div>
</div>
