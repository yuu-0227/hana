<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_5-1</title>
    </head>
    <body>
        <h1>好きな飲み物</h1>
        <form action="" method="post">
            <input type="text" name="name" placeholder="名前">
            <br>
            <input type="text" name="comment" placeholder="コメント">
            <br>
            <input type="password" name="pass" placeholder="パスワード">
            <br>
            <input type="text" name="edit" placeholder="編集対象番号">
            <input type="submit" name="submit">
            <br>
            <input type="text" name="delete" placeholder="削除対象番号">
            <br>
            <input type="password" name="delpass" placeholder="パスワード">
            <input type="submit" value="削除">
            <br>
        </form>
    </body>
</html>
<?php
//データベースに接続
 $dsn = 'データベース名';
 $user = 'ユーザー名';
 $password = 'パスワード';
 $pdo = new PDO($dsn, $user, $password, 
 array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
 //テーブル作成
 $sql = "CREATE TABLE IF NOT EXISTS mission5"
 ." ("
 . "id INT AUTO_INCREMENT PRIMARY KEY,"
 . "name char(32),"
 . "comment TEXT,"
 . "date datetime,"
 . "pass char(32)"
 .");";
 $stmt = $pdo->query($sql);
 //編集機能
 if(!empty($_POST["name"]) && !empty($_POST["comment"]) && 
 !empty($_POST["edit"])){
     $edit = $_POST["edit"]; //編集対象番号の受け取り
     $name = $_POST["name"];
     $comment = $_POST["comment"];
     $date = date("Y/m/d H:i:s");
     $pass = $_POST["pass"];
     $sql = 'UPDATE mission5 SET 
     name=:name,comment=:comment,date=:date where id=:id and pass=:pass';
     $stmt = $pdo->prepare($sql);
     $stmt->bindParam(':name', $name1, PDO::PARAM_STR);
     $stmt->bindParam(':comment', $comment1, PDO::PARAM_STR);
     $stmt->bindParam(':date', $date1, PDO::PARAM_STR);
     $stmt->bindParam(':id', $edit, PDO::PARAM_STR);
     $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
     $name1 = $name;
     $comment1 = $comment;
     $date1 = $date;
     $stmt->execute();
 }else{
//テキスト入力
      if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"])){
          $name = $_POST["name"];
          $comment = $_POST["comment"];
          $date = date("Y/m/d H:i:s");
          $pass = $_POST["pass"];
          $sql = $pdo->prepare("INSERT INTO mission5 (id, name, comment, date, pass)
          VALUES (:id, :name, :comment, :date, :pass)");
          $sql->bindParam(':id', $id, PDO::PARAM_STR);
          $sql->bindParam(':name', $name2, PDO::PARAM_STR);
          $sql->bindParam(':comment', $comment2, PDO::PARAM_STR);
          $sql->bindParam(':date', $date2, PDO::PARAM_STR);
          $sql->bindParam(':pass', $pass, PDO::PARAM_STR);
          $name2 = $name;
          $comment2 = $comment;
          $date2 = $date;
          $sql->execute();
    }
 }
 //削除機能
 if(!empty($_POST["delete"]) && !empty($_POST["delpass"])){
     $delete = $_POST["delete"];
     $delpass = $_POST["delpass"];
     $sql = 'delete from mission5 where id=:id and pass=:pass';
     $stmt = $pdo->prepare($sql);
     $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
     $stmt->bindParam(':pass', $delpass, PDO::PARAM_INT);
     $stmt->execute();
 }
 //入力したデータレコードを抽出し、表示
 $sql = 'SELECT * FROM mission5';
 $stmt = $pdo->query($sql);
 $results = $stmt->fetchAll();
 foreach ($results as $row){
     echo $row['id'].',';
     echo $row['name'].',';
     echo $row['comment'].',';
     echo $row['date'].'<br>';
 echo "<hr>";
 }
 ?>