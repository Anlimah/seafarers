<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Sea</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <div class="title">Register</div>
        <div class="content">
            <form enctype="multipart/form-data">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" name="firstName" id="firstName" placeholder="Enter your first name" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Last Name</span>
                        <input type="text" name="lastName" id="lastName" placeholder="Enter your last name" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Email Address</span>
                        <input type="text" name="emailAddr" id="emailAddr" placeholder="Enter your email address" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Phone Number</span>
                        <input type="text" name="phNumber" id="phNumber" placeholder="Enter your phone number" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Passport Number</span>
                        <input type="text" name="ppNumber" id="ppNumber" placeholder="Enter your passport number" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Book Number</span>
                        <input type="text" name="bkNumber" id="bkNumber" placeholder="Enter your book number" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Register">
                </div>
                <div>
                    <span>Don't have an account?</span> <a href="index.php">Login</a>
                </div>
                <?php
                $digits = 10;
                $code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                ?>
                <input type="hidden" name="url-t" id="url-t" value="<?= $code ?>">
            </form>
        </div>
    </div>
    <script src="js/jquery-2.2.3.min.js"></script>
    <script>
        $(document).ready(function() {
            $("form").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "api/u_register.php",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result) {
                        console.log(result);
                        let res = JSON.parse(result);
                        if (res[0]["success"]) {
                            window.location.href = "index.php";
                        } else {
                            console.log(res[0]["error"])
                        }
                    },
                    error: function(result) {
                        console.log(result);
                    }
                });
            });
        });
    </script>
</body>

</html>