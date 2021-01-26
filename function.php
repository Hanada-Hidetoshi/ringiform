<?php
class Dbc{
  public $tablename;
  public function dbconnect(){//データベース接続
    $host = "mysql1.php.xdomain.ne.jp";
    $dbname = "hanadax_database";
    $user = 'hanadax_kanri';
    $dbpassword = 'YfkekaNByf3b3FZ';
    $dsn = 'mysql:host='.$host.';dbname='.$dbname.';charset=utf8';
    try{
      $dbh = new PDO($dsn, $user, $dbpassword);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (Exception $e) {
    echo 'データベースに接続できませんでした。:' . $e->getMessage();
    exit();
    }
    return $dbh;
  }
  function getdata(){//データ1件取得
    $dbh = $this -> dbconnect();
    $sql = 'SELECT * FROM '.$this->tablename.' WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':id' => $_GET['id']));
    $result = 0;
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
    $dbh = null;
  }
   function getUserdata($loginuser){//ユーザー情報1件取得
    $dbh = $this -> dbconnect();
    $sql = 'SELECT * FROM '.$this->tablename.' WHERE name = :name ORDER BY id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $loginuser, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
    $dbh = null;
  }
  function getAlldata(){//データベース全件取得
    $dbh = $this -> dbconnect();
    $sql = 'SELECT* FROM '.$this->tablename.' ORDER BY id';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
    $dbh = null;
  }
  function datachange(){//データベース変更処理
    $sql = 'UPDATE '.$this->tablename.' SET name=:name,mail=:mail,user_id=:user_id,password=:password,updated_at=now() WHERE id =:id';
    $dbh = $this -> dbconnect();
    $dbh->beginTransaction();
    try{
      $stmt = $dbh->prepare($sql);
      $params = array(':id' => $_POST['id'],':name' => $_POST['name'], ':mail' => $_POST['mail'], ':user_id' => $_POST['user_id'],'password' =>$_POST['password']);
      $stmt->execute($params);
    }catch (Exception $e) {
      echo 'エラーが発生しました。:' . $e->getMessage();
      exit();
    }
  }
  function datadelete($id){//データベース削除処理
    $sql = 'DELETE FROM '.$this->tablename.' WHERE id ='.$id;
    $dbh = $this -> dbconnect();
    $dbh->beginTransaction();
    try{
      $res = $dbh->query($sql);
    }catch (Exception $e) {
      echo 'エラーが発生しました。:' . $e->getMessage();
      exit();
    }
  }
  function entry(){//データベース登録処理
    $sql = 'INSERT INTO '.$this->tablename.'(name,mail,user_id,password,created_at,updated_at) VALUES (:name,:mail,:user_id,:password,now(),now())';
    $dbh = $this -> dbconnect();
    $dbh->beginTransaction();
    try{
      $stmt = $dbh->prepare($sql);
      $params = array(':name' => $_POST['name'], ':mail' => $_POST['mail'], ':user_id' => $_POST['user_id'],'password' =>$_POST['password']);
      $stmt->execute($params);
    }catch (Exception $e) {
      echo 'エラーが発生しました。:' . $e->getMessage();
      exit();
    }
  }
  function login($username,$userpassword){//ログイン処理
    $dbh = $this -> dbconnect();
    $dbh->beginTransaction();
    $sql = 'select * from '.$this->tablename.' where user_id=? and password=?';
    try{
      $stmt = $dbh->prepare($sql);
      $stmt->execute(array($username,$userpassword));
      $result = $stmt->fetchAll();
      return $result;
      $dbh = null;
    }catch (Exception $e) {
      echo 'エラーが発生しました。:' . $e->getMessage();
      exit();
    }
  }
}
?>
