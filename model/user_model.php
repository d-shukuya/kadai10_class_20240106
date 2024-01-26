<?php
// 0. インポート
require_once __DIR__ . '/db_util.php';

class UserModel
{
    private DbUtil $dbUtil;
    private PDO $pdo;

    public function __construct()
    {
        $this->dbUtil = new DbUtil();
        $this->pdo = $this->dbUtil->db_conn();
    }

    // CREATE
    public function createRecord($uName, $pw)
    {
        $hashedPw = password_hash($pw, PASSWORD_DEFAULT);

        $sql = "INSERT INTO gs_bm_user(id, u_name, u_id, u_pw, life_flg, created_date)
                VALUES (NULL, :u_name, :u_id, :u_pw, 1, sysdate())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':u_name', $uName, PDO::PARAM_STR);
        $stmt->bindValue(':u_id', $uName, PDO::PARAM_STR);
        $stmt->bindValue(':u_pw', $hashedPw, PDO::PARAM_STR);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
        return $this->pdo->lastInsertId();
    }

    // READ
    public function readRecord($lId)
    {
        $sql = 'SELECT * FROM gs_bm_user WHERE u_id=:lId AND life_flg=1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':lId', $lId, PDO::PARAM_STR);
        $status = $stmt->execute();

        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }

        return $stmt->fetch();
    }

    public function checkDuplication($uName)
    {
        $sql = 'SELECT COUNT(*) FROM gs_bm_user WHERE u_id=:uName AND life_flg=1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':uName', $uName, PDO::PARAM_STR);
        $status = $stmt->execute();

        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }

        return $stmt->fetchColumn() == 0;
    }

    // その他関数
    public function checkPassword($lPw, $val): bool
    {
        return password_verify($lPw, $val["u_pw"]) ? true : false;
    }
}
