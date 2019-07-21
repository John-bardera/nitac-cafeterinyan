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
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>

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

$image = $arr[10];
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
        header("Location: ../");
        exit;
    }
}
?>
<body>
    <div class="header">
        <form action='' method = 'GET'>
            <input type="hidden" name="id" value="<?php echo $id;?>"/>
            <input type="hidden" name="Lsum" value="<?php echo $pushLikes;?>"/>
            <input type="hidden" name="Sold" value="<?php echo $pushSold;?>"/>
            <input type="hidden" name="update" value="0asdfnmasdfkasdfo9fsd">
            <input type="submit" value = "×" class="back-submit">
        </form>
        <div class="back-button">
            <img class="back-button-icon" src="https://img.icons8.com/metro/26/000000/back.png">
        </div>
    </div>
    <img src=<?php echo $image;?>/>
    <div class="menu-name"><?php echo $name;?></div>
    <div class="iine-wrapper">
        <form action='' method='GET'>
            <input type="hidden" name="id" value="<?php echo $id;?>"/>
            <input type="hidden" name="Lsum" value="<?php if($pushLikes < 100){echo ($pushLikes+1);}else{echo 100;}?>"/>
            <input type="hidden" name="Sold" value="<?php echo $pushSold;?>"/>
            <input type="submit" value = "超いいね : <?php echo $likes + $pushLikes;?>"/>
        </form>
    </div>
    <div class="sold-wrapper">
        <form action='' method = 'GET'>
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <input type="hidden" name="Lsum" value="<?php echo $pushLikes; ?>" />
            <input type="hidden" name="Sold" value="<?php if($pushSold == 0){echo 1;}else{echo 0;} ?>"/>
            <input type="submit" value = "販売状況 : <?php if(($sold - $pushSold) == 0){echo '売り切れ中';}else{echo '販売中';}?>"/>
        </form>
    </div>
    <div>
        <div>値段　<?php echo $price;?>円</div>
        <div>エネルギー　<?php echo $energy;?>kcal</div>
        <div>タンパク質　<?php echo $protein;?>g</div>
        <div>脂質　<?php echo $lipid;?>g</div>
        <div>塩分　<?php echo $salt;?>g</div>
    </div>
    <div class="icon-author">
    <a href="https://icons8.com/icon/39800/back">Back icon by Icons8</a>
    </div>
</body>
</html>

