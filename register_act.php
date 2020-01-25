<?php
//var_dump($_POST);

//関数ファイル読み込み
include('functions.php');

//入力チェック
if (
    !isset($_POST['name']) || $_POST['name'] == '' ||
    !isset($_POST['lid']) || $_POST['lid'] == '' ||
    !isset($_POST['mail']) || $_POST['mail'] == '' ||
    !isset($_POST['lpw']) || $_POST['lpw'] == ''
) {
    exit('Parramerror');
}

//ＰＯＳＴデータ取得
$name = $_POST['name'];
$lid = $_POST['lid'];
$mail = $_POST['mail'];
$lpw = $_POST['lpw'];


//データベース接続
$pdo = connectToDb();

//登録処理
$sql = 'INSERT INTO user_table (id,name,lid,mail,lpw)VALUES(NULL,:a1,:a2,:a3,:a4)';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);
$stmt->bindValue(':a2', $lid, PDO::PARAM_STR);
$stmt->bindValue(':a3', $mail, PDO::PARAM_STR);
$stmt->bindValue(':a4', $lpw, PDO::PARAM_STR);
$result = $stmt->execute();

//データ登録処理エラー
if ($result == false) {
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
} else {
    // インサートしたレコード取得
    $sql2 = 'SELECT*FROM user_table WHERE mail=:mail';
    $statement = $pdo->prepare($sql2);
    $statement->bindValue(':mail', $mail, PDO::PARAM_STR);
    $res = $statement->execute();

    // idカラムの値を取得
    $val = $statement->fetch();

    // セッションを開始
    session_start();


    // セッションにidをもたせる
    if ($val != '') {
        $_SESSION = array();
        $_SESSION['session_id'] = session_id();
        $_SESSION['id'] = $val['id'];
    }
    header('Location:start.php');
}
