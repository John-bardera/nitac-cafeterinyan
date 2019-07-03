<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->layout = false;

if (!Configure::read('debug')):
    throw new NotFoundException(
        'Please replace src/Template/Pages/home.ctp with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'CakePHP: the rapid development PHP framework';
?>
<!DOCTYPE html>

<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('home.css') ?>
    <?= $this->Html->css('cafehome.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
<body class="home">

<header class="row">
</header>
<!--<?php

$conn = "host=localhost port=5432 dbname=team5db user=team5 password=hogenyan";
$link = pg_connect($conn);
if (!$link) {
    die('接続失敗です。'.pg_last_error());
}

print('接続に成功しました。<br>');

$result = pg_query_params($link, 'SELECT image FROM menu_info WHERE id = $1', array("-1"));
$arr = pg_fetch_array($result);
?>
<div><?php echo $arr[0]; ?></div>
<?php
// PostgreSQLに対する処理
$close_flag = pg_close($link);

if ($close_flag){
    print('切断に成功しました。<br>');
}
?>-->
<div class="todayAB">
    <div class="today todayA">
        <div class="today-title">今日のAセット</div>
        <img src="./img/sample.jpg" class="today-img">
        <div class="iine-wrapper">
            <div class="iine-box">
                <div class="iine"><span class="entypo-heart"></span>hoge</div>
            </div>
        </div>
        <div class="today-sold">売り切れ</div>
    </div>
    <div class="today">
        <div class="today-title">今日のBセット</div>
        <img src="./img/sample.jpg" class="today-img">
        <div class="iine-wrapper">
            <div class="iine-box">
                <div class="iine"><span class="entypo-heart"></span>hoge</div>
            </div>
        </div>
        <div class="today-sold">売り切れ</div>
    </div>
</div>
<div class="josetsu">
    常設メニュー
    <?php for($i = 1; $i <= 10; $i++) { ?>
        <img src="<?php ?>" class="josetsu-img">
        <div class="iine"></div>
        <div class="josetsu-so"></div>
    <?php } ?>
</div>
<div class="weeklyAB">
    今週のメニュー
    <div class="weeklyA">
        <?php for($i = 1; $i <= 10; $i++) { ?>
            <img src="<?php ?>" class="weeklyA-img">
            <div class="iine"></div>
            <div class="weeklyA-so"></div>
        <?php } ?>
    </div>
    <div class="weeklyB">
        <?php for($i = 1; $i <= 10; $i++) { ?>
            <img src="<?php ?>" class="weeklyB-img">
            <div class="iine"></div>
            <div class="weeklyB-so"></div>
        <?php } ?>
    </div>
</div>
</body>
</html>
