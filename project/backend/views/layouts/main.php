<?php
use yii\helpers\Html;
use yii\widgets\Menu;
use backend\assets\AppAsset;
use \common\assets\SyntaxHighlighterAsset;

AppAsset::register($this);
SyntaxHighlighterAsset::register($this);
$script = <<<UEDITOR
SyntaxHighlighter.defaults['gutter'] = 'false';
SyntaxHighlighter.all();
UEDITOR;
$this->registerJs($script);

$route = Yii::$app->requestedAction->uniqueId;

$menu = [
    [
        'label' => '系统',
        'url' => '#',
        'items' => [
            'site' => ['label' => '系统信息', 'url' => ['site/index'], 'active' => in_array($route, ['site/index'])],
            'usersuper' => ['label' => '用户管理', 'url' => ['usersuper/index'], 'active' => in_array($route, ['usersuper/index', 'usersuper/create-user', 'usersuper/update-user'])],
        ]
    ],
    [
        'label' => '博客',
        'url' => '#',
        'items' => [
            'categorysuper' => ['label' => '分类管理', 'url' => ['categorysuper/index'], 'active' => in_array($route, ['categorysuper/index', 'categorysuper/create-category', 'categorysuper/update-category'])],
            'blogsuper' => ['label' => '博客管理', 'url' => ['blogsuper/index'], 'active' => in_array($route, ['blogsuper/index', 'blogsuper/create-blog', 'blogsuper/update-blog', 'blogsuper/view-blog'])],
            'recyclesuper' => ['label' => '回收站', 'url' => ['recyclesuper/index'], 'active' => in_array($route, ['recyclesuper/index'])],
        ]
    ],
];



?>

<?php $this->beginContent('@app/views/layouts/base.php'); ?>
    <div id="wrapper">
         <nav class="sidebar">
            <?= Html::a('<img src="/img/aura.png" class="logo-rotation">', Yii::$app->homeUrl, ['class' => 'sidebar-logo']) ?>
            <?= Menu::widget([
                'encodeLabels' => false,
                'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\">\n{items}\n</ul>\n",
                'options' => [
                    'class' => 'nav',
                    'id' => 'side-menu'
                ],
                'items' => $menu
            ]) ?>
        </nav>

        <div id='page-wrapper'>
            <?= $content ?>
        </div>

    </div>

<?php $this->endContent() ?>