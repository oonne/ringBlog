<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\widgets\Alert;
use yii\jui\DatePicker;
use common\models\Category;

$this->title =  $model->blog_title;
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
    <?= $form->field($model, 'blog_content')->textarea(['rows' => '20', 'style' => 'resize: vertical;']) ?>
    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>
	<?php ActiveForm::end(); ?>
</div>