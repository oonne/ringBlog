<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use backend\widgets\Alert;
use common\models\Category;
use oonne\sortablegrid\SortableGridView;

$this->title = '分类管理';
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>
</div>
<p>
    <?= Html::a('创建分类', ['categorysuper/create-category'], ['class' => 'btn btn-success']) ?>
</p>
<div class="row">
    <div class="col-lg-12">
        <div class="alert-wrapper">
            <?= Alert::widget() ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <?php Pjax::begin() ?>
        <?= SortableGridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'sortableAction' => ['/categorysuper/sequence'],
            'tableOptions' => ['class' => 'table table-striped table-bordered table-center'],
            'summaryOptions' => ['tag' => 'p', 'class' => 'text-right text-muted'],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'contentOptions' => ['class' => 'sortable-handle'],
                ],
                [
                    'attribute' => 'category_name',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'filterInputOptions' => ['class' => 'form-control input-sm'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '操作',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('修改', ['update-category', 'id' => $key], ['class' => 'btn btn-warning btn-xs']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('删除', ['delete-category', 'id' => $key], ['class' => 'btn btn-danger btn-xs', 'data-confirm' => Yii::t('yii', '确定删除“'.$model->category_name.'”吗？')]);
                        },
                    ]
                ]
            ]
        ]) ?>
        <?php Pjax::end() ?>
    </div>
</div>