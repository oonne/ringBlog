<footer class="footer">
    <div class="container">
        <p class="pull-left">
            Copyright &copy;  by <a href="http://<?= Yii::$app->params['authorUrl'] ?>" target="_blank"><?= Yii::$app->params['author'] ?></a>. All Rights Reserved.
            <?php
            if(Yii::$app->params['beian']){
                echo '<a href="http://www.miibeian.gov.cn/" target="_blank">'.Yii::$app->params['beian'].'</a>';
            }
            ?>
        </p>
        <p class="pull-right">Powered By <a href="http://blog.oonne.com" target="_blank">RingBlog</a>.</p>
    </div>
</footer>