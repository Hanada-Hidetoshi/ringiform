<?php
require_once('function.php');
$dbc = new Dbc();
$dbc ->tablename = 'user_info';
$result = $dbc ->getAlldata();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/database.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/database.js"></script>
    <title>登録済みデータ</title>
  </head>
  <body>
    <header>
      <div class="header">
        <h1>登録済みデータ</h1>
        <div class = "navi">
          <ul>
            <li><a href="touroku.php">新規登録</a></li>
            <li><a href="login.php">ログイン</a></li>
          </ul>
        </div>
      </div>
    </header>
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
