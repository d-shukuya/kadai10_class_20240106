<?php
// 0. インポート
require_once __DIR__ . '/db_util.php';

class OrderModel
{
    private DbUtil $dbUtil;
    private PDO $pdo;

    public function __construct()
    {
        $this->dbUtil = new DbUtil();
        $this->pdo = $this->dbUtil->db_conn();
    }

    // CREATE
    public function createBooks($ownerId)
    {
        $sql = "INSERT INTO gs_bm_order(id, `type`, book_id, `order`, owner_id)
                    VALUES (NULL, 'books', NULL, '[]', :owner_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':owner_id', $ownerId, PDO::PARAM_INT);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
    }

    public function createDogEar($bookId, $ownerId)
    {
        $sql = "INSERT INTO gs_bm_order(id, `type`, book_id, `order`, owner_id)
                    VALUES (NULL, 'dog_ear', :book_id, '[]', :owner_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->bindValue(':owner_id', $ownerId, PDO::PARAM_INT);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
    }

    // READ
    public function readRecordByTypeAndOwnerId($type, $ownerId)
    {
        $sql = "SELECT * FROM gs_bm_order WHERE `type` = '$type' AND owner_id = $ownerId";
        return $this->fetch($sql);
    }

    public function readRecordByTypeAndBookId($type, $bookId)
    {
        $sql = "SELECT * FROM gs_bm_order WHERE `type` = '$type' AND book_id = $bookId";
        return $this->fetch($sql);
    }

    private function fetch($sql)
    {
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        } else {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    // UPDATE
    public function updateRecord($order, $type, $ownerId, $bookId): void
    {
        if ($type == 'books') {
            $sql = "UPDATE gs_bm_order SET `order` = :order WHERE `type` = :type AND owner_id = :lId";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':order', $order, PDO::PARAM_STR);
            $stmt->bindValue(':type', $type, PDO::PARAM_STR);
            $stmt->bindValue(':lId', $ownerId, PDO::PARAM_INT);
        } else {
            $sql = "UPDATE gs_bm_order SET `order` = :order WHERE `type` = :type AND book_id = :book_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':order', $order, PDO::PARAM_STR);
            $stmt->bindValue(':type', $type, PDO::PARAM_STR);
            $stmt->bindValue(':book_id', $bookId, PDO::PARAM_INT);
        }
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
    }

    // DELETE
    public function deleteDogEarOrder($bookId)
    {
        $sql = "DELETE FROM gs_bm_order WHERE `type` = 'dog_ear' AND book_id = $bookId";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
    }

    public function deleteAllByOwnerId($ownerId)
    {
        $sql = "DELETE FROM gs_bm_order WHERE owner_id = $ownerId";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
    }
}
