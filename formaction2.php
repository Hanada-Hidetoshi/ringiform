<?php
session_start();
require_once('function2.php');
$subject = $_SERVER['REQUEST_URI'];
$dbaction ='';
//編集時の画面描画
if(preg_match('/change/',$subject)){
  $dbaction = 1;
  if(isset($_SESSION['userfile']['tmp_name'])){
    $file = $_SESSION['userfile'];
    $tmp = $file['tmp_name'];
    $filename = $file['name'];
    $uploadfile = 'uploadfile/'.$filename;
  }
  $dbc = new Dbc();
  $dbc ->tablename = 'ringi_info';
  $dbc ->datachange($uploadfile);
  //登録時の画面描画
} else {
  if(isset($_SESSION['userfile']['tmp_name'])){
    $file = $_SESSION['userfile'];
    $tmp = $file['tmp_name'];
    $filename = $file['name'];
    $uploadfile = 'uploadfile/'.$filename;
  }
  $dbaction =0;
  $dbc = new Dbc();
  $dbc ->tablename = 'ringi_info';
  $dbc ->entry($uploadfile);
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
  </body>
    <div><h1>データベース登録完了</h1></div>
    <div></div>
    <div>
      <h1 class="contact-title">下記内容にて登録完了しました</h1>
      <div>
          <div>
            <label>申請者</label>
            <p><?php echo $_POST['name']; ?><p>
          </div>
          <div>
            <label>申請日</label>
            <p><?php echo $_POST['date']; ?><p>
          </div>
          <div>
            <label>申請部署</label>
            <p><?php echo $_POST['department']; ?><p>
          </div>
          <div>
            <label>申請タイトル</label>
            <p><?php echo $_POST['title']; ?><p>
          </div>
          <div>
            <label>申請内容</label>
            <p><?php echo $_POST['content']; ?><p>
          </div>
          <div>
            <label>添付ファイル</label>
            <?php if(isset($_SESSION['userfile']['tmp_name'])){?>
            <p><?php echo $filename; ?></p>
            <?php }else{?>
            <p><?php echo "ファイルの添付はありません"; ?></p>
            <?php }?>
          </div>
        </div>
    </div>
  </body>
<?php }elseif($dbaction === 1){?>
    <title>データベース変更完了</title>
  </head>
  </body>
    <div><h1>データベース変更完了</h1></div>
    <div></div>
    <div>
      <h1 class="contact-title">下記内容にて変更完了しました</h1>
      <div>
          <div>
            <label>申請者</label>
            <p><?php echo $_POST['name']; ?><p>
          </div>
          <div>
            <label>申請日</label>
            <p><?php echo $_POST['date']; ?><p>
          </div>
          <div>
            <label>申請部署</label>
            <p><?php echo $_POST['department']; ?><p>
          </div>
          <div>
            <label>申請タイトル</label>
            <p><?php echo $_POST['title']; ?><p>
          </div>
          <div>
            <label>申請内容</label>
            <p><?php echo nl2br($_POST['content']); ?><p>
          </div>
          <div>
            <label>添付ファイル</label>
            <?php if(isset($_SESSION['userfile']['tmp_name'])){?>
            <p><?php echo $filename; ?></p>
            <?php }else{?>
            <p><?php echo "ファイルの添付はありません"; ?></p>
            <?php }?>
          </div>
        </div>
    </div>
  </body>
<?php }?>
</html>
