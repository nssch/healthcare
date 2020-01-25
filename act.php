<?php
//セッションスタート
session_start();

//関数ファイル読み込み
include('functions.php');

//ログイン状態確認
checkSessionid();

//セッション変数取得
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    exit('sessionerror');
}

//データベース接続
$pdo = connectToDb();

//実績データ取得
$sql = 'SELECT COUNT(*) AS count FROM act_table WHERE user_id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();


if ($status == false) {
    $result["message"] = $stmt->errorInfo();
} else {

    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data = $result['count'];
    }

    $notyet = 50 - $data;
}

$res = [
    "labels" => ["done", "not yet"],
    "data" => [$data, $notyet],
    "text" => $data . 'Ex'
];

echo json_encode($res);
