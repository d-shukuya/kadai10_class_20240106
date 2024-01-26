<?php
// 0. インポート
require_once __DIR__ . '/../vendor/autoload.php';

// .env ファイルから $_ENV の読み込み
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

class DbUtil
{
    //DB接続関数
    public function db_conn(): PDO
    {
        try {
            $db_name = $_ENV['DB_NAME'];
            $db_id   = $_ENV['DB_ID'];
            $db_pw   = $_ENV['DB_pw'];
            $db_host = $_ENV['DB_host'];
            return new PDO("mysql:dbname=$db_name;charset=utf8;host=$db_host", $db_id, $db_pw);
        } catch (PDOException $e) {
            exit('DB Connection Error:' . $e->getMessage());
        }
    }

    //SQLエラー関数
    public static function sql_error($stmt): void
    {
        $error = $stmt->errorInfo();
        exit('SQLError:' . print_r($error, true));
    }
}
