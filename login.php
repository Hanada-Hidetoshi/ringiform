<?php
session_start();
require_once('function.php');
$bom = hex2bin('EFBBBF');
$result = preg_replace("/^{$bom}/", '', $str);
$error =[];
$loginerror = '';
$_SESSION = array();
if($_SERVER['REQUEST_METHOD'] =='POST'){
  $post = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
  $user_id = htmlspecialchars($post['user_id']);
  $password = htmlspecialchars($post['password']);
  if(mb_strlen($password)<8){
    $error['password'] = 'error';
  }
  if(count($error) === 0){
    $dbc = new Dbc();
    $dbc ->tablename = 'user_info';
    $result = $dbc ->login($user_id,$password);
    foreach ($result as $row) {
      if (!isset($row['user_id'])) {
        $loginerror = 1;
        return false;
      }else{
        $_SESSION['user'] = $row['name'];
        header('location:shinsei.php');
      }
    }
  }
}else{
  if(isset($_SESSION['form'])){
    $post = $_SESSION['form'];
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
    <script src="js/login.js"></script>
    <title>ログインページ</title>
  </head>
  <body>
    <div><h1>ログインページ</h1></div>
    <div>
      <form action="login.php" method="post" name="form" id="sendform">
        <div>
          <div id="errorText">
          <?php if($loginerror === 1){
            echo 'ユーザーIDまたはパスワードが間違っています';
          } ?>
          </div>
          <div>
            <label>ユーザーID<span class="required">必須</span></label>
            <input type="text" name="user_id" placeholder="例）taro.yamada" value="<?php echo $user_id; ?>" id="form1">
          </div>
          <div>
            <label>パスワード<span class="required">必須</span></label>
            <?php if ($error['password'] === 'error'):?>
              <p style="color:red">※パスワードは8文字以上で入力してください</p>
            <? endif; ?>
            <input type="password" name="password" placeholder="8文字以上で入力" value="<?php echo $password; ?>" id="form2">
          </div>
        </div>
        <input type="button" onclick="formCheck()" value="ログイン">
      </form>
    </div>
  </body>
</html>
