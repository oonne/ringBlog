<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\daterange\DateRangePicker;
use backend\widgets\Alert;
use common\models\Category;
use common\models\Blog;

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
                    'attribute' => 'status',
                    'format' => 'raw',
                    'filter' => Blog::getStatusList(),
                    'filterInputOptions' => ['class' => 'form-control input-sm'],
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value' => function ($model, $key, $index, $column) {
                        return Html::dropDownList('status', $model->status, Blog::getStatusList(), ['data-id' => $key]);
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
                    'attribute' => 'updatedTimeRange',
                    'filter' => '<div class="drp-container">' . DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'updatedTimeRange',
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
<?php
$statusUrl = Url::to(['/blogsuper/status']);
$js = <<<JS
var statusHandle = function () {
    var id = $(this).attr('data-id');
    var status = $(this).val();
    $.ajax({
        url: '{$statusUrl}',
        type: 'get',
        dataType: 'json',
        data: {id: id, status: status},
        success: function () {},
        error: function () {}
    });
};
$('select[name="status"]').change(statusHandle);

$(document).on('pjax:complete', function() {
    $('select[name="status"]').change(statusHandle);
})
JS;

$this->registerJs($js);
?>