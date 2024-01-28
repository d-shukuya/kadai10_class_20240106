<?php
// 0. インポート
session_start();
require_once __DIR__ . '/../../model/order_model.php';
require_once __DIR__ . '/../util_class.php';

// 1. チェック
Util::checkSession('..');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Util::redirect('../../');
    exit;
}

// 2. 変数定義
$order = $_POST['order'];
$type = $_POST['type'];
$lId = $_SESSION["id"];
$bookId = $_POST['book_id'];

// 3. データ更新
$orderModel = new OrderModel();
$orderModel->updateRecord($order, $type, $lId, $bookId);
