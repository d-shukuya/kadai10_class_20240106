<?php
session_start();
include("./funcs.php");

$lId = $_POST['l_id'];
$lPw = $_POST['l_pw'];

$pdo = db_conn();
$sql = 'SELECT * FROM gs_bm_user WHERE u_id=:lId AND u_pw=:lPw';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lId', $lId, PDO::PARAM_STR);
$stmt->bindValue(':lPw', $lPw, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
}

$val = $stmt->fetch();

if ($val["id"] != "") {
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["id"] = $val["id"];
    $_SESSION["u_name"] = $val["u_name"];

    redirect('../');
} else {
    redirect('./login.php?err=login_err');
}
