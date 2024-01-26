<?php
// 0. インポート
session_start();
require_once __DIR__ . '/../../Model/db_util.php';
require_once __DIR__ . '/../../Model/order_model.php';
require_once __DIR__ . '/../../Model/dog_ear_model.php';
require_once __DIR__ . '/../util_class.php';

// 1. チェック
Util::checkSession('..');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Util::redirect('../../');
    exit;
}

// 2. 変数定義
$bookId = $_POST["book_id"];
$ownerId = $_SESSION["id"];
$dogEarOrder = $_POST['dog_ear_order'];

// 3．データ登録
// dogEar
$dogEarModel = new DogEarModel();
$newId = $dogEarModel->createRecord($bookId, $ownerId);

// dogEarOrder（更新）
$dogEarOrderAry = json_decode($dogEarOrder, true);
$dogEarOrderAry[] = (int)$newId;
$dogEarOrderJSON = json_encode($dogEarOrderAry);
$orderModel = new OrderModel();
$orderModel->updateRecord($dogEarOrderJSON, 'dog_ear', $ownerId, $bookId);

// 4. dog_ear.php に遷移
Util::redirect("../dog_ear.php?book_id=$bookId");