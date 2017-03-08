<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div>
    <h1><?= Html::encode($model->blog_title) ?></h1>
    
    <?php
	$preview = strip_tags($model->blog_content);
    if (strlen($preview)>800) {
        $preview = mb_substr($preview, 0, 400).'...';    
    }
	echo $preview;
	?>    
</div>
