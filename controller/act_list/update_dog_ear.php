<?php
// 0. インポート
session_start();
require_once __DIR__ . '/../../model/dog_ear_model.php';
require_once __DIR__ . '/../util_class.php';

// 1. チェック
Util::checkSession('..');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Util::redirect('../../');
    exit;
}

// 2. 変数定義
$columnName = Util::$tagNameToDogEarTableColumn[$_POST['type']];
$changeVal = $_POST["change_val"];
$dogEarId = $_POST["dog_ear_id"];

// 3. データ更新
$dogEarModel = new DogEarModel();
$dogEarModel->updateRecord($columnName, $changeVal, $dogEarId);
