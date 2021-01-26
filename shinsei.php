<?php
session_start();
require_once('function2.php');
$bom = hex2bin('EFBBBF');
$results = preg_replace("/^{$bom}/", '', $str);
$confirm =[];
$confirmbutton = '';
$subject = $_SERVER['REQUEST_URI'];
if(!isset($_SESSION['user'])){
  header("Location:login.php");
  exit;
}else{
  if(preg_match('/detail/',$subject)){
    $confirmbutton=2;
    $dbc = new Dbc();
    $dbc ->tablename = 'ringi_info';
    $result = $dbc ->getdata();
    if($_SERVER['REQUEST_METHOD'] ==='POST'){
      $confirmbutton = 3;
      $post = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
      $name = htmlspecialchars($post['name']);
      $date = htmlspecialchars($post['date']);
      $department = htmlspecialchars($post['department']);
      $title = htmlspecialchars($post['title']);
      $content = htmlspecialchars($post['content']);
      $file = $_FILES['userfile'];
      $tmp = $file['tmp_name'];
      $filename = $file['name'];
      $directory = 'uploadfile/'.$filename;
      if(is_uploaded_file($tmp)){
        move_uploaded_file($tmp,$directory);
        $_SESSION['userfile'] = $_FILES['userfile'];
      }
    }
  }elseif($_SERVER['REQUEST_METHOD'] =='POST'){
    $confirmbutton = 1;
    $post = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
    $name = htmlspecialchars($post['name']);
    $date = htmlspecialchars($post['date']);
    $department = htmlspecialchars($post['department']);
    $title = htmlspecialchars($post['title']);
    $content = htmlspecialchars($post['content']);
    $file = $_FILES['userfile'];
    $tmp = $file['tmp_name'];
    $filename = $file['name'];
    $directory = 'uploadfile/'.$filename;
    if(is_uploaded_file($tmp)){
      move_uploaded_file($tmp,$directory);
      $_SESSION['userfile'] = $_FILES['userfile'];
    }
  }elseif(preg_match('/change/',$subject)){
    $confirmbutton=4;
    $dbc = new Dbc();
    $dbc ->tablename = 'ringi_info';
    $result = $dbc ->getdata();
    $post = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
    $name = htmlspecialchars($post['name']);
    $date = htmlspecialchars($post['date']);
    $department = htmlspecialchars($post['department']);
    $title = htmlspecialchars($post['title']);
    $content = htmlspecialchars($post['content']);
    $file = $post['file'];
    $status = $post['status'];
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
    <script src="js/shinsei.js"></script>
    <title>稟議申請フォーム</title>
  </head>
  <body>
    <div><h1>稟議申請フォーム</h1></div>
<?php if ($confirmbutton === ''){?>
    <div>
      <form action="shinsei.php" method="post" name="form" id="sendform" enctype="multipart/form-data">
        <h1 class="contact-title">内容入力</h1>
        <div>
          <div id="errorText"></div>
          <div>
            <label>申請者<span class="required">必須</span></label>
            <input type="text" name="name" placeholder="例）山田太郎" value="<?php echo $_SESSION['user']; ?>" id="form1">
          </div>
          <div>
            <label>申請日<span class="required">必須</span></label>
            <input type="date" name="date" value="<?php echo $date; ?>" id="form2">
          </div>
          <div>
            <label>申請部署<span class="required">必須</span></label>
            <select name="department" id="form3">
              <option><?php echo $department; ?></option>
              <option>営業部</option>
              <option>事務部</option>
              <option>経理部</option>
            </select>
          </div>
          <div>
            <label>申請タイトル<span class="required">必須</span></label>
            <input type="text" name="title" placeholder="タイトルを入力してください" value="<?php echo $title; ?>" id="form4">
          </div>
          <div>
            <label>申請内容<span class="required">必須</span></label>
            <textarea name="content" id="form5" placeholder="内容を入力してください" style="height:300px" cols="50" rows="30"><?php echo nl2br($content); ?></textarea>
          </div>
          <div>
            <label>添付ファイル<span class="option">任意</span></label>
            <input type="file" name="userfile">
          </div>
        </div>
        <input type="button" onclick="formCheck()" value="確認画面へ">
<?php }elseif ($confirmbutton === 1){?>
    <div>
      <form action="formaction2.php" method="post" name="form" id="sendform" enctype="multipart/form-data">
        <h1 class="contact-title">内容入力</h1>
        <div>
          <div>
            <label>申請者</label>
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <p><?php echo $name; ?><p>
          </div>
          <div>
            <label>申請日</label>
            <input type="hidden" name="date" value="<?php echo $date; ?>">
            <p><?php echo $date; ?><p>
          </div>
          <div>
            <label>申請部署</label>
            <input type="hidden" name="department" value="<?php echo $department; ?>">
            <p><?php echo $department; ?><p>
          </div>
          <div>
            <label>申請タイトル</label>
            <input type="hidden" name="title" value="<?php echo $title; ?>">
            <p><?php echo $title; ?><p>
          </div>
          <div>
            <label>申請内容</label>
            <textarea style="display:none" name="content"><?php echo $content; ?></textarea>
            <p><?php echo nl2br($content); ?><p>
          </div>
          <div>
            <label>添付ファイル</label>
            <input type="hidden" name="userfile[]" value="<?php echo $file; ?>">
            <?php if($file['tmp_name'] !== ''){?>
            <p><?php echo $file['name']; ?></p>
            <?php }else{?>
            <p><?php echo "ファイルの添付はありません"; ?></p>
            <?php }?>
          </div>
        </div>
        <input type="button" value="内容を修正する" onclick="history.back(-1)">
        <button type="submit">送信する</button>
<?php }elseif ($confirmbutton === 2){?>
    <div>
      <form action=<?php echo "shinsei.php?detail&id=".$result['id'] ?> method="post" name="form" id="sendform" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
        <h1 class="contact-title">申請済み稟議確認</h1>
        <div>
          <div>
            <label>申請者</label>
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <p><?php echo $result['name']; ?><p>
          </div>
          <div>
            <label>申請日</label>
            <input type="hidden" name="date" value="<?php echo $date; ?>">
            <p><?php echo $result['date']; ?><p>
          </div>
          <div>
            <label>申請部署</label>
            <input type="hidden" name="department" value="<?php echo $department; ?>">
            <p><?php echo $result['department']; ?><p>
          </div>
          <div>
            <label>申請タイトル</label>
            <input type="hidden" name="title" value="<?php echo $title; ?>">
            <p><?php echo $result['title']; ?><p>
          </div>
          <div>
            <label>申請内容</label>
            <textarea style="display:none" name="content"><?php echo $content; ?></textarea>
            <p><?php echo $result['content']; ?><p>
          </div>
          <div>
            <label>添付ファイル</label>
            <input type="hidden" name="userfile[]" value="<?php echo $file; ?>">
            <?php if($result['file'] !==''){?>
            <a href="uploadfile/<?php echo $result['file']; ?>"><?php echo $result['file']; ?></a>
            <?php }else{?>
            <p><?php echo "ファイルの添付はありません"; ?></p>
            <?php }?>
          </div>
        </div>
        <button type="submit">修正する</button>
<?php }elseif ($confirmbutton === 3){?>
    <div>
      <form action=<?php echo "formaction2.php?change&id=".$result['id'] ?> method="post" name="form" id="sendform" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
        <h1 class="contact-title">申請済み稟議確認</h1>
        <div>
          <div>
            <label>申請者<span class="required">必須</span></label>
            <input type="text" name="name" placeholder="例）山田太郎" value="<?php echo $result['name']; ?>" id="form1">
          </div>
          <div>
            <label>申請日<span class="required">必須</span></label>
            <input type="date" name="date" value="<?php echo $result['date']; ?>" id="form2">
          </div>
          <div>
            <label>申請部署<span class="required">必須</span></label>
            <select name="department" id="form3">
              <option><?php echo $result['department']; ?></option>
              <option>営業部</option>
              <option>事務部</option>
              <option>経理部</option>
            </select>
          </div>
          <div>
            <label>申請タイトル<span class="required">必須</span></label>
            <input type="text" name="title" placeholder="タイトルを入力してください" value="<?php echo $result['title']; ?>" id="form4">
          </div>
          <div>
            <label>申請内容<span class="required">必須</span></label>
            <textarea name="content" id="form5" placeholder="内容を入力してください" style="height:300px" cols="50" rows="30"><?php echo str_replace("<br />","",$result['content']); ?></textarea>
          </div>
          <div>
            <label>添付ファイル<span class="option">任意</span></label>
            <input type="file" name="userfile[]">
          </div>
        </div>
        <button type="submit">修正する</button>
<?php }elseif ($confirmbutton === 4){?>
    <div>
      <form action=<?php echo "formaction2.php?status&id=".$result['id'] ?> method="post" name="form" id="sendform" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
        <h1 class="contact-title">稟議ステータス変更</h1>
        <div>
          <div>
            <label>申請者</label>
            <input type="hidden" name="name" value="<?php echo $result['name']; ?>">
            <p><?php echo $result['name']; ?><p>
          </div>
          <div>
            <label>申請日</label>
            <input type="hidden" name="date" value="<?php echo $result['date']; ?>">
            <p><?php echo $result['date']; ?><p>
          </div>
          <div>
            <label>申請部署</label>
            <input type="hidden" name="department" value="<?php echo $result['department']; ?>">
            <p><?php echo $result['department']; ?><p>
          </div>
          <div>
            <label>申請タイトル</label>
            <input type="hidden" name="title" value="<?php echo $result['title']; ?>">
            <p><?php echo $result['title']; ?><p>
          </div>
          <div>
            <label>申請内容</label>
            <textarea style="display:none" name="content"><?php echo $result['content']; ?></textarea>
            <p><?php echo $result['content']; ?><p>
          </div>
          <div>
            <label>添付ファイル</label>
            <input type="hidden" name="userfile" value="<?php echo $result['file']; ?>">
            <?php if($result['file'] !==''){?>
            <a href="uploadfile/<?php echo $result['file']; ?>"><?php echo $result['file']; ?></a>
            <?php }else{?>
            <p><?php echo "ファイルの添付はありません"; ?></p>
            <?php }?>
          </div>
          <div>
            <label>ステータス<span class="required">必須</span></label>
            <select name="status">
              <option><?php if($result['status']===null){
                              echo '未承認';
                            }else{
                              echo $result['status'];}?></td></option>
              <option>未承認</option>
              <option>差し戻し</option>
              <option>承認</option>
            </select>
          </div>
        </div>
        <button type="submit">変更する</button>
<?php }?>
      </form>
    </div>
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
