<?php
// 0. インポート
session_start();
require_once __DIR__ . '/../../model/books_model.php';
require_once __DIR__ . '/../util_class.php';

// 1. チェック
Util::checkSession('..');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Util::redirect('../../');
    exit;
}

// 2. 変数定義
$columnName = Util::$tagNameToBooksTableColumn[$_POST['type']];
$changeVal = $_POST["change_val"];
$bookId = $_POST["book_id"];

// 3. データ更新
$booksModel = new BooksModel();
$booksModel->updateRecord($columnName, $changeVal, $bookId);
