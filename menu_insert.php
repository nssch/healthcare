<?php
//セッションスタート
session_start();

//関数ファイル読み込み
include('functions.php');

//ログイン状態の確認
checkSessionid();

//データベース接続
$pdo = connectToDb();

//セッション変数取得
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    exit('sessionerror');
}

//POSTデータ取得
$mets_id = $_POST['menu'];

//データベースに登録する
//$sql = 'INSERT INTO user_table(mets_id) VALUES(:a1) WHERE id=:id';
$sql = 'UPDATE user_table SET mets_id=:a1 WHERE id=:id';  //WHERE id=:id入れないと全データが変わってしまう
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $mets_id, PDO::PARAM_INT);
$stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
$result = $stmt->execute();

//登録処理中のエラー
if ($result == false) {
    $error = $stmt->errorInfo();
    exit('sqlerror' . $error[2]);
} else {
    header('Location:act2.php');
}
