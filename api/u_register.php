<?php
session_start();

require_once('../classes/users_handler.php');
$user = new UsersHandler();

if (isset($_POST["firstName"]) && !empty($_POST["firstName"])) {
    if (isset($_POST["lastName"]) && !empty($_POST["lastName"])) {
        if (isset($_POST["emailAddr"]) && !empty($_POST["emailAddr"])) {
            if (isset($_POST["phNumber"]) && !empty($_POST["phNumber"])) {
                if (isset($_POST["ppNumber"]) && !empty($_POST["ppNumber"])) {
                    if (isset($_POST["bkNumber"]) && !empty($_POST["bkNumber"])) {

                        $fname = $user->validateInput($_POST["firstName"]);
                        $lname = $user->validateInput($_POST["lastName"]);
                        $email = $user->validateEmail($_POST["emailAddr"]);
                        $phone = $user->validateInput($_POST["phNumber"]);
                        $passp = $user->validateInput($_POST["ppNumber"]);
                        $bookn = $user->validateInput($_POST["bkNumber"]);

                        $result = $user->addUserData($fname, $lname, $email, $phone, $passp, $bookn);
                        if ($result == -1) {
                            echo '[{"error":"An account already exist with this details!"}]';
                        } elseif ($result == 0) {
                            echo '[{"error":"Failed to add user data!"}]';
                        } elseif ($result == 1) {
                            $_SESSION["login"] = true;
                            $_SESSION["user"] = $result;
                            echo '[{"success":"User successfully added! "}]';
                        }
                    }
                }
            }
        }
    }
}
