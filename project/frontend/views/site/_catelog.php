<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use common\models\Category;
?>
<a class="ring-catelog-blog" href="/site/blog?id=<?= $model->id ?>">
    <h1>
    	<?= Html::encode($model->blog_title) ?>
    </h1>
    <p>
    	<span class="ring-catelog-category"><?= Html::encode($model->category->category_name) ?></span>
    	<span class="ring-catelog-time"><?= Html::encode($model->blog_date) ?></span>
    </p>
    <p>
	    <?php
		$preview = strip_tags($model->blog_content);
	    if (strlen($preview)>300) {
	        $preview = mb_substr($preview, 0, 150).'...';    
	    }
		echo $preview;
		?>    
	</p>
</a>
