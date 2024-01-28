<?php
// 0. インポート
session_start();
require_once __DIR__ . '/../../model/books_model.php';
require_once __DIR__ . '/../../model/order_model.php';
require_once __DIR__ . '/../../model/dog_ear_model.php';
require_once __DIR__ . '/../util_class.php';

// 1. チェック
Util::checkSession('..');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Util::redirect('../../');
    exit;
}

// 2. 変数定義
$bookName = $_POST["name"];
$bookUrl = $_POST["url"];
$ownerId = $_SESSION["id"];
$booksOrder = $_POST['books_order'];

// 3. データ登録
// book
$booksModel = new BooksModel();
$newId = $booksModel->createRecord($bookName, $bookUrl, $ownerId);

// bookCover
$booksModel->createBookCoverFile($newId, $_FILES);

// bookOrder（更新）
$booksOrderAry = json_decode($booksOrder, true);
$booksOrderAry[] = (int)$newId;
$booksOrderJSON = json_encode($booksOrderAry);
$orderModel = new OrderModel();
$orderModel->updateRecord($booksOrderJSON, 'books', $ownerId, $newId);

// dog_ear_order
$orderModel->createDogEar($newId, $ownerId);

// 4. index.php に遷移
Util::redirect('../../');
