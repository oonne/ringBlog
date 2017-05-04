<?php
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use backend\widgets\Alert;
use common\models\User;

$this->title = '用户管理';
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>
</div>
<p>
    <?= Html::beginForm(['/site/logout']) ?>
    <?= Html::a('创建用户', ['usersuper/create-user'], ['class' => 'btn btn-success']) ?>
    <?= Html::submitButton('退出登录', ['class' => 'btn btn-danger']) ?>
    <?= Html::endForm() ?>
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
                    'attribute' => 'username',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'filterInputOptions' => ['class' => 'form-control input-sm'],
                ],
                [
                    'attribute' => 'nickname',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'filterInputOptions' => ['class' => 'form-control input-sm'],
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'filter' => User::getStatusList(),
                    'filterInputOptions' => ['class' => 'form-control input-sm'],
                    'headerOptions' => ['class' => 'col-md-2'],
                    'value' => function ($model, $key, $index, $column) {
                        return Html::dropDownList('status', $model->status, User::getStatusList(), ['data-id' => $key]);
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '操作',
                    'headerOptions' => ['class' => 'col-md-2'],
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('修改', ['update-user', 'id' => $key], ['class' => 'btn btn-warning btn-xs']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('删除', ['delete-user', 'id' => $key], ['class' => 'btn btn-danger btn-xs', 'data-confirm' => Yii::t('yii', '确定删除“'.$model->nickname.'”吗？')]);
                        },
                    ]
                ]
            ]
        ]) ?>
        <?php Pjax::end() ?>
    </div>
</div>
<?php
$statusUrl = Url::to(['/usersuper/status']);
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