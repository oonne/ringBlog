<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\daterange\DateRangePicker;
use backend\widgets\Alert;
use common\models\Category;
use common\models\Blog;

$this->title = '回收站';
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>
</div>
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
            'summaryOptions' => ['tag' => 'p', 'class' => 'text-right text-muted'],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['class' => 'col-md-1'],
                ],
                [
                    'attribute' => 'blog_title',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'filterInputOptions' => ['class' => 'form-control input-sm'],
                ],
                [
                    'attribute' => 'blog_content',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'filterInputOptions' => ['class' => 'form-control input-sm'],
                    'value' => function ($model, $key, $index, $column) {
                        $preview = strip_tags($model->blog_content);
                        if (strlen($preview)>200) {
                            $preview = mb_substr($preview, 0, 100).'...';    
                        }
                        return $preview;
                    }
                ],
                [
                    'attribute' => 'pageviews',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'filterInputOptions' => ['class' => 'form-control input-sm'],
                ],
                [
                    'attribute' => 'blog_category',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'format' => 'html',
                    'filter' => Category::getKeyValuePairs(),
                    'filterInputOptions' => ['class' => 'form-control input-sm'],
                    'value' => function ($model, $key, $index, $column) {
                        return $model->category ? $model->category->category_name : '<b class="text-danger">分类错误</b>';
                    }
                ],
                [
                    'attribute' => 'dateRange',
                    'filter' => '<div class="drp-container">' . DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'dateRange',
                        'presetDropdown' => true,
                        'hideInput' => true,
                        'containerOptions' => ['class' => 'drp-container input-group date-range-container'],
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'Y-m-d',
                                'separator' => '~',
                            ],
                            'opens' => 'left'
                        ],
                    ]) . '</div>',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'value' => function ($model, $key, $index, $column) {
                        return $model->blog_date; 
                    }
                ],
                [
                    'attribute' => 'deletedTimeRange',
                    'filter' => '<div class="drp-container">' . DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'deletedTimeRange',
                        'presetDropdown' => true,
                        'hideInput' => true,
                        'containerOptions' => ['class' => 'drp-container input-group date-range-container'],
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'Y-m-d',
                                'separator' => '~',
                            ],
                            'opens' => 'left',
                        ],
                    ]) . '</div>',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'value' => function ($model, $key, $index, $column) {
                        return date('Y-m-d H:i:s', $model->updated_at); 
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '操作',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'template' => '{view} {recovery} {delete}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('查看', ['view-recycle', 'id' => $key], ['class' => 'btn btn-info btn-xs']);
                        },
                        'recovery' => function ($url, $model, $key) {
                            return Html::a('恢复', ['recovery-recycle', 'id' => $key], ['class' => 'btn btn-warning btn-xs']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('删除', ['delete-recycle', 'id' => $key], ['class' => 'btn btn-danger btn-xs', 'data-confirm' => Yii::t('yii', '确定彻底删除“'.$model->blog_title.'”吗？（无法恢复）')]);
                        },
                    ]
                ]
            ]
        ]) ?>
        <?php Pjax::end() ?>
    </div>
</div>