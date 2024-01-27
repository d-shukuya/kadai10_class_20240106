<?php
// 0. インポート
session_start();
require_once __DIR__ . '/../../Model/user_model.php';
require_once __DIR__ . '/../util_class.php';

// 1. POST データの格納
$lId = $_POST['l_id'];
$lPw = $_POST['l_pw'];

// 2. データ参照
$topDirPath = '../..';
$userModel = new UserModel($topDirPath);
$val = $userModel->readRecord($lId);

if ($val["id"] != "" && $userModel->checkPassword($lPw, $val)) {
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["id"] = $val["id"];
    $_SESSION["u_name"] = $val["u_name"];

    Util::redirect('../../');
} else {
    Util::redirect('../login.php?err=login_err');
}
