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

if(isset($_GET['id'])){
  $id = (int)$_GET['id'];
}else{
 $id = -1;
}
$result = pg_query_params($link,'SELECT * FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE menu_info.id = $1',array($id));
$arr = pg_fetch_array($result);

$image = $arr[10];
$name = $arr[8];
$price = $arr[9];
$sold = $arr[2];
$likes = $arr[4];
if(isset($_GET['Lsum'])){
 if($_GET['Lsum'] < 100){
  $pushLikes = (int)$_GET['Lsum'];
 }else{
  $pushLikes = 100;
 }
}else{
$pushLikes = 0;
}
if(isset($_GET['Sold'])){
 if($_GET['Sold'] == 1){
  $pushSold = (int)$_GET['Sold'];
 }else{
  $pushSold = 0;
 }
}else{
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
$result = pg_query_params($link,'SELECT * FROM daily_menu LEFT OUTER JOIN menu_info ON daily_menu.id = menu_info.id WHERE menu_info.id = $1',array($id));
$arr = pg_fetch_array($result);

$sold = $arr[2];
$likes = $arr[4];

if(($sold - $pushSold) == 0){
  $temp = 0;
}else{
  $temp = 1;
}
$update = sprintf("UPDATE daily_menu SET sold = %d,likes = %d WHERE id=%d",$temp,$likes+$pushLikes,$id);
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
    <form action='' method = 'GET'>
    <input type="hidden" name="id" value="<?php echo $id;?>"/>
    <input type="hidden" name="Lsum" value="<?php echo $pushLikes;?>"/>
    <input type="hidden" name="Sold" value="<?php echo $pushSold;?>"/>
    <input type="hidden" name="update" value="0asdfnmasdfkasdfo9fsd">
    <input type="submit" value = "×">
    </form>
    <img src=<?php echo $image;?> weight = width> <br>
    <t1><?php echo $name;?></t1> 
    <form action='' method='GET'>
    <input type="hidden" name="id" value="<?php echo $id;?>"/>
    <input type="hidden" name="Lsum" value="<?php if($pushLikes < 100){echo ($pushLikes+1);}else{echo 100;}?>"/>
    <input type="hidden" name="Sold" value="<?php echo $pushSold;?>"/>
    <input type="submit" value = "超いいね : <?php echo $likes + $pushLikes;?>"/>
    </form>

    <form action='' method = 'GET'>
    <input type="hidden" name="id" value="<?php echo $id;?>">
    <input type="hidden" name="Lsum" value="<?php echo $pushLikes; ?>" />    
    <input type="hidden" name="Sold" value="<?php if($pushSold == 0){echo 1;}else{echo 0;} ?>"/>
    <input type="submit" value = "販売状況 : <?php if(($sold - $pushSold) == 0){echo '売り切れ中';}else{echo '販売中';}?>"/>
    </form>
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
</body>
</html>

