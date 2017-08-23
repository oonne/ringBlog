<?php
use yii\helpers\Html;
use common\models\Category;

$this->title = $blog->blog_title;

?>

<h1>
	<?= Html::encode($blog->blog_title) ?>
</h1>
<p>
	<span class="ring-blog-author">作者：<a href="<?= Yii::$app->params['authorUrl'] ?>" target="_blank"><?= Yii::$app->params['author'] ?></a></span>
	<span class="ring-blog-time"><?= Html::encode($blog->blog_date) ?></span>
</p>
<p>
    <?= $blog->blog_content ?>    
</p>
