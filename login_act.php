<?php
//セッション開始
session_start();

//関数ファイルの読み込み。ログイン状態の確認
include('functions.php');

//データベース接続、送信データの受け取り
$pdo = connectToDb();
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

//該当id,pwを抽出
$sql = 'SELECT*FROM user_table WHERE lid=:lid AND lpw=:lpw';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$result = $stmt->execute();

//SQLエラー処理
if ($result == false) {
    showSqlErrorMsg($stmt);
}
//実行結果のデータを取得
$val = $stmt->fetch();

//該当データがあればsessionに値を代入
if ($val['id'] != '') {
    //ログイン成功ならsessionに値を入れる
    $_SESSION = array();
    $_SESSION['session_id'] = session_id();
    $_SESSION['id'] = $val['id'];
    $_SESSION['name'] = $val['name'];
    $_SESSION['mail'] = $val['mail'];
    $_SESSION['group_id'] = $val['group_id'];
    $_SESSION['menu_id'] = $val['menu_id'];

    header('Location:act2.php');
} else {
    //ログイン失敗ならログイン画面のまま
    header('Location:login.php');
}

exit();
