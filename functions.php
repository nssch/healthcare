<?php
//データベースに接続する関数
function connectToDb()
{
    $dbn = 'mysql:dbname=healthcare;charset=utf8;port=3306;host=localhost';
    $user =  'root';
    $pwd = '';

    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        exit('dbError:' . $e->getMessage());
    }
}

//SQL処理エラー
function showSqlErrorMsg($stmt)
{
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
}

//ログイン状態の確認
function checkSessionid()
{
    //失敗時はログイン画面へ
    if (!isset($_SESSION['session_id']) || $_SESSION['session_id'] != session_id()) {
        header('Location:login.php');
    } else {
        session_regenerate_id(true);
        $_SESSION['session_id'] = session_id();
    }
}
