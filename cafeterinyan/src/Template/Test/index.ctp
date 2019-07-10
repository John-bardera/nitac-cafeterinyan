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

$id = $_GET['id'];

$result = pg_query_params($link,'SELECT * FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE menu_info.id = $1',array($id));
$arr = pg_fetch_array($result);

$image = $arr[10];
$name = $arr[8];
$price = $arr[9];
$sold = $arr[2];
$likes = $arr[4];
$pushSold = 0;
$pushLikes = 1114;
$energy = $arr[11];
$protein = $arr[12];
$lipid = $arr[13];
$salt = $arr[14];

$close_flag = pg_close($link);


?>
<body>
    <!-- typeの後にonclick = "url"(urlは任意)と記述することでクリックイベントの設定 -->
    <button type="submit"> × </button> <br>
    <img src=<?php echo $image;?> weight = width> <br>
    <t1><?php echo $name?></t1> 
    <button type="button" onclick="pushLikes(<?php echo $pushLikes?>)">超いいね</button>
    <button type="submit">販売状況<br> <?php if($sold == 0){echo '売り切れ';}else{echo '販売中';}?></button>
    <table border="1"width="90%">
        <tr>
            <th width = "30%">値段</th> <th width = "70%"><?php echo $price;?>円</th> <br>
        </tr>
        <tr>
            <th>エネルギー</th> <th><?php echo $energy;?>kcal</th> <br>
        </tr>
        <tr>
            <th>タンパク質</th> <th><?php echo $protein;?>g</th> <br>
        <tr>
            <th>脂質</th> <th><?php echo $lipid;?>g</th> <br>
        </tr>
        <tr>
            <th>塩分</th> <th><?php echo $salt;?>g</th> <br>
        </tr>
    </table>
    <script>
    function pushLikes(pushLkes){
       alert(pushLikes);
    }
    </script>
</body>
</html>

