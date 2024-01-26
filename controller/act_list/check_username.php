<?php
// 0. インポート
require_once __DIR__ . '/../../Model/db_util.php';
require_once __DIR__ . '/../../Model/user_model.php';
require_once __DIR__ . '/../util_class.php';

// 1. 変数定義
$uName = $_POST['u_name'];

// 2. データ参照
$userModel = new UserModel();
$isUnique = $userModel->checkDuplication($uName);

// 3. クライアントに結果を返す
echo json_encode(array('isUnique' => $isUnique));