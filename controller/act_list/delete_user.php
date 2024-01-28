<?php
// 0. インポート
session_start();
require_once __DIR__ . '/../../model/books_model.php';
require_once __DIR__ . '/../../model/dog_ear_model.php';
require_once __DIR__ . '/../../model/order_model.php';
require_once __DIR__ . '/../../model/user_model.php';
require_once __DIR__ . '/../util_class.php';

// 1. チェック
Util::checkSession('..');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Util::redirect('../../');
    exit;
}

// 2. 変数定義
$lId = $_SESSION['id'];

// 3. データ削除
// books & bookCover
$booksModel = new BooksModel();
$booksModel->deleteAllByOwnerId($lId);

// order
$orderModel = new OrderModel();
$orderModel->deleteAllByOwnerId($lId);

// dog_ear
$dogEarModel = new DogEarModel();
$dogEarModel->deleteAllByOwnerId($lId);

// user
$userModel = new UserModel();
$newId = $userModel->deleteRecord($lId);

// 4. セッションを削除
$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}
session_destroy();
