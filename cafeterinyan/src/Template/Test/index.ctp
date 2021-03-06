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
        'Please replace src/Template/Test/index.ctp with your own version or re-enable debug mode.'
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
    <?= $this->Html->css('index.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
<?php
$conn = "host=localhost port=5432 dbname=team5db user=team5 password=hogenyan";
$link = pg_connect($conn);
if (!$link) {
    die('接続失敗です。'.pg_last_error());
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
} else {
    $id = -1;
}
$result = pg_query_params($link,'SELECT * FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE menu_info.id = $1',array($id));
$arr = pg_fetch_array($result);

$image = mb_substr($arr[10], -1, 1, 'UTF-8') == '/' ? mb_substr($arr[10], 0, 1, 'UTF-8') : $arr[10];
$name = $arr[8];
$price = $arr[9];
$sold = $arr[2];
$likes = $arr[4];
if (isset($_GET['Lsum'])) {
    if ($_GET['Lsum'] < 100) {
        $pushLikes = (int)$_GET['Lsum'];
    } else {
        $pushLikes = 100;
    }
} else {
    $pushLikes = 0;
}
if (isset($_GET['Sold'])) {
    if ($_GET['Sold'] == 1) {
        $pushSold = (int)$_GET['Sold'];
    } else {
        $pushSold = 0;
    }
} else {
    $pushSold = 0;
}

$energy = $arr[11];
$protein = $arr[12];
$lipid = $arr[13];
$salt = $arr[14];

if($arr[1] == date("Y-m-d")){
    $today = 1;
}else{
    $today = 0;
}

$close_flag = pg_close($link);

function Update($id,$pushLikes,$pushSold){
$conn = "host=localhost port=5432 dbname=team5db user=team5 password=hogenyan";
$link = pg_connect($conn);
if (!$link) {
    die('接続失敗です。'.pg_last_error());
}
$result = pg_query_params($link, 'SELECT * FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE menu_info.id = $1', array($id));
$arr = pg_fetch_array($result);

$sold = $arr[2];
$likes = $arr[4];

if (($sold - $pushSold) == 0) {
    $temp = 0;
} else {
    $temp = 1;
}
$update = sprintf("UPDATE daily_menu SET sold = %d,likes = %d WHERE id=%d", $temp,$likes+$pushLikes,$id);
pg_query($link,$update);

$close_flag = pg_close($link);
}

if(isset($_GET['update'])){
    if($_GET['update'] == "0asdfnmasdfkasdfo9fsd"){
        Update($id,$pushLikes,$pushSold);
        header("Location: ./");
        exit;
    }
}
?>
<body class="<?php $name ? print "" : print "rainbow-background" ?>">
    <div class="header">
        <form action='' method = 'GET'>
            <input type="hidden" name="id" value="<?php echo $id;?>"/>
            <input type="hidden" name="Lsum" value="<?php echo $pushLikes;?>"/>
            <input type="hidden" name="Sold" value="<?php echo $pushSold;?>"/>
            <input type="hidden" name="update" value="0asdfnmasdfkasdfo9fsd">
            <input type="submit" value = "×" class="back-submit">
        </form>
        <svg class="back-button-icon" viewbox="0 0 100 100">
            <path class="arrow" d="M 50,0 L 60,10 L 20,50 L 60,90 L 50,100 L 0,50 Z" />
        </svg>
    </div>
    <img class="menu-image" src=<?php $name ? print $image : print "https://i1.wp.com/pronama.jp/wp-content/uploads/2016/07/stamp_01.png?ssl=1" ?> />
    <?php if ($name) { ?>
    <div class="content-text-part">
        <div class="menu-name"><?php echo $name;?></div>
        <div class="column-content">
            <div class="menu-value"><?php echo $price;?>円</div>
            <div class="iine-wrapper <?php $today == 0 ? print "invisible" : print "" ?>">
                <div class="form-title-wrapper">
                    <div class="form-title">
                        <svg class="heart" viewBox="0 0 32 29.6">
                            <path d="M23.6,0c-3.4,0-6.3,2.7-7.6,5.6C14.7,2.7,11.8,0,8.4,0C3.8,0,0,3.8,0,8.4c0,9.4,9.5,11.9,16,21.2c6.1-9.3,16-12.1,16-21.2C32,3.8,28.2,0,23.6,0z"/>
                        </svg>
                        <?php echo $likes + $pushLikes;?>
                    </div>
                </div>
                <form class="iine-form" action='' method='GET'>
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <input type="hidden" name="Lsum" value="<?php if($pushLikes < 100){echo ($pushLikes+1);}else{echo 100;}?>"/>
                    <input type="hidden" name="Sold" value="<?php echo $pushSold;?>"/>
                    <input type="submit" value="" class="status-submit"/>
                </form>
            </div>
            <div class="sold-wrapper <?php $today == 0 ? print "invisible" : print "" ?> <?php ($sold - $pushSold) == 0 ? print "sold" : print "" ?>">
                <div class="form-title-wrapper">
                    <div class="form-title sold-status"><?php ($sold - $pushSold) == 0 ? print "売り切れ中" : print "販売中" ?></div>
                </div>
                <form class="sold-form" action='' method = 'GET'>
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="hidden" name="Lsum" value="<?php echo $pushLikes; ?>" />
                    <input type="hidden" name="Sold" value="<?php if($pushSold == 0){echo 1;}else{echo 0;} ?>"/>
                    <input type="submit" value="" class="status-submit"/>
                </form>
            </div>
        </div>
        <div class="menu-status-wrapper">
            <div class="status-wrapper">
                <div class="status-name">エネルギー</div>
                <div class="status-value"><?php echo $energy;?> kcal</div>
            </div>
            <div class="status-wrapper">
                <div class="status-name">タンパク質</div>
                <div class="status-value"><?php echo $protein;?> g</div>
            </div>
            <div class="status-wrapper">
                <div class="status-name">脂質</div>
                <div class="status-value"><?php echo $lipid;?> g</div>
            </div>
            <div class="status-wrapper">
                <div class="status-name">塩分</div>
                <div class="status-value"><?php echo $salt;?> g</div>
            </div>
        </div>
    </div>
    <?php } else { ?>
    <div class="error-message">404 (Not Found)</div>
    <?php } ?>
</body>
</html>

