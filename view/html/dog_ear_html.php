<?php
// 0. インポート
require_once __DIR__ . '/../funcs.php';

$hBookId12 = h($bookId12);
$hBookName = h($bookName);
$hBookUrl = h($bookUrl);
$hBookMemo = h($bookMemo);
$hCreatedDateBooks = h(substr($createdDateBooks, 0, 10));
$hUpdateDateBooks = h(substr($updateDateBooks, 0, 10));
$hOrderColumnJSON = h($orderColumnJSON);
$files = glob("../view/book_cover/$bookId12.*");
$bookCoverImg = (count($files) > 0) ? $files[0] : '../view/book_cover/sample_cover.png';
$hBookCoverImg = h($bookCoverImg);
$hDogEarOrderColumnJSON = h($dogEarOrderColumnJSON)
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $hBookName ?></title>
    <link rel="stylesheet" href="../view/css/reset.css">
    <link rel="stylesheet" href="../view/css/style_dog_ear.css">
</head>

<body>
    <header>
        <div id="top_btn">DogEarApp.</div>
        <h1 id="book_name" data-book_id=<?= $hBookId12 ?> contenteditable="true"><?= $hBookName ?></h1>
        <div id="book_cover_box">
            <img id='book_cover_img' src="<?= $hBookCoverImg ?>" alt="">
            <input type="file" id="img_upload" accept="image/*" name="book_cover_img" data-book_id=<?= $hBookId12 ?>>
        </div>
        <div id="book_url_box" class="book_url_box_fmt">
            <a id="book_url" href='<?= $hBookUrl ?>'>外部リンク</a>
            <img id="book_url_edit_btn" src="../view/img/edit.png" alt="">
        </div>
        <div id="book_url_edit_box" class="book_url_box_fmt">
            <input id="book_url_update" type="text" name="book_url_update">
            <div id="book_url_ok" class="book_url_btn" data-book_id=<?= $hBookId12 ?>>○</div>
            <div id="book_url_cancel" class="book_url_btn">×</div>
        </div>
        <h2>書籍のメモ</h2>
        <textarea id="book_memo" name="book_memo" data-book_id=<?= $hBookId12 ?>><?= $hBookMemo ?></textarea>
        <div id='book_date_info'>
            <p>登録日： <?= $hCreatedDateBooks ?></p>
            <p>更新日： <?= $hUpdateDateBooks ?></p>
        </div>
        <div id="book_delete_btn" data-book_id=<?= $hBookId12 ?> data-books_order=<?= $hOrderColumnJSON ?>>本を削除</div>
    </header>

    <nav>
        <form action="../controller/act_list/insert_dog_ear.php" method="post">
            <fieldset>
                <input type="hidden" name="book_id" value=<?= $hBookId12 ?>></input>
                <input type="hidden" id="dog_ear_order" name="dog_ear_order" value="<?= $hDogEarOrderColumnJSON ?>">
                <input id="add_dog_ear_btn" type="submit" value="ドッグイヤー追加">
            </fieldset>
        </form>
    </nav>

    <main>
        <ul id="dog_ear_list" data-book_id="<?= $hBookId12 ?>"><?= $view ?></ul>
    </main>

    <!-- JSの読み込み -->
    <script src="../view/js/jquery-2.1.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="../view/js/script_dog_ear.js"></script>
</body>

</html>