<?php
// 0. インポート
require_once __DIR__ . '/funcs.php';

class DogEarView
{
    public function createView($bookId, $result, $view, $dogEarOrderColumnJSON): string
    {
        $hBookId = h($bookId);
        $hDogEarId12 = h(str_pad($result['id'], 12, "0", STR_PAD_LEFT));
        $hPageNumber = h($result['page_number']);
        $hLineNumber = h($result['line_number']);
        $hDogEarMemo = h($result['content']);
        $hCreatedDateDogEar = h(substr($result['created_date'], 0, 10));
        $hUpdateDateDogEar = h(substr($result['update_date'], 0, 10));
        $hDogEarOrderJSON = h($dogEarOrderColumnJSON);

        $view .= "<li id='$hDogEarId12' class='dog_ear_item'>";
        $view .=    "<div class='left_block'>";
        $view .=        "<div class='input_fmt'>";
        $view .=            "<label>ページ：</label>";
        $view .=            "<input type='text' name='page_number' data-dog_ear_id='$hDogEarId12' value='$hPageNumber'>";
        $view .=        "</div>";
        $view .=        "<div class='input_fmt'>";
        $view .=            "<label>行：</label>";
        $view .=            "<input type='text' name='line_number' data-dog_ear_id='$hDogEarId12' value='$hLineNumber'>";
        $view .=        "</div>";
        $view .=        "<div class='dog_ear_date_info'>";
        $view .=            "<p>登録日： $hCreatedDateDogEar</p>";
        $view .=            "<p>更新日： $hUpdateDateDogEar</p>";
        $view .=        "</div>";
        $view .=    "</div>";
        $view .=    "<div class='dog_ear_memo_box'>";
        $view .=        "<label>メモ：</label>";
        $view .=        "<textarea name='dog_ear_memo' data-dog_ear_id='$hDogEarId12'>$hDogEarMemo</textarea>";
        $view .=    "</div>";
        $view .=    "<div class='delete_dog_ear' data-book_id='$hBookId' data-dog_ear_id='$hDogEarId12' data-dog_ear_order='$hDogEarOrderJSON'>削除</div>";
        $view .= "</li>";
        return $view;
    }
}
