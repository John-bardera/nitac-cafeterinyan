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
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</head>
<body class="home">

<header class="header">

</header>
<?php

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
<div class="todayAB">
    <div class="today todayA">
        <?php
            $ta = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 0 ', array(date("Y-m-d")));
            $taarr = pg_fetch_array($ta);
        ?>
        <div class="today-title"><?php echo $taarr[0] ?></div>
        <img src="<?php echo $taarr[1] ?>" class="today-img">
        <a href="http://172.16.16.7:8100/test?id=<?php echo $taarr[3] ?>"></a>
        <div class="iine-wrapper">
            <div class="iine-box">
                <div class="iine"><ion-icon name="heart" class="heart"></ion-icon><?php echo $taarr[2] ?></div>
            </div>
        </div>
	    <div class="today-sold">売り切れ</div>
    </div>
    <div class="today">
        <?php
            $tb = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 1 ', array(date("Y-m-d")));
            $tbbrr = pg_fetch_array($tb);
        ?>
        <div class="today-title"><?php echo $tbbrr[0] ?></div>
        <img src="<?php echo $tbbrr[1] ?>" class="today-img">
        <a href="http://172.16.16.7:8100/test?id=<?php echo $tbbrr[3] ?>"></a>
        <div class="iine-wrapper">
            <div class="iine-box">
                <div class="iine"><ion-icon name="heart" class="heart"></ion-icon><?php echo $tbbrr[2] ?></div>
            </div>
        </div>
        <div class="today-sold">売り切れ</div>
    </div>
</div>
<div class="josetsu">
    常設メニュー
    <?php
        $js = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 2 ', array(date("Y-m-d")));
    ?>
    <?php for($jo = pg_fetch_array($js); $jo != NULL; $jo = pg_fetch_array($js)) { ?>
	<div class="josetsu-name"><?php echo $jo[0] ?></div>
        <img src="<?php echo $jo[1] ?>" class="josetsu-img">
        <div class="iine"><?php echo $jo[2] ?></div>
        <div class="josetsu-so">売り切れ</div>
    <?php } ?>
</div>
<div class="weeklyAB">
    今週のメニュー
    <div class="weeklyA">
        <?php for($i = 1; $i < 5; $i++) { ?>
            <?php
                $time_passed['send_time'] = $i;
                $time = "+" . $time_passed['send_time'] . "day";
                $wa = pg_query_params($link, 'SELECT name, image likes, daily_menu.id FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 0 ', array(date("Y-m-d", strtotime($time))));
                $wawa = pg_fetch_array($wa);
            ?>
            <div class="weeklyA-name"><?php echo $wawa[0] ?></div>
            <img src="<?php echo $wawa[1] ?>" class="weeklyA-img">
            <div class="iine"><?php echo $wawa[2] ?></div>
            <div class="weeklyA-so">売り切れ</div>

        <?php } ?>
    </div>
    <div class="weeklyB">
        <?php for($i = 1; $i <= 10; $i++) { ?>
            <?php
                $time_passed['send_time'] = $i;
                $time = "+" . $time_passed['send_time'] . "day";
                $wb = pg_query_params($link, 'SELECT name, image likes, daily_menu.id FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 1 ', array(date("Y-m-d", strtotime($time))));
                $wbwb = pg_fetch_array($wa);
            ?>
            <div class="weeklyB-name"><?php echo $wbwb[0] ?></div>
            <img src="<?php echo $wbwb[1] ?>" class="weeklyB-img">
            <div class="iine"><?php echo $wbwb[2] ?></div>
            <div class="weeklyB-so">売り切れ情報</div>
        <?php } ?>
    </div>
</div>
</body>
</html>

<?php
// PostgreSQLに対する処理
$close_flag = pg_close($link);

if ($close_flag){
    print('切断に成功しました。<br>');
}
?>
