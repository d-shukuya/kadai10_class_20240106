<?php
//XSS対応（ echoする場所で使用 ）
function h($val)
{
    return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}