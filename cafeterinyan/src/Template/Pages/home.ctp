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
    <?= $this->Html->css('cafehome.css') ?>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
<body class="home">

<header class="row">
</header>
<?php

$conn = "host=localhost port=5432 dbname=team5db user=team5 password=hogenyan";
$link = pg_connect($conn);
if (!$link) {
    die('接続失敗です。'.pg_last_error());
}
$hogehogenyan = '2019-07-24'
?>

<?php
    $port = $_SERVER['SERVER_PORT'];
?>

<?php
    $checkjosetsu = pg_query_params($link, 'SELECT id, date, likes FROM daily_menu WHERE id >= 50 AND id <=57', array());
    for($cjs = pg_fetch_array($checkjosetsu); $cjs != NULL; $cjs = pg_fetch_array($checkjosetsu)) {
        if($cjs[1] != array(date("Y-m-d"))){
            $setd = sprintf("UPDATE daily_menu SET date = '%s',sold = %d WHERE id = %d", date("Y-m-d"), 1, $cjs[0]);
            pg_query($link, $setd);
        }
    }
?>

<div class="today-title-wrapper">
    <div class="todayAB-title">今日のAセット</div>
    <div class="todayAB-title">今日のBセット</div>
</div>
<div class="todayAB">
    <div class="today todayA">
        <?php
            $ta = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id, sold FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 0 ', array($hogehogenyan));//date("Y-m-d")));
            $taarr = pg_fetch_array($ta);
        ?>
        <div class="today-title"><?php echo $taarr[0] ?></div>
        <img src="<?php echo $taarr[1] ?>" class="today-img">
        <a class="today-link" href="http://172.16.16.7:<?php echo $port ?>/test?id=<?php echo $taarr[3] ?>"></a>
        <div class="iine-wrapper">
            <div class="iine-box iine-box-right">
                <div class="iine"><ion-icon name="heart" class="heart"></ion-icon><?php echo $taarr[2] ?></div>
            </div>
        </div>
        <div class="sold-wrapper <?php $taarr[4] ? null : print 'gray-filter' ?>">
	        <div class="today-sold <?php $taarr[4] ? null : print 'sold' ?>">売り切れ</div>
        </div>
    </div>
    <div class="today">
        <?php
            $tb = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id, sold FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 1 ', array($hogehogenyan));//date("Y-m-d")));
            $tbbrr = pg_fetch_array($tb);
        ?>
        <div class="today-title"><?php echo $tbbrr[0] ?></div>
        <img src="<?php echo $tbbrr[1] ?>" class="today-img">
        <a class="today-link" href="http://172.16.16.7:<?php echo $port ?>/test?id=<?php echo $tbbrr[3] ?>"></a>
        <div class="iine-wrapper">
            <div class="iine-box">
                <div class="iine"><ion-icon name="heart" class="heart"></ion-icon><?php echo $tbbrr[2] ?></div>
            </div>
        </div>
        <div class="sold-wrapper <?php $tbbrr[4] ? null : print 'gray-filter' ?>">
            <div class="today-sold <?php $tbbrr[4] ? null : print 'sold' ?>">売り切れ</div>
        </div>
    </div>
</div>
<div class="josetsu">
    <div class="title-wrapper">
        <div class="single-title">常設メニュー</div>
    </div>
    <div class="josetsu-content-wrapper">
        <div class="josetu-content-upper">
            <?php
                $js = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id, sold FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 2 ', array(date("Y-m-d")));
            ?>
            <?php for($jo = pg_fetch_array($js); $jo != NULL; $jo = pg_fetch_array($js)) { ?>
                <div class="josetsu-content">
                    <div class="josetsu-name"><?php echo $jo[0] ?></div>
                    <a href="http://172.16.16.7:<?php echo $port ?>/test?id=<?php echo $jo[3] ?>"><img src="<?php echo $jo[1] ?>" class="josetsu_img"></a>
                    <div class="iine"><?php echo $jo[2] ?></div>
                    <div class="josetsu_so">売り切れ</div>
                </div>
            <?php } ?>
        </div>
        <?php if(date("m-d") >= "06-01" && date("m-d") <= "10-31") { ?>
            <div class="josetu-content-under">
                <?php
                    $kjs = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id, sold FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 3 ', array(date("Y-m-d")));
                ?>
                <?php for($kjo = pg_fetch_array($kjs); $kjo != NULL; $kjo = pg_fetch_array($kjs)) { ?>
                    <div class="josetsu-content">
                        <div class="josetsu-name"><?php echo $kjo[0] ?></div>
                        <a href="http://172.16.16.7:<?php echo $port ?>/test?id=<?php echo $kjo[3] ?>"><img src="<?php echo $kjo[1] ?>" class="josetsu_img"></a>
                        <div class="iine"><?php echo $kjo[2] ?></div>
                        <div class="josetsu_so">売り切れ</div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
<div class="weeklyAB">
    <div class="title-wrapper">
        <div class="single-title">今週のメニュー</div>
    </div>
    <div class="weeklyA">
        <?php for($i = 1; $i < 5; $i++) { ?>
            <?php
                $time_passed['send_time'] = $i;
                $time = "+" . $time_passed['send_time'] . "day";
                $wa = pg_query_params($link, 'SELECT name, image likes, daily_menu.id, sold FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 0 ', array(date("Y-m-d", strtotime($time))));
                $wawa = pg_fetch_array($wa);
            ?>
            <div class="weeklyA_name"><?php echo $wawa[0] ?></div>
            <a href="http://172.16.16.7:<?php echo $port ?>/test?id=<?php echo $wawa[3] ?>">
                <img src="<?php echo $wawa[1] ?>" class="weeklyA_img">
            </a>
            <div class="iine"><?php echo $wawa[2] ?></div>
            <div class="weeklyA_so">売り切れ</div>
        <?php } ?>
    </div>
    <div class="weeklyB">
        <?php for($i = 1; $i <= 10; $i++) { ?>
            <?php
                $time_passed['send_time'] = $i;
                $time = "+" . $time_passed['send_time'] . "day";
                $wb = pg_query_params($link, 'SELECT name, image likes, daily_menu.id, sold FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 1 ', array(date("Y-m-d", strtotime($time))));
                $wbwb = pg_fetch_array($wa);
            ?>
            <div class="weeklyB-name"><?php echo $wbwb[0] ?></div>
            <a href="http://172.16.16.7:<?php echo $port ?>/test?id=<?php echo $wbwb[3] ?>">
                <img src="<?php echo $wbwb[1] ?>" class="weeklyB_img">
            </a>
            <div class="iine"><?php echo $wbwb[2] ?></div>
            <div class="weeklyB_so">売り切れ</div>
        <?php } ?>
    </div>
</div>
</body>
</html>

<?php
// PostgreSQLに対する処理
$close_flag = pg_close($link);
?>
