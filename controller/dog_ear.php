<?php
// 0. インポート
session_start();
require_once __DIR__ . '/util_class.php';
require_once __DIR__ . '/../model/order_model.php';
require_once __DIR__ . '/../model/books_model.php';
require_once __DIR__ . '/../model/dog_ear_model.php';
require_once __DIR__ . '/../view/dog_ear_view.php';

// 1. セッションチェック
Util::checkSession('.');

// 2. 変数定義
$lId = $_SESSION["id"];
$lName = $_SESSION["u_name"];
$bookId12 = $_GET['book_id'];

// 3. DBからデータ取得
// 3-1. Books
$booksModel = new BooksModel();
$resBooks = $booksModel->readRecordByIdAndLoginId($bookId12, $lId);
Util::checkOwner($resBooks);

// 3-2. Order
$orderModel = new OrderModel();
$resOrder = $orderModel->readRecordByTypeAndOwnerId('books', $lId);
$resDogEarOrder = $orderModel->readRecordByTypeAndBookId('dog_ear', $bookId12);

// 3-3. DogEar
$dogEarModel = new DogEarModel();
$resDogEar = $dogEarModel->readRecordByBookId($bookId12);

// 4. HTML 用のデータの作成
// booksOrder
$orderColumnJSON = $resOrder['order'];

// dogEarOrder
$dogEarOrderColumnJSON = $resDogEarOrder['order'];
$dogEarOrderColumnAry = json_decode($dogEarOrderColumnJSON, true);

// books
$bookName = $resBooks['name'];
$bookUrl = $resBooks['url'];
$bookMemo = $resBooks['content'];
$createdDateBooks = $resBooks['created_date'];
$updateDateBooks = $resBooks['update_date'];

// dogEar
$view = "";
$dogEarView = new DogEarView();
for ($i = 0; $i < count($dogEarOrderColumnAry); $i++) {
    $view = $dogEarView->createView($bookId12, $resDogEar[$dogEarOrderColumnAry[$i]], $view, $dogEarOrderColumnJSON);
}

// 3. HTMLの読み込み
require_once __DIR__ . '/../view/html/dog_ear_html.php';
