<?php
// 0. インポート
session_start();
require_once __DIR__ . '/../../model/books_model.php';

// 1. チェック
Util::checkSession('..');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Util::redirect('../../');
    exit;
}

// 2. 変数定義
$bookId = $_POST['book_id'];

// 3. データ更新
$booksModel = new BooksModel();
$booksModel->updateBookCoverFile($bookId, $_FILES);
