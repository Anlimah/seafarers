<?php
session_start();

require_once('../classes/users_handler.php');
$user = new UsersHandler();

if ($user->checkCode($_SESSION["user"])) {
    if ($user->checkCode($_SESSION["user"])) {
        echo '[{"success":"1"}]';
    } else {
        echo '[{"error":"0"}]';
    }
} else {
    echo 0;
}
