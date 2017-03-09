<?php
use yii\helpers\Html;
use common\models\Category;

$this->title = Yii::$app->params['blogName'];

?>
<a class="ring-catelog-blog">
    <h1>
    	<?= Html::encode($blog->blog_title) ?>
    </h1>
    <p>
    	<span class="ring-catelog-category"><?= Html::encode($blog->category->category_name) ?></span>
    	<span class="ring-catelog-time"><?= Html::encode(date("Y-m-d H:i", $blog->created_at)) ?></span>
    </p>
    <p>
	    <?= $blog->blog_content ?>    
	</p>
</a>
