<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->layout = false;
echo $this->Html->css('home');

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
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
<body class="home">

<header class="row">
</header>
<div class="todayAB">
    <div class="todayA">
        <div class="todayA_txt">今日のAメニュー</div>
        <img src="<?php ?>" class="todayA_img">
        <div class="iine"></div>
	<div class="todayA_so">売り切れ</div>
    </div>
    <div class="todayB">
        <div class="todayB_txt">今日のBメニュー</div>
        <img src="<?php ?>" class="todayB_img">
        <div class="iine"></div>
        <div class="todayB_so">売り切れ</div>
    </div>
</div>
<div class="josetsu">
    常設メニュー
    <?php for($1 = 1; $i <= 10; $i++) { ?>
        <img src="<?php ?>" class="josetsu_img">
        <div class="iine"></div>
        <div class="josetsu_so"></div>
    <?php } ?>
</div>
<div class="weeklyAB">
    今週のメニュー
    <div class="weeklyA">
        <?php for($1 = 1; $i <= 10; $i++) { ?>
            <img src="<?php ?>" class="weeklyA_img">
            <div class="iine"></div>
            <div class="weeklyA_so"></div>
        <?php } ?>
    </div>
    <div class="weeklyB">
        <?php for($1 = 1; $i <= 10; $i++) { ?>
            <img src="<?php ?>" class="weeklyB_img">
            <div class="iine"></div>
            <div class="weeklyB_so"></div>
        <?php } ?>
    </div>
</div>
</body>
</html>
