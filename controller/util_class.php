<?php
class Util
{
    // タグ名からbooksテーブルのカラム名を引き当てるテーブル
    public static $tagNameToBooksTableColumn = array(
        'book_name' => 'name',
        'book_url' => 'url',
        'book_memo' => 'content',
    );

    // タグ名からdog_earテーブルのカラム名を引き当てるテーブル
    public static $tagNameToDogEarTableColumn = array(
        'page_number' => 'page_number',
        'line_number' => 'line_number',
        'dog_ear_memo' => 'content',
    );

    //リダイレクト関数
    public static function redirect($fileName): void
    {
        // echo $fileName;
        // exit;
        header("Location: $fileName");
        exit();
    }

    // ログイン済みフラグ
    public static function isLogin(): bool
    {
        if (!isset($_SESSION["chk_ssid"]) || !isset($_SESSION["id"]) || !isset($_SESSION["u_name"]) || $_SESSION["chk_ssid"] != session_id()) {
            return false;
        } else {
            return true;
        }
    }

    // ログイン済みのセッションかをチェック
    public static function checkSession($relativePathToTop)
    {
        if (Util::isLogin()) {
            session_regenerate_id(true);
            $_SESSION["chk_ssid"] = session_id();
        } else {
            Util::redirect("$relativePathToTop/login.php?err=session_err");
        }
    }

    // ログインユーザーがオーナーのレコードかをチェック
    public static function checkOwner($res)
    {
        if (!isset($res["id"]) || $res["owner_id"] !== $_SESSION["id"]) {
            Util::redirect('../');
        }
    }

    // 指定の文字列を除去し、JSON形式へ変換
    public static function removeIdFromAry($ary, $id)
    {
        // 該当のidを取り除く
        $removedAry = array_filter($ary, function ($item) use ($id) {
            return $item != $id;
        });

        // keyが連続するように置き換え。これをやらないとエンコードの際に連想配列になる
        $removedAry = array_values($removedAry);

        // 要素の方を INT 型に変換
        $removedAry = array_map('intval', $removedAry);

        // JSON化
        return json_encode($removedAry);
    }
}
