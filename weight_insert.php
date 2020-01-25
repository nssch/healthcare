<?php
//var_dump($_POST);
//セッションスタート
session_start();

//関数ファイルよみこむ
include('functions.php');

//ログイン状態の確認
checkSessionid();

//入力チェック
if (
    !isset($_POST['weight']) || $_POST['weight'] == ''
) {
    exit('Paramerror');
}

//セッション変数取得
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    exit('sessionerror');
}

//POSTデータ取得
$weight = $_POST['weight'];

//体重をセッション変数にいれる
//$_SESSION['weight'] = $weight;

//データ登録処理
$pdo = connectToDb();

//データ登録ＳＱＬ
$sql = 'INSERT INTO weight_table(id,user_id,weight,date)VALUES(null,:a1,:a2,sysdate())';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':a2', $weight, PDO::PARAM_STR);
$status = $stmt->execute();


//登録処理中のエラー
if ($status == false) {
    $error = $stmt->errorInfo();
    exit('sqlerror' . $error[2]);
} else {
    header('Location:weight_graph.php');
}
