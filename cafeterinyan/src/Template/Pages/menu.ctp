<?php 
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->layout = false;

if (!Configure::read('debug')) :
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
<a href=""></a>

</header>

<body>
    <!-- typeの後にoneclick = "url"(urlは任意)と記述することでクリックイベントの設定 -->
    <button type="button"> × </button>
    <img src="https://photos.app.goo.gl/aZKHJHqrDTA65cwd8">
    <t1>メニュー名</t1><button type="button">超いいね</button><button type="button">売り切れ</button>
    <table border="1"width="90%">
        <tr>
            <th width = "30%">値段</th> <th width = "70%">１００円</th>
            <th>エネルギー</th> <th>１００kcal</th>
            <th>タンパク質</th> <th>１００g</th>
            <th>脂質</th> <th>100g</th>
            <th>塩分</th> <th>2g</th>
        </tr>
    </table>
</body>
</html>
