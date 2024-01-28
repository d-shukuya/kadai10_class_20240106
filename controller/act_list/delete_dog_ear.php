<?php
// 0. インポート
session_start();
require_once __DIR__ . '/../../model/dog_ear_model.php';
require_once __DIR__ . '/../../model/order_model.php';
require_once __DIR__ . '/../util_class.php';

// 1. チェック
Util::checkSession('..');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Util::redirect('../../');
    exit;
}

// 2. 変数定義
$bookId = $_POST['book_id'];
$dogEarId = $_POST['dog_ear_id'];
$dogEarOrder = $_POST['dog_ear_order'];
$lId = $_SESSION['id'];

// 3. データ削除
// dogEarOrder（更新）
$removedOrderJSON = Util::removeIdFromAry($dogEarOrder, $dogEarId);
$orderModel = new OrderModel();
$orderModel->updateRecord($removedOrderJSON, 'dog_ear', $lId, $bookId);

// dog_ear
$dogEarModel = new DogEarModel();
$dogEarModel->deleteRecordByDogEarId($dogEarId);
