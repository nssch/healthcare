<?php
///セッションスタート
session_start();

//セッションの中を空にする
$_SESSION = array();

//Cookieに保存してあるsessionIDの保存期間を過去にして破棄
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

//サーバー側でのsession_id破棄
session_destroy();

//処理後、ログイン画面に戻る
header('Location:login.php');
