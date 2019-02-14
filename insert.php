<?php

// 入力チェック
if(
    !isset($_POST['name']) || $_POST['name']==''||
    !isset($_POST['code']) || $_POST['code']==''||
    !isset($_POST['description']) || $_POST['description']==''||
    !isset($_POST['publish']) || $_POST['publish']==''||
    !isset($_POST['created']) || $_POST['created']==''

){
    exit('ParamError'); 
}


//POSTデータ取得
$name = $_POST['name'];
$code = $_POST['code'];
$description = $_POST['description'];
$indate = $_POST['publish'];
$indate = $_POST['created'];
//exit(error);

//DB接続
$dbn = 'mysql:dbname=gs_f02_db29;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = 'root';

try {
    $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
    exit('dbError:'.$e->getMessage());
}

//データ登録SQL作成
$sql ='INSERT INTO videos(id, name, code, description, publish, created) VALUES(NULL, :a1, :a2, :a3, sysdate(), sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $code, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $description, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if ($status==false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    //５．index.phpへリダイレクト
    header('Location: index.php');
}
