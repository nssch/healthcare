<?php
//セッションスタート
session_start();

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

//データベース接続
$pdo = connectToDb();

//体重データ取得
$sql = 'SELECT weight,date FROM weight_table WHERE user_id=:id ORDER BY date ASC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();

$res = [];
if ($status == false) {
    $result["message"] = $stmt->errorInfo();
} else {
    $weights = [];
    $dates = [];
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // 体重が入った配列が欲しい
        // 体重が入る配列($weights)にDBから取り出した体重($result['weight'])を入れる
        array_push($weights, $result['weight']);

        // 測定日が入った配列が欲しい
        // 測定日が入る配列($dates)にDBから取り出した測定日($result['date'])を入れる
        array_push($dates, $result['date']);
    }
    $res["labels"] = $dates;
    $res["data"] = $weights;
}
echo json_encode($res);

// $lastweight = end($res["data"]);
// //var_dump($lastweight);
// $_SESSION['lastweight'] = $lastweight;

// // インサートしたレコード取得
// $sql2 = 'SELECT SUM(last_weight) FROM act_table WHERE user_id=:id';
// $statement = $pdo->prepare($sql2);
// // $statement->bindValue(':last_weight', $last_weight, PDO::PARAM_INT);
// $statement->bindValue(':id', $user_id, PDO::PARAM_INT);
// $res = $statement->execute();

// while ($res = $statement->fetch(PDO::FETCH_ASSOC)) {
//     $sum_weight = $res['SUM(last_weight)'];
// }

// $carolie = $sum_weight * 1.05;
// //セッションに$carolieいれる
// $_SESSION['carolie'] = $carolie;


// $result = [
//     "labels" => ['12/1', '12/2', '12/3', '12/4'],
//     "data" => [100, 99, 97, 98]
// ];
