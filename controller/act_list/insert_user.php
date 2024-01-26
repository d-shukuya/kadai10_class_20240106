<?php
// 0. インポート
session_start();
require_once __DIR__ . '/../../Model/db_util.php';
require_once __DIR__ . '/../../Model/user_model.php';
require_once __DIR__ . '/../../Model/order_model.php';

// 1. POST データの格納
$uName = $_POST['u_name'];
$pw = $_POST['pw'];

// 2. データ登録
// user
$userModel = new UserModel();
$newId = $userModel->createRecord($uName, $pw);

// bookOrder
$orderModel = new OrderModel();
$orderModel->createBooks($newId);

// 3. セッションを設定
$_SESSION["chk_ssid"] = session_id();
$_SESSION["id"] = $newId;
$_SESSION["u_name"] = $uName;

// 3. クライアントに結果を返す
echo json_encode(array('status' => "ok"));
