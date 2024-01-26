<?php
// 0. インポート
session_start();
require_once __DIR__ . '/../util_class.php';

// SESSION を初期化
$_SESSION = array();

// Cookie に保存してある SessionID の保存期間を過去にして破棄
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// サーバ側でのセッションIDの破棄
session_destroy();
Util::redirect('../login.php');
exit();
