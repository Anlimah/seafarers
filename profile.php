<?php
session_start();
if (isset($_GET["action"]) && $_GET["action"] == "logout") {
    unset($_COOKIE['user']);
    unset($_SESSION["user"]);
    header("Location: index.php");
} elseif (!isset($_SESSION["user"])) {
    if (!isset($_COOKIE["user"]) || empty($_COOKIE["user"])) {
        header("Location: index.php");
    } else {
        $_SESSION["user"] = $_COOKIE["user"];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Pecs | Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="new.css">
    <style>
        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Modal Header */
        .modal-header {
            padding: 2px 16px;
            background-color: #003366;
            color: white;
        }

        /* Modal Body */
        .modal-body {
            padding: 2px 16px;
        }

        /* Modal Footer */
        .modal-footer {
            padding: 2px 16px;
            background-color: #003366;
            color: white;
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: 50% auto;
            /* 15% from the top and centered */
            /* Could be more or less, depending on screen size */
            padding: 0;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            animation-name: animatetop;
            animation-duration: 0.4s
        }

        /* Add Animation */
        @keyframes animatetop {
            from {
                top: -300px;
                opacity: 0
            }

            to {
                top: 0;
                opacity: 1
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <!-- LOGO -->
        <div class="logo">E-PECS</div>
        <!-- NAVIGATION MENU -->
        <ul class="nav-links">
            <!-- USING CHECKBOX HACK -->
            <input type="checkbox" id="checkbox_toggle" />
            <a for="checkbox_toggle" style="font-size: 16px;" href="?action=logout">Logout</a>
        </ul>
    </nav>

    <main>
        <?php

        require_once("classes/users_handler.php");
        $user = new UsersHandler();

        /*$user_info = $student->getStudentDataPermit($_SESSION["student"]);
        $threshold = $student->getThreshold();*/
        $user_info = $user->getProfileInfo($_SESSION["user"]);

        if ($user_info[0]["uID"]) {

            /*if ($threshold[0]["threshold"] < $result[0]["bal"])
            echo '
                    <div class="info-board ineligible">
                        Ineligible for permit card!
                    </div>
                ';
        else {
            echo '
                    <div class="info-board eligible">
                        Eligible for permit card!
                    </div>
                ';
        }*/
        ?>
            <div class="content-area">
                <div class="profile-card card">
                    <div class="profile-image">
                        <i class="user-image bi-person"></i>
                    </div>
                    <div class="profile-info">
                        <div class="profile-item">
                            <span class="text">NAME: </span>
                            <span class="u-name"><?= $user_info[0]["fullName"] ?></span>
                        </div>
                        <div class="profile-item">
                            <span class="text">EMAIL ADDRESS: </span>
                            <span class="u-index"><?= $user_info[0]["emailAddress"] ?></span>
                        </div>
                        <div class="profile-item">
                            <span class="text">PHONE NUMBER: </span>
                            <span class="u-course"><?= $user_info[0]["phoneNumber"] ?></span>
                        </div>
                        <div class="profile-item">
                            <span class="text">PASSPORT NUMBER: </span>
                            <span class="u-index"><?= $user_info[0]["passportNumber"] ?></span>
                        </div>
                        <div class="profile-item">
                            <span class="text">BOOK NUMBER: </span>
                            <span class="u-index"><?= $user_info[0]["bookNumber"] ?></span>
                        </div>
                    </div>
                </div>

                <div class="display: flex; flex-direction: row; width: 100%;margin: 0; padding: 0; justify-content: space-between;">
                    <button style="padding: 8px 10px" id="veriCode" name="veriCode" style="display: none;">Veirfy Code</button>
                    <button style="padding: 8px 10px" id="genCode" name="genCode">Generate Code</button>
                </div>
            </div>
        <?php
        }
        ?>

        <!--<div class="icon-bar">
            <a href="index.php">
                <i class="bi-house"></i>
            </a>
            <a href="check_balance.php">
                <i class="bi-cash-coin"></i>
            </a>
            <a href="profile.php" class="active">
                <i class="bi-person"></i>
            </a>
            <a href="../qrcode_scanner/">
                <i class="bi-upc-scan"></i>
            </a>
        </div>-->
        <!-- Modal content -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Send Code</h2>
                </div>
                <div class="modal-body">
                    <div class="emsms" style="display: flex; flex-direction: row; width: 100%;margin: 0; padding: 0; justify-content: space-around;">
                        <form id="submitSMS" method="post">
                            <button style="padding: 8px 10px" id="emailCode" name="emailCode">SMS</button>
                        </form>

                        <form id="submitEmail" method="post">
                            <button style="padding: 8px 10px" id="emailCode" name="emailCode">Email</button>
                        </form>
                    </div>
                    <p id="msg" style="display: none;"></p>

                    <form id="verifyCode" method="post" style="display:none">
                        <input style="padding: 8px 10px" type="text" name="code" id="code">
                        <button style="padding: 8px 10px" type="submit">Verify</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <h1></h1>
                </div>
            </div>

        </div>

    </main>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "api/u_codeChecker.php",
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {
                    console.log(result);
                    let res = JSON.parse(result);
                    if (res[0]["success"] == 1) {
                        alert("");
                        $("#gencode").hide();
                        $("#vericode").show();
                    } else {
                        $("#gencode").hide();
                        $("#vericode").show();
                    }
                },
                error: function(result) {
                    console.log(res[0]["error"]);
                }
            });

            // Get the modal
            var modal = document.getElementById("myModal");

            // Get the button that opens the modal
            var genCode = document.getElementById("genCode");

            // Get the button that opens the modal
            var veriCode = document.getElementById("veriCode");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on the button, open the modal
            genCode.onclick = function() {
                modal.style.display = "block";
            }

            // When the user clicks on the button, open the modal
            veriCode.onclick = function() {
                modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
                window.location.href = "profile.php";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                    window.location.href = "profile.php";
                }
            }

            $("#submitSMS").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "api/u_sendSMS.php",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result) {
                        console.log(result);
                        let res = JSON.parse(result);
                        $(".emsms").hide();
                        $("#msg").show();
                        $("#msg").append("A verification code has been sent to your phone number");
                    },
                    error: function(result) {
                        console.log(res[0]["error"]);
                    }
                });
            });

            $("#submitEmail").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "api/u_sendEmail.php",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result) {
                        console.log(result);
                        let res = JSON.parse(result);
                        $(".emsms").hide();
                        $("#msg").show();
                        $("#msg").append("A verification code has been sent to your mailbox");
                    },
                    error: function(result) {
                        console.log(res[0]["error"]);
                    }
                });
            });

            $("#password-card").click(function() {
                $("#change-password").toggle("modal");
            });

        });
    </script>
</body>

</html>