<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */

$this->title = Yii::$app->params['blogName'];
?>
<div class="site-index">
    <div class="body-content">
        <?php Pjax::begin() ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_blog',
        ]) ?>
        <?php Pjax::end() ?>
    </div>
</div>
