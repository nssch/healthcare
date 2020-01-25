<?php
// session_start();
// var_dump($_SESSION);

// //var_dump($_POST);
//セッションスタート
session_start();
var_dump($_SESSION);


//関数ファイル読み込み
include('functions.php');

//ログイン状態の確認
checkSessionid();

//セッション変数取得
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    exit('sessionerror');
}

if (isset($_SESSION['lastweight'])) {
    $lastweight = $_SESSION['lastweight'];
} else {
    $lastweight = 0;
    //exit('sessionerror2');
}
// if (isset($_SESSION['carolie'])) {
//     $carolie = $_SESSION['carolie'];
// } else {
//     $carolie = 0;
//     //exit('sessionerror2');
// }


//データベースに接続
$pdo = connectToDb();

//POSTデータ取得
//$done = $_POST['done'];

//input type=hiddenでsession変数（ユーザーIDとかメニューIDとか）をデータベースにinsertする？
//クリックをカウントしていくだけより上記のほうがいいのでは？

//DONEボタンがクリックされたら、user_idと日付をact_tableにINSERTしたい
//登録SQL

if (isset($_POST['done'])) {
    $sql = 'INSERT INTO act_table(id,user_id,date,last_weight)VALUES(NULL,:a1,sysdate(),:a2)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':a1', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':a2', $lastweight, PDO::PARAM_INT);
    $status = $stmt->execute();
} else {
    exit();
}

//登録処理中のエラー
if ($status == false) {
    $error = $stmt->errorInfo();
    exit('sqlerror' . $error[2]);
} else {
    // インサートしたレコード取得
    $sql2 = 'SELECT SUM(last_weight) FROM act_table WHERE user_id=:id';
    $statement = $pdo->prepare($sql2);
    // $statement->bindValue(':last_weight', $last_weight, PDO::PARAM_INT);
    $statement->bindValue(':id', $user_id, PDO::PARAM_INT);
    $res = $statement->execute();

    while ($res = $statement->fetch(PDO::FETCH_ASSOC)) {
        $sum_weight = $res['SUM(last_weight)'];
    }

    $carolie = $sum_weight * 1.05;
    //セッションに$carolieいれる
    $_SESSION['carolie'] = $carolie;

    header('Location:act2.php');
}
