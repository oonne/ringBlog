<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\models\Category;

NavBar::begin([
    'brandLabel' => Yii::$app->params['blogName'],
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top ring-nav',
    ],
]);

$menuItems = [];
// array_push($menuItems, ['label' => '全部', 'url' => ['/site/index']]);
$categories = Category::getCategoryList();
foreach($categories as $category){
    $category_name = $category['category_name'];
    $category_id = $category['id'];
    array_push($menuItems, ['label' => $category_name, 'url' => ['/site/category', 'id' => $category_id] ]);
};
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);

NavBar::end();

?>