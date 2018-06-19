<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Html;

$this->title = '搜索：'.$word;
?>
<div class="site-index">
    <ul class="body-content">
        <?php Pjax::begin([
            'scrollTo' => 0
        ]) ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'summaryOptions' => ['class' => 'hidden'],
            'pager' => [
                'options' => ['class' => 'pagination ring-pager-center']
            ],
            'itemView' => '_catelog',
            'emptyText' => Html::tag('div', '未搜索到相关博客', ['class' => 'alert alert-danger']),
        ]) ?>
        <?php Pjax::end() ?>
    </ul>
</div>
