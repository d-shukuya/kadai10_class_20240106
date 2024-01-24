<?php
$errMessage = "";
if (isset($_GET["err"])) {
    switch ($_GET["err"]) {
        case 'login_err':
            $errMessage = "username または password が違います。";
            break;

        case 'session_err':
            $errMessage = "ログインしてください。";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DogEarApp.</title>
    <link rel="stylesheet" href="../css/style_login.css">
</head>

<body>
    <form action="./login_act.php" method="post">
        <div class="grad"></div>
        <div class="header">
            <img src="../img/logo.png" alt="">
        </div>
        <br>
        <fieldset>
            <div class="login">
                <input type="text" placeholder="username" name="l_id"><br>
                <input type="password" placeholder="password" name="l_pw"><br>
                <input type="submit" value="Login">
            </div>
        </fieldset>
    </form>
    <p id="err_message"><?=$errMessage?></p>
</body>

</html>