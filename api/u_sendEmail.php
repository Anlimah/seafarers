<?php
session_start();

require_once('../classes/users_handler.php');
$user = new UsersHandler();

if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
    echo '[{"msg":"Your verification code is ' . $user->addQRCode($_SESSION["user"]) . '"}]';
    //send to email
} else {
    echo '[{"redirect":"OK"}]';
}
