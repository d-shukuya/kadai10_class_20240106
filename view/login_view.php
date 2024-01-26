<?php
class LoginView
{
    public function getErrMessage($getAry): string
    {
        $errMessage = '';

        if (isset($getAry["err"])) {
            switch ($getAry["err"]) {
                case 'login_err':
                    $errMessage = "username または password が違います。";
                    break;

                case 'session_err':
                    $errMessage = "ログインしてください。";
                    break;
            }
        }

        return $errMessage;
    }
}
