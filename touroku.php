<?php
session_start();
require_once('function.php');
$bom = hex2bin('EFBBBF');
$results = preg_replace("/^{$bom}/", '', $str);
$error =[];
$confirmbutton='';

$subject = $_SERVER['REQUEST_URI'];
//DBで変更を押した時
if(preg_match('/change/',$subject)){
  $confirmbutton=2;
  $dbc = new Dbc();
  $dbc ->tablename = 'user_info';
  $result = $dbc ->getdata();
  if($_SERVER['REQUEST_METHOD'] ==='POST'){
    $confirmbutton = 3;
    $post = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
    $name = htmlspecialchars($post['name']);
    $mail = htmlspecialchars($post['mail']);
    $user_id = htmlspecialchars($post['user_id']);
    $password = htmlspecialchars($post['password']);
  }
  //通常画面描画
}elseif($_SERVER['REQUEST_METHOD'] ==='POST'){
  $post = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
  $name = htmlspecialchars($post['name']);
  $mail = htmlspecialchars($post['mail']);
  $user_id = htmlspecialchars($post['user_id']);
  $password = htmlspecialchars($post['password']);
  if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
    $error['mail'] = 'error';
  }
  if(mb_strlen($password)<8){
    $error['password'] = 'error';
  }
  if(count($error) === 0){
    $confirmbutton = 1;
  }
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
<?php if ($confirmbutton === ''){// 通常画面描画?>
    <title>新規登録</title>
  </head>
  <body>
    <?php $pagetitle='新規登録'; require_once('header.php');?>
    <div class="main">
      <div class="wrapper">
        <form action="touroku.php" method="post" name="form" id="sendform">
          <h1 class="contact-title">下記の内容で新規登録します</h1>
          <div class="container">
            <div id="errorText"></div>
            <div>
              <label>　　　氏名<span class="required">必須</span></label>
              <input type="text" name="name" placeholder="例）山田太郎" value="<?php echo $name; ?>" id="form1">
            </div>
            <div>
              <label>メールアドレス<span class="required">必須</span></label>
                <?php if ($error['mail'] === 'error'){?>
                  <p style="color:red">※メールアドレスの形式が違います</p>
                <?php } ?>
              <input type="email" name="mail" placeholder="例）xxxx@example.com" value="<?php echo $mail; ?>" id="form2">
            </div>
            <div>
              <label>ユーザーID<span class="required">必須</span></label>
              <input type="text" name="user_id" placeholder="例）taro.yamada" value="<?php echo $user_id; ?>" id="form3">
            </div>
            <div>
              <label>パスワード<span class="required">必須</span></label>
                <?php if ($error['password'] === 'error'){?>
                  <p style="color:red;">※パスワードは8文字以上で入力してください</p>
                <? } ?>
              <input type="password" name="password" placeholder="8文字以上で入力" value="<?php echo $password; ?>" id="form4">
            </div>
          </div>
          <input type="button" onclick="formCheck()" value="確認画面へ">
<?php }elseif ($confirmbutton === 1){// 確認画面遷移後の画面描画?>
    <title>入力内容確認</title>
  </head>
  <body>
    <?php $pagetitle='入力内容確認'; require_once('header.php');?>
    <div class="main">
      <div class="wrapper">
        <form action="formaction.php" method="post" name="form" id="sendform">
          <h1 class="contact-title">内容に問題がなければ「送信する」をおしてください</h1>
          <div class="container">
            <div>
              <label>　　　氏名</label>
              <input type="hidden" name="name" value="<?php echo $name; ?>">
              <p><?php echo $name; ?><p>
            </div>
            <div>
              <label>メールアドレス</label>
              <input type="hidden" name="mail" value="<?php echo $mail; ?>">
              <p><?php echo $mail; ?><p>
            </div>
            <div>
              <label>ユーザーID</label>
              <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
              <p><?php echo $user_id; ?><p>
            </div>
            <div>
              <label>パスワード</label>
              <input type="hidden" name="password" value="<?php echo $password; ?>">
              <p><?php echo $password; ?><p>
            </div>
          </div>
          <input type="button" value="内容を修正する" onclick="history.back(-1)">
          <button type="submit" name="submit">送信する</button>
<?php }elseif($confirmbutton === 2){//編集画面描画?>
      <title>登録内容編集</title>
  </head>
  <body>
    <?php $pagetitle='登録内容編集'; require_once('header.php');?>
    <div class="main">
      <div class="wrapper">
        <form action=<?php echo "touroku.php?change&id=".$result['id'] ?> method="post" name="form" id="sendform">
          <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
          <h1 class="contact-title">下記の登録情報を変更します</h1>
          <div class="container">
            <div id="errorText"></div>
            <div>
              <label>　　　氏名<span class="required">必須</span></label>
              <input type="text" name="name" placeholder="例）山田太郎" value="<?php echo $result['name']; ?>" id="form1">
            </div>
            <div>
              <label>メールアドレス<span class="required">必須</span></label>
              <input type="email" name="mail" placeholder="例）xxxx@example.com" value="<?php echo $result['mail']; ?>" id="form2">
            </div>
            <div>
              <label>ユーザーID<span class="required">必須</span></label>
              <input type="text" name="user_id" placeholder="例）taro.yamada" value="<?php echo $result['user_id']; ?>" id="form3">
            </div>
            <div>
              <label>パスワード<span class="required">必須</span></label>
              <input type="password" name="password" placeholder="8文字以上で入力" value="<?php echo $result['password']; ?>" id="form4">
            </div>
          </div>
          <input type="button" onclick="formCheck()" value="内容変更確認へ">
<?php }elseif($confirmbutton === 3){//登録内容削除画面描画?>
      <title>登録内容編集</title>
  </head>
  <body>
    <?php $pagetitle='登録内容編集'; require_once('header.php');?>
    <div class="main">
      <div class="wrapper">
        <form action=<?php echo "formaction.php?change&id=".$result['id'] ?> method="post" name="form" id="sendform">
          <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
          <h1 class="contact-title">内容に問題がなければ「変更する」をおしてください</h1>
          <div Class="container">
            <div id="errorText"></div>
            <div>
              <label>　　　氏名</label>
              <input type="hidden" name="name"  value="<?php echo $post['name']; ?>">
              <p><?php echo $post['name']; ?><p>
            </div>
            <div>
              <label>メールアドレス</label>
              <input type="hidden" name="mail" value="<?php echo $post['mail']; ?>">
              <p><?php echo $post['mail']; ?><p>
            </div>
            <div>
              <label>ユーザーID</label>
              <input type="hidden" name="user_id" value="<?php echo $post['user_id']; ?>">
              <p><?php echo $post['user_id']; ?><p>
            </div>
            <div>
              <label>パスワード</label>
                <input type="hidden" name="password"  value="<?php echo $post['password']; ?>">
              <p><?php echo $post['password']; ?><p>
            </div>
          </div>
          <input type="button" value="キャンセル" onclick="history.back(-1)">
          <button type="submit" name="change">変更する</button>
<?php }?>
        </form>
      </div>
    </div>
  </body>
</html>
