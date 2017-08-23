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

<div class="panel panel-default">
    <div class="panel-heading">评论</div>
    <div class="panel-body">
        <ul class="media-list">
            <?php $i = 0; foreach ($comments as $comment)  { if(empty($comment)) continue;//循环输出所有评论   ?>
            <li class="media">
                <div class="media-body">
                    <h4 class="media-heading"><?php echo '第'.++$i.'楼'; ?></h4>
                    <?php echo yii\helpers\Markdown::process($comment->comment, 'gfm');?>
                </div>
            </li>
            <?php
            if ($reply = $replys[$comment->id]) {
                echo "<hr>";
                foreach ($reply as $reply ) {                 //如果评论有回复，循环输出所有回复
                    ?>
                    <div style="margin-left:30px;"><?php echo yii\helpers\Markdown::process($reply->reply, 'gfm');?></div>
                <?php }} ?>
            <a href="javascript:void(0)" onclick="reply(this,<?php echo $comment->id;?>)" style="margin-left:30px;" >回复</a>
            <hr>
            <?php } ?>
        </ul>
    </div>
</div>

<?php   //评论表单 ?>
<?= Html::beginForm(['comment/add', 'id' => $blog->id], 'post') ?>
    <h4>输入评论内容</h4>
<?= \yidashi\markdown\Markdown::widget(['name' => 'comment', 'language' => 'zh'])?>
    <br>
<?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>

<?= Html::endForm() ?>


<?php   //回复表单 ?>
<div class="hidden" id="reply" style="margin-left:30px;">
    <br>
    <?= Html::beginForm(['reply/add'], 'post') ?>
<?= Html::hiddenInput('comment_id', 0, ['id' => 'comment_id']);?>
<?= \yidashi\markdown\Markdown::widget(['name' => 'reply', 'language' => 'zh'])?>
        <br>
    <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>

<?= Html::endForm() ?>
</div>


<script type="text/javascript">
    function reply(reply,comment_id){           //显示回复内容输入框，参数为该元素，和评论id
        $('#comment_id').val(comment_id);  //修该表单  comment_id 的值为该评论的 id
        $('#reply').removeClass('hidden');   //显示回复输入框
        $(reply).after($('#reply'));  //将回复框移到该元素之后

    }
</script>
