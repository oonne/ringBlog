<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use common\models\Category;

NavBar::begin([
    'brandLabel' => Yii::$app->params['blogName'],
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top ring-nav',
    ],
]);


// 导航
$menuItems = [];
// array_push($menuItems, ['label' => '全部', 'url' => ['/site/index']]);
$categories = Category::getCategoryList();
foreach($categories as $category){
    $category_name = $category['category_name'];
    $category_id = $category['id'];
    array_push($menuItems, ['label' => $category_name, 'url' => ['/site/category', 'id' => $category_id] ]);
};
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => $menuItems,
]);

// 搜索框
$req = Yii::$app->request->get();
$word = array_key_exists('word', $req) ? $req['word'] : '';
$placeholder = Yii::$app->params['xunSearch'] ? '全文搜索' : '标题搜索';

echo Html::beginForm(['/site/search'], 'get', ['class' => 'navbar-form navbar-right input-group ring-search']);
echo Html::input('text', 'word', $word, ['placeholder' => $placeholder, 'class' => 'form-control ring-search-word']);
echo Html::tag('span', Html::submitInput('搜索', ['class' => 'btn btn-default']), ['class' => 'input-group-btn']);
echo Html::endForm();


NavBar::end();

?>