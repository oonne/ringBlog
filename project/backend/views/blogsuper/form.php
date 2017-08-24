<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\widgets\Alert;
use yii\jui\DatePicker;
use crazydb\ueditor\UEditor;
use common\models\Category;

$this->title = $model->isNewRecord ? '添加' : $model->blog_title;
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

<div class="row blog-content">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'blog_title') ?>
    <?= $form->field($model, 'blog_date')->widget(DatePicker::className(), [
        'options' => ['class' => 'form-control'],
        'clientOptions' => ['firstDay' => 0],
        'dateFormat' => 'yyyy-MM-dd'
    ]) ?>
    <?= $form->field($model, 'blog_category')->dropDownList(Category::getKeyValuePairs()) ?>
    <div class="form-group">
        <?= UEditor::widget([
		    'model' => $model,
		    'attribute' => 'blog_content',
		    'config' => [
                'serverUrl' => ['/editor/index'],
                'toolbars' => Yii::$app->params['UEditor']['config']['toolbars'],
                'lang' => 'zh-cn',
                'elementPathEnabled' => false,
                'wordCountMsg' => '当前已输入 {#count} 个字符',
                'iframeCssUrl' => Yii::getAlias('@web') . '/static/css/ueditor.css',// 自定义编辑器内显示效果
                'z-index' => 1
            ]
		]) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>
	<?php ActiveForm::end(); ?>
</div>