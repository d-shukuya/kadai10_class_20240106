<?php
// 0. インポート
require_once __DIR__ . '/db_util.php';

class BooksModel
{
    private DbUtil $dbUtil;
    private PDO $pdo;
    private string $bookCoverDir;

    public function __construct()
    {
        $this->dbUtil = new DbUtil();
        $this->pdo = $this->dbUtil->db_conn();
        $this->bookCoverDir = __DIR__ . '/../view/book_cover';
    }

    // CREATE
    public function createBookCoverFile($newId, $upFile): void
    {
        $newId12 = str_pad($newId, 12, "0", STR_PAD_LEFT);
        $this->updateBookCoverFile($newId12, $upFile);
    }

    public function createRecord($bookName, $bookUrl, $ownerId)
    {
        $sql = "INSERT INTO gs_bm_books(id, name, url, content, owner_id, created_date, update_date)
                VALUES (NULL, :name, :url, '', :ownerId, sysdate(), sysdate())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $bookName, PDO::PARAM_STR);
        $stmt->bindValue(':url', $bookUrl, PDO::PARAM_STR);
        $stmt->bindValue(':ownerId', $ownerId, PDO::PARAM_INT);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
        return $this->pdo->lastInsertId();
    }

    // READ
    public function readRecordByIdAndLoginId($id, $lId)
    {
        $sql = "SELECT * FROM gs_bm_books WHERE id = $id AND owner_id = $lId";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        } else {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function readRecordByLoginId($lId)
    {
        $sql = "SELECT * FROM gs_bm_books WHERE owner_id = $lId";
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
    public function updateBookCoverFile($bookId, $upFiles): void
    {
        if ($upFiles["book_cover_img"]["error"] == UPLOAD_ERR_OK) {
            // 既存のファイルを削除
            $files = glob("$this->bookCoverDir/$bookId.*");
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            // 新しいファイルを保管
            $tmp_name = $upFiles["book_cover_img"]["tmp_name"];
            $name = basename($upFiles["book_cover_img"]["name"]);
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $new_name = "$bookId.$extension";
            move_uploaded_file($tmp_name, $this->bookCoverDir . "/$new_name");
        } else {
            echo 'bb';
            exit;
            echo "Failed to save img file";
        }
    }

    public function updateRecord($columnName, $changeVal, $bookId): void
    {
        $sql = "UPDATE gs_bm_books SET $columnName = :change_val, update_date = sysdate() WHERE id = :book_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':change_val', $changeVal, PDO::PARAM_STR);
        $stmt->bindValue(':book_id', $bookId, PDO::PARAM_INT);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
    }

    // DELETE
    public function deleteBookCoverFile($bookId): void
    {
        $files = glob("$this->bookCoverDir/$bookId.*");
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    public function deleteRecord($bookId): void
    {
        $sql = "DELETE FROM gs_bm_books WHERE id = $bookId";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute();
        if ($status == false) {
            $this->dbUtil->sql_error($stmt);
        }
    }
}
