<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = Yii::$app->params['blogName'];
?>
<div class="site-index">
    <ul class="body-content">
        <?php Pjax::begin() ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'summaryOptions' => ['class' => 'hidden'],
            'pager' => [
            	'options' => ['class' => 'pagination ring-pager-center']
        	],
            'itemView' => '_catelog',
        ]) ?>
        <?php Pjax::end() ?>
    </ul>
</div>
