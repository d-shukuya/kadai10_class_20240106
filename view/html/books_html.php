<?php
// 0. インポート
require_once __DIR__ . '/../funcs.php';

$hLName = h($lName);
$hOrderColumnJSON = h($orderColumnJSON);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DogEarApp.</title>
    <link rel="stylesheet" href="../view/css/reset.css">
    <link rel="stylesheet" href="../view/css/style_book.css">
</head>

<body>
    <header>
        <div id="account_box">
            <p>user：</p>
            <div id="account_name"><?= $hLName ?></div>
            <button id="logout">Logout</button>
        </div>
        <img src="../view/img/logo.png" alt="">
        <h1>DogEarApp.</h1>
    </header>

    <nav>
        <form id="insert_book_form" action="../controller/act_list/insert_book.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <div id="register_book_box">
                    <h2>書籍の登録</h2>
                    <p id="book_name_label" class="label_fmt">書籍名：</p>
                    <div id="book_name" class="textbox_fmt"><input class="input_textbox" type="text" name="name" required></div>
                    <p id="book_url_label" class="label_fmt">リンク：</p>
                    <div id="book_url" class="textbox_fmt"><input class="input_textbox" type="text" name="url"></div>
                    <div id="book_cover_box"><img id="book_cover_img" src="../view/img/input_img.png" alt=""></div>
                    <input type="file" id="img_upload" accept="image/*" name="book_cover_img">
                    <input type="hidden" id="books_order" name="books_order" value="<?= $hOrderColumnJSON ?>">
                    <div id="book_register_btn"><input class="button" type="submit" value="登録"></div>
                </div>
            </fieldset>
        </form>
    </nav>

    <main>
        <ul id="book_list"><?= $view ?></ul>
    </main>

    <!-- JSの読み込み -->
    <script src="../view/js/jquery-2.1.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="../view/js/script_book.js"></script>
</body>

</html>