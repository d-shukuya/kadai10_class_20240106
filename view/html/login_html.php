<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DogEarApp.</title>
    <link rel="stylesheet" href="../view/css/style_login.css">
</head>

<body>
    <form action="../controller/act_list/login_act.php" method="post">
        <div class="grad"></div>
        <div class="header">
            <img src="../view/img/logo.png" alt="">
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
    <div id="register">Register</div>
    <p id="err_message"><?=$errMessage?></p>

    <!-- JSの読み込み -->
    <script src="../view/js/jquery-2.1.3.min.js"></script>
    <script src="../view/js/script_login.js"></script>
</body>

</html>