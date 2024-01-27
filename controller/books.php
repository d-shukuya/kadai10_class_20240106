<?php
// 0. インポート
session_start();
require_once __DIR__ . '/util_class.php';
require_once __DIR__ . '/../model/books_model.php';
require_once __DIR__ . '/../model/order_model.php';
require_once __DIR__ . '/../view/books_view.php';

// 1. セッションチェック
Util::checkSession('.');
$lId = $_SESSION["id"];
$lName = $_SESSION["u_name"];

// 2. DBからデータ取得
// 2-1. Order
$orderModel = new OrderModel();
$resOrder = $orderModel->readRecordByTypeAndOwnerId('books', $lId);

// 2-2. Books
$booksModel = new BooksModel();
$resBooks = $booksModel->readRecordByOwnerId($lId);

// 3. HTML 用のデータの作成
$orderColumnJSON = $resOrder['order'];
$orderColumnAry = json_decode($orderColumnJSON, true);
$view = "";
$booksView = new BooksView();
for ($i = 0; $i < count($orderColumnAry); $i++) {
    $view = $booksView->createView($resBooks[$orderColumnAry[$i]], $view);
}

// 4. HTMLの読み込み
require_once __DIR__ . '/../view/html/books_html.php';
