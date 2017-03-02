<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\datetime\DateTimePicker;
use backend\widgets\Alert;
use common\models\Category;

$this->title = '博客管理';
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>
</div>
<p>
    <?= Html::a('新建博客', ['blogsuper/create-blog'], ['class' => 'btn btn-success']) ?>
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
        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-bordered table-center'],
                'summaryOptions' => ['tag' => 'p', 'class' => 'text-right text-info'],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['class' => 'col-md-1'],
                    ],
                    [
                        'attribute' => 'blog_title',
                        'headerOptions' => ['class' => 'col-md-2'],
                        'filterInputOptions' => ['class' => 'form-control input-sm'],
                    ],
                    [
                        'attribute' => 'blog_content',
                        'headerOptions' => ['class' => 'col-md-2'],
                        'filterInputOptions' => ['class' => 'form-control input-sm'],
                        'value' => function ($model, $key, $index, $column) {
                            $preview = strip_tags($model->blog_content);
                            if(strlen($preview)>200){
                                $preview = mb_substr($preview, 0, 100).'...';    
                            }
                            return $preview;
                        }
                    ],
                    [
                        'attribute' => 'blog_content',
                        'headerOptions' => ['class' => 'col-md-1'],
                        'filter' => Category::getKeyValuePairs(),
                        'filterInputOptions' => ['class' => 'form-control input-sm'],
                        'value' => function ($model, $key, $index, $column) {
                            return $model->category->category_name;
                        }
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => '<div class="input-group">' . DateTimePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'createdTimeFrom',
                            'type' => DateTimePicker::TYPE_INPUT,
                            'options' => ['class' => 'form-control input-sm']
                        ]) . '<div class="input-group-addon">to</div>' . DateTimePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'createdTimeTo',
                            'type' => DateTimePicker::TYPE_INPUT,
                            'options' => ['class' => 'form-control input-sm']
                        ]) . '</div>',
                        'headerOptions' => ['class' => 'col-md-2'],
                        'value' => function ($model, $key, $index, $column) {
                            return date('Y-m-d H:i:s', $model->created_at); 
                        }
                    ],
                    [
                        'attribute' => 'updated_at',
                        'filter' => '<div class="input-group">' . DateTimePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'updatedTimeFrom',
                            'type' => DateTimePicker::TYPE_INPUT,
                            'options' => ['class' => 'form-control input-sm']
                        ]) . '<div class="input-group-addon">to</div>' . DateTimePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'updatedTimeTo',
                            'type' => DateTimePicker::TYPE_INPUT,
                            'options' => ['class' => 'form-control input-sm']
                        ]) . '</div>',
                        'headerOptions' => ['class' => 'col-md-2'],
                        'value' => function ($model, $key, $index, $column) {
                            return date('Y-m-d H:i:s', $model->created_at); 
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'headerOptions' => ['class' => 'col-md-2'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('查看', ['view-blog', 'id' => $key], ['class' => 'btn btn-info btn-xs']);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('修改', ['update-blog', 'id' => $key], ['class' => 'btn btn-warning btn-xs']);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('删除', ['delete-blog', 'id' => $key], ['class' => 'btn btn-danger btn-xs']);
                            },
                        ]
                    ]
                ]
        ]) ?>
        <?php Pjax::end() ?>
    </div>
</div>