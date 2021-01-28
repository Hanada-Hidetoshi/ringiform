<?php
session_start();
require_once('function2.php');
if(!isset($_SESSION['user'])){
  header("Location:login.php");
  exit;
}else{
  if($_SESSION['user']==='スーパーユーザー'){
    $superuser=1;
    $dbc = new Dbc();
    $dbc ->tablename = 'ringi_info';
    $result = $dbc ->getAlldata();
  }else{
    $dbc = new Dbc();
    $dbc ->tablename = 'ringi_info';
    $result = $dbc ->getUserdata($_SESSION['user']);
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/ringidata.js"></script>
    <title>登録済みデータ</title>
  </head>
  <body>
    <?php $pagetitle='登録済みデータ'; require_once('header.php');?>
    <table>
      <tr>
        <th>申請者</th>
        <th>申請日</th>
        <th>申請部署</th>
        <th>申請タイトル</th>
        <th>ステータス</th>
        <th>詳細確認</th>
        <?php if($superuser===1){?>
        <th>ステータス変更</th>
        <th>削除</th>
        <?php } ?>
      </tr>
      <?php foreach($result as $loop){?>
      <tr>
        <td><?php echo $loop['name']?></td>
        <td><?php echo $loop['date']?></td>
        <td><?php echo $loop['department']?></td>
        <td><?php echo $loop['title']?></td>
        <td><?php if($loop['status']===null){
                    echo '未承認';
                  }else{
                    echo $loop['status'];}?></td>
        <td><?php echo "<a href=shinsei.php?detail&id=".$loop['id'].">詳細</a>"?></td>
        <?php if($superuser===1){?>
        <td><?php echo "<a href=shinsei.php?change&id=".$loop['id'].">変更</a>"?></td>
        <td><?php echo "<a href class='delete' data-id=".$loop['id'].">削除</button>"?></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </table>
  </body>
</html>
