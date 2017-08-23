<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Html;

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
            'emptyText' => Html::tag('div', '找不到内容哦', ['class' => 'alert alert-danger']),
        ]) ?>
        <?php Pjax::end() ?>
    </ul>
</div>
