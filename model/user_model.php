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

    public function checkPassword($lPw, $val): bool
    {
        return password_verify($lPw, $val["u_pw"]) ? true : false;
    }
}
