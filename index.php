<?php
// 0. インポート
session_start();
require_once __DIR__ . '/controller/util_class.php';

// 1. ルーティング
Util::redirect(Util::isLogin() ? "./controller/books.php" : "./controller/login.php");
