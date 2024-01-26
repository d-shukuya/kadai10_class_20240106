<?php
// 0. インポート
require_once __DIR__ . '/funcs.php';

class BooksView
{
    public function createView($result, $view): string
    {
        $id12 = str_pad($result['id'], 12, "0", STR_PAD_LEFT);
        $files = glob("../view/book_cover/$id12.*");
        $coverImgPath = (count($files) > 0) ? $files[0] : '../view/book_cover/sample_cover.png';
        $createdDate = substr($result['created_date'], 0, 10);
        $updateDate = substr($result['update_date'], 0, 10);

        $view .= "<li class='book_item' id='" . h($id12) . "'>";
        $view .=    "<h3>" . h($result['name']) . "</h3>";
        $view .=    "<div class='book_cover'><img src='" . $coverImgPath . "'></div>";
        if (!is_null($result['url']) && $result['url'] != "") {
            $view .= "<a href='" . h($result['url']) . "'>外部リンク</a>";
        };
        $view .=    "<div class='date_info'>";
        $view .=        "<p>登録日： " . h($createdDate) . "</p>";
        $view .=        "<p?>更新日： " . h($updateDate) . "</p>";
        $view .=    "</div>";
        $view .= "</li>";
        return $view;
    }
}
