<?php
session_start();
require_once('function.php');
if(!isset($_SESSION['user'])){
  header("Location:login.php");
  exit;
}else{
  if($_SESSION['user']==='スーパーユーザー'){
    $dbc = new Dbc();
    $dbc ->tablename = 'user_info';
    $result = $dbc ->getAlldata();
  }else{
    $dbc = new Dbc();
    $dbc ->tablename = 'user_info';
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
    <script src="js/database.js"></script>
    <title>登録済みデータ</title>
  </head>
  <body>
    <?php $pagetitle='登録済みデータ'; require_once('header.php');?>
    <table>
      <tr>
        <th>氏名</th>
        <th>メールアドレス</th>
        <th>ユーザーID</th>
        <th>パスワード</th>
        <th>編集</th>
        <th>削除</th>
      </tr>
      <?php foreach($result as $loop){?>
      <tr>
        <td><?php echo $loop['name']?></td>
        <td><?php echo $loop['mail']?></td>
        <td><?php echo $loop['user_id']?></td>
        <td><?php echo $loop['password']?></td>
        <td><?php echo "<a href=touroku.php?change&id=".$loop['id'].">編集</a>"?></td>
        <td><?php echo "<a href class='delete' data-id=".$loop['id'].">削除</button>"?></td>
      </tr>
      <?php }?>
    </table>
  </body>
</html>
