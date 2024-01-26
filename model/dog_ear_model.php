<?php
// 0. インポート
require_once __DIR__ . '/db_util.php';

class DogEarModel
{
    private DbUtil $dbUtil;
    private PDO $pdo;

    public function __construct()
    {
        $this->dbUtil = new DbUtil();
        $this->pdo = $this->dbUtil->db_conn();
    }

    // CREATE
    public function createRecord($bookId, $ownerId)
    {
        $sql = "INSERT INTO gs_bm_dog_ear(id, book_id, page_number, line_number, content, owner_id, created_date, update_date)
                VALUES(NULL, :book_id, '', '', '', :owner_id, sysdate(), sysdate())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->bindValue(':owner_id', $ownerId, PDO::PARAM_INT);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
        return $this->pdo->lastInsertId();
    }

    // READ
    public function readRecordByBookId($bookId)
    {
        $sql = "SELECT * FROM gs_bm_dog_ear WHERE book_id = $bookId";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute();
        $resAry = array();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        } else {
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resAry[$result['id']] = $result;
            }
            return $resAry;
        }
    }

    // UPDATE
    public function updateRecord($columnName, $changeVal, $dogEarId): void
    {
        $sql = "UPDATE gs_bm_dog_ear SET $columnName = :change_val, update_date = sysdate() WHERE id = :dog_ear_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':change_val', $changeVal, PDO::PARAM_STR);
        $stmt->bindValue(':dog_ear_id', $dogEarId, PDO::PARAM_INT);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
    }

    // DELETE
    public function deleteRecordByBookId($bookId): void
    {
        $sql = "DELETE FROM gs_bm_dog_ear WHERE book_id = $bookId";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
    }

    public function deleteRecordByDogEarId($dogEarId): void
    {
        $sql = "DELETE FROM gs_bm_dog_ear WHERE id = $dogEarId";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
    }
}
