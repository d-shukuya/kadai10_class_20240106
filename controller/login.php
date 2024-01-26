<?php
// 0. インポート
require_once __DIR__ . '/../view/login_view.php';

// 1. エラーメッセージの取得
$loginView = new LoginView();
$errMessage = $loginView->getErrMessage($_GET);

// 2. HTMLの読み込み
require_once __DIR__ . '/../view/html/login_html.php';
