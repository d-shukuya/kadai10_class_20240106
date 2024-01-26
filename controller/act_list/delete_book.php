<?php
// 0. インポート
session_start();
require_once __DIR__ . '/../../Model/db_util.php';
require_once __DIR__ . '/../../Model/books_model.php';
require_once __DIR__ . '/../../Model/dog_ear_model.php';
require_once __DIR__ . '/../../Model/order_model.php';
require_once __DIR__ . '/../util_class.php';

// 1. チェック
Util::checkSession('..');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Util::redirect('../../');
    exit;
}

// 2. 変数定義
$bookId = $_POST['book_id'];
$booksOrder = $_POST['books_order'];
$lId = $_SESSION['id'];

// 3. データ削除
// bookCover
$booksModel = new BooksModel();
$booksModel->deleteBookCoverFile($bookId);

// booksOrder（更新）
$removedOrderJSON = Util::removeIdFromAry($booksOrder, $bookId);
$orderModel = new OrderModel();
$orderModel->updateRecord($removedOrderJSON, 'books', $lId, $bookId);

// dogEarOrder
$orderModel->deleteDogEarOrder($bookId);

// book
$booksModel->deleteRecord($bookId);

// dog_ear
$dogEarModel = new DogEarModel();
$dogEarModel->deleteRecordByBookId($bookId);
