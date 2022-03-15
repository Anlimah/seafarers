<?php
session_start();

require_once('../classes/users_handler.php');
$user = new UsersHandler();

if (isset($_POST["ppNumber"]) && !empty($_POST["ppNumber"])) {
    if (isset($_POST["bkNumber"]) && !empty($_POST["bkNumber"])) {
        $result = $user->checkUser($_POST["ppNumber"], $_POST["bkNumber"]);
        if ($result == 0) {
            echo '[{"error":"Incorrect passport or book number!"}]';
        } else {
            $_SESSION["user"] = $result[0]["uID"];
            $_SESSION["login"] = true;
            echo '[{"success":"OK"}]';
        }
    }
}
