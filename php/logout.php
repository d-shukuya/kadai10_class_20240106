<?php
session_start();
include("./funcs.php");

// SESSION を初期化
$_SESSION = array();

// Cookie に保存してある SessionID の保存期間を過去にして破棄
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// サーバ側でのセッションIDの破棄
session_destroy();
redirect('./login.php');
exit();
