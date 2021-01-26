<?php
require_once('function.php');
$subject = $_SERVER['REQUEST_URI'];
$dbaction ='';

//編集時の画面描画
if(preg_match('/change/',$subject)){
  $dbaction = 1;
  $dbc = new Dbc();
  $dbc ->tablename = 'user_info';
  $dbc ->datachange();
//削除時の画面描画
// }elseif(preg_match('/delete/',$subject)){
//   $dbaction = 2;
//   $dbc = new Dbc();
//   $dbc ->tablename = 'user_info';
//   $dbc ->datadelete();
//登録時の画面描画
} else {
  $dbaction =0;
  $dbc = new Dbc();
  $dbc ->tablename = 'user_info';
  $dbc ->entry();
  $to = 'superuser@l.l';
  $title = '新しい稟議が提出されました';
  $message = '新しい稟議書が提出されました。内容を確認して対応を行ってください。'.\n.'http://hanadax.php.xdomain.jp/samurai/ringidata.php';
  $headers = 'From: from@example.com';
  mb_send_mail($to, $title, $message, headers);
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/touroku.js"></script>
<?php if($dbaction === 0){ ?>
    <title>データベース登録完了</title>
  </head>
  <body>
    <div><h1>データベース登録完了</h1></div>
    <div>
      <h1 class="contact-title">下記内容にて登録完了しました</h1>
      <div>
        <div>
          <label>氏名</label>
          <p><?php echo $_POST['name']; ?><p>
        </div>
        <div>
          <label>メールアドレス</label>
          <p><?php echo $_POST['mail']; ?><p>
        </div>
        <div>
          <label>ユーザーID</label>
          <p><?php echo $_POST['user_id']; ?><p>
        </div>
        <div>
          <label>パスワード</label>
          <p><?php echo $_POST['password']; ?><p>
        </div>
      </div>
    </div>
<?php }elseif($dbaction === 1){?>
    <title>データベース変更完了</title>
  </head>
  <body>
    <div><h1>データベース変更完了</h1></div>
    <div>
      <div>
        <h1 class="contact-title">下記内容にて変更完了しました</h1>
        <div>
          <label>氏名</label>
          <p><?php echo $_POST['name']; ?><p>
        </div>
        <div>
          <label>メールアドレス</label>
          <p><?php echo $_POST['mail']; ?><p>
        </div>
        <div>
          <label>ユーザーID</label>
          <p><?php echo $_POST['user_id']; ?><p>
        </div>
        <div>
          <label>パスワード</label>
          <p><?php echo $_POST['password']; ?><p>
        </div>
      </div>
    </div>
<?php }?>
    <div class="footer">
      <div class="navi">
        <ul>
          <li><a href="database.php">アカウント情報</a></li>
          <li><a href="ringidata.php">申請済み稟議データ</a></li>
          <li><a href="shinsei.php">稟議申請フォーム</a></li>
          <li><a href="login.php">ログイン</a></li>
          <li><a href="touroku.php">アカウント登録</a></li>
        </ul>
      </div>
    </div>
  </body>
</html>
