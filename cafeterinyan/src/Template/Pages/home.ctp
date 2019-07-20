<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->layout = false;
echo $this->Html->css(['cafehome', 'home', 'base', 'style']);

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
<?php

$conn = "host=localhost port=5432 dbname=team5db user=team5 password=hogenyan";
$link = pg_connect($conn);
if (!$link) {
    die('接続失敗です。'.pg_last_error());
}
$hogehogenyan = '2019-07-24';
$add_date = 4;
?>

<?php
    $port = $_SERVER['SERVER_PORT'];
?>

<?php
    $checkjosetsu = pg_query_params($link, 'SELECT id, date, likes FROM daily_menu WHERE id >= 50 AND id <=57', array());
    for($cjs = pg_fetch_array($checkjosetsu); $cjs != NULL; $cjs = pg_fetch_array($checkjosetsu)) {
        if($cjs[1] != date("Y-m-d")){
            $setd = sprintf("UPDATE daily_menu SET date = '%s',sold = %d WHERE id = %d", date("Y-m-d"), 1, $cjs[0]);
            pg_query($link, $setd);
        }
    }
?>
<div class="todayAB">
    <div class="today">
        <?php
            $ta = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id, sold FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 0 ', array($hogehogenyan));//date("Y-m-d")));
            $taarr = pg_fetch_array($ta);
        ?>
        <div class="today-title"><?php mb_strlen($taarr[0], 'UTF-8') >= 10 ? print mb_substr($taarr[0], 0, 9, 'UTF-8') . '...' : print $taarr[0] ?></div>
        <img src="<?php echo $taarr[1] ?>" class="today-img <?php $taarr[4] == 1 ? null : print 'gray-filter' ?>">
        <a class="link cover-content" href="http://172.16.16.7:<?php echo $port ?>/test?id=<?php echo $taarr[3] ?>"></a>
        <div class="iine-wrapper cover-content">
            <div class="iine-box">
                <div class="iine">
                    <ion-icon name="heart" class="heart"></ion-icon>
                    <div class="iine-number"><?php echo $taarr[2] ?></div>
                </div>
            </div>
        </div>
        <div class="sold-wrapper cover-content">
	        <div class="today-sold <?php $taarr[4] == 1 ? null : print 'sold' ?>">売り切れ</div>
        </div>
    </div>
    <div class="today">
        <?php
            $tb = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id, sold FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 1 ', array($hogehogenyan));//date("Y-m-d")));
            $tbbrr = pg_fetch_array($tb);
        ?>
        <div class="today-title"><?php mb_strlen($tbbrr[0], 'UTF-8') >= 10 ? print mb_substr($tbbrr[0], 0, 9, 'UTF-8') . '...' : print $tbbrr[0] ?></div>
        <img src="<?php echo $tbbrr[1] ?>" class="today-img <?php $tbbrr[4] == 1 ? null : print 'gray-filter' ?>">
        <a class="link cover-content" href="http://172.16.16.7:<?php echo $port ?>/test?id=<?php echo $tbbrr[3] ?>"></a>
        <div class="iine-wrapper cover-content">
            <div class="iine-box">
                <div class="iine">
                    <ion-icon name="heart" class="heart"></ion-icon>
                    <div class="iine-number"><?php echo $tbbrr[2] ?></div>
                </div>
            </div>
        </div>
        <div class="sold-wrapper cover-content">
            <div class="today-sold <?php $tbbrr[4] == 1 ? null : print 'sold' ?>">売り切れ</div>
        </div>
    </div>
</div>
<div class="josetsu">
    <div class="title-wrapper">
        <div class="single-title">常設メニュー</div>
    </div>
    <div class="other-content-wrapper">
        <div class="other-content-upper">
            <?php
                $js = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id, sold FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 2 ORDER BY daily_menu.id', array(date("Y-m-d")));
            ?>
            <?php for($jo = pg_fetch_array($js); $jo != NULL; $jo = pg_fetch_array($js)) { ?>
            <div class="other-content">
                <div class="other-name"><?php mb_strlen($jo[0], 'UTF-8') >= 7 ? print mb_substr($jo[0], 0, 7, 'UTF-8') . '...' : print $jo[0] ?></div>
                <img src="<?php echo $jo[1] ?>" class="today-img <?php $jo[4] == 1 ? null : print 'gray-filter' ?>"/>
                <a class="link cover-content" href="http://172.16.16.7:<?php echo $port ?>/test?id=<?php echo $jo[3] ?>"></a>
                <div class="iine-wrapper cover-content">
                    <div class="other-iine-box">
                        <div class="other-iine"><ion-icon name="heart" class="other-heart"></ion-icon><?php echo $jo[2] ?></div>
                    </div>
                </div>
                <div class="sold-wrapper cover-content">
                    <div class="other-sold <?php $jo[4] == 1 ? null : print 'sold' ?>">売り切れ</div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php if(date("m-d") >= "06-01" && date("m-d") <= "10-31") { ?>
            <div class="other-content-under">
                <?php
                    $kjs = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id, sold FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 3  ORDER BY daily_menu.id', array(date("Y-m-d")));
                ?>
                <?php for($kjo = pg_fetch_array($kjs); $kjo != NULL; $kjo = pg_fetch_array($kjs)) { ?>
                    <div class="other-content">
                        <div class="other-name"><?php mb_strlen($kjo[0], 'UTF-8') >= 7 ? print mb_substr($kjo[0], 0, 7, 'UTF-8') . '...' : print $kjo[0] ?></div>
                        <img src="<?php echo $kjo[1] ?>" class="today-img <?php $kjo[4] == 1 ? null : print 'gray-filter' ?>"/>
                        <a class="link cover-content" href="http://172.16.16.7:<?php echo $port ?>/test?id=<?php echo $kjo[3] ?>"></a>
                        <div class="iine-wrapper cover-content">
                            <div class="other-iine-box">
                                <div class="other-iine"><ion-icon name="heart" class="other-heart"></ion-icon><?php echo $kjo[2] ?></div>
                            </div>
                        </div>
                        <div class="sold-wrapper cover-content">
                            <div class="other-sold <?php $kjo[4] == 1 ? null : print 'sold' ?>">売り切れ</div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
<div class="weekly">
    <div class="title-wrapper">
        <div class="single-title">今週のメニュー</div>
    </div>
    <div class="other-content-wrapper">
        <div class="weekly-date-wrapper">
            <?php for($i = 1 + $add_date, $j = 0; $i < 5 + $add_date + $j; $i++) { ?>
                <?php
                    $time_passed['send_time'] = $i;
                    $time = "+" . $time_passed['send_time'] . " day";
                    if(date("w", strtotime($time)) == (string)6 || date("w", strtotime($time)) == (string)0){
                        $j++;
                    } else {
                ?>
                    <div class="weekly-date">
                        <?php
                        $day_array = array("日", "月", "火", "水", "木", "金", "土");
                        echo (string)date("n/j", strtotime($time)) . "(" . $day_array[(integer)date("w", strtotime($time))] . ")";
                        ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="other-content-upper">
            <?php for($i = 1 + $add_date, $j = 0; $i < 5 + $add_date + $j; $i++) { ?>
                <?php
                    $time_passed['send_time'] = $i;
                    $time = "+" . $time_passed['send_time'] . " day";
                    if(date("w", strtotime($time)) == (string)6 || date("w", strtotime($time)) == (string)0){
                        $j++;
                    } else {
                        $wa = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id, sold FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 0  ORDER BY daily_menu.date', array(date("Y-m-d", strtotime($time))));
                        $wawa = pg_fetch_array($wa);
                ?>
                    <div class="other-content">
                        <div class="other-name"><?php mb_strlen($wawa[0], 'UTF-8') >= 7 ? print mb_substr($wawa[0], 0, 7, 'UTF-8') . '...' : print $wawa[0] ?></div>
                        <img src="<?php echo $wawa[1] ?>" class="today-img <?php $wawa[4] == 1 ? null : print 'gray-filter' ?>"/>
                        <a class="link cover-content" href="http://172.16.16.7:<?php echo $port ?>/test?id=<?php echo $wawa[3] ?>"></a>
                        <div class="sold-wrapper cover-content">
                            <div class="other-sold <?php $wawa[4] == 1 ? null : print 'sold' ?>">売り切れ</div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="other-content-under">
            <?php for($i = 1 + $add_date, $j = 0; $i < 5 + $add_date + $j; $i++) { ?>
                <?php
                    $time_passed['send_time'] = $i;
                    $time = "+" . $time_passed['send_time'] . " day";
                    if(date("w", strtotime($time)) == (string)6 || date("w", strtotime($time)) == (string)0){
                        $j++;
                    } else {
                        $wb = pg_query_params($link, 'SELECT name, image, likes, daily_menu.id, sold FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE date = $1 AND type = 1  ORDER BY daily_menu.date', array(date("Y-m-d", strtotime($time))));
                        $wbwb = pg_fetch_array($wb);
                ?>
                    <div class="other-content">
                        <div class="other-name"><?php mb_strlen($wbwb[0], 'UTF-8') >= 7 ? print mb_substr($wbwb[0], 0, 7, 'UTF-8') . '...' : print $wbwb[0] ?></div>
                        <img src="<?php echo $wbwb[1] ?>" class="today-img <?php $wbwb[4] == 1 ? null : print 'gray-filter' ?>"/>
                        <a class="link cover-content" href="http://172.16.16.7:<?php echo $port ?>/test?id=<?php echo $wbwb[3] ?>"></a>
                        <div class="sold-wrapper cover-content">
                            <div class="other-sold <?php $wbwb[4] == 1 ? null : print 'sold' ?>">売り切れ</div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>

<?php
// PostgreSQLに対する処理
$close_flag = pg_close($link);
?>
