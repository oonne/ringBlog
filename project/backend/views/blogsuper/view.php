<?php
use yii\helpers\Html;

$this->title = $model->blog_title;
?>

<div class="row blog-content">
	<h1 class="page-header"><?= Html::encode($this->title) ?></h1>
	<p>
		<?php echo '分类：'.$model->category->category_name ?>	
	</p>
	<?php echo $model->blog_content ?>
</div>
