<?php if($_SESSION['user'] !==''){?>
<header>
  <div>
    <div class="header">
      <div class="top">
        <h1><?php echo $pagetitle ?></h1>
        <p>ログイン中のユーザー：<?php echo $_SESSION['user']; ?></p>
      </div>
      <div class = "navi">
        <ul>
          <li><a href="database.php">アカウント情報</a></li>
          <li><a href="ringidata.php">申請済み稟議データ</a></li>
          <li><a href="shinsei.php">稟議申請フォーム</a></li>
          <li><a href="login.php">ログアウト</a></li>
          <li><a href="touroku.php">アカウント登録</a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
<?php }else{ ?>
<header>
  <div>
    <div class="header">
      <div class="top">
        <h1><?php echo $pagetitle ?></h1>
        <p>ログイン中のユーザー：<?php echo $_SESSION['user']; ?></p>
      </div>
      <div class = "navi">
        <ul>
          <li><a href="database.php">アカウント情報</a></li>
          <li><a href="ringidata.php">申請済み稟議データ</a></li>
          <li><a href="shinsei.php">稟議申請フォーム</a></li>
          <li><a href="login.php">ログイン</a></li>
          <li><a href="touroku.php">アカウント登録</a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
<?php } ?>
