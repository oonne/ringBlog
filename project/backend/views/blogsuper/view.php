<?php
use yii\helpers\Html;
use yii\widgets\Block;
use backend\widgets\Alert;

$this->title = $model->blog_title;
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>
</div>
<p>
	<?php echo '分类：'.$model->category->category_name ?>	
</p>
<?php $this->beginBlock('blog-content', true) ?>
<?php echo $model->blog_content ?>
<?php $this->endBlock() ?>