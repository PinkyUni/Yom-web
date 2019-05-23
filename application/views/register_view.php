<head>
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../css/register.css">
    <link rel="stylesheet" href="../../config/css/for_all.css">
    <link rel="stylesheet" href="../../config/css/menu.css">
    <link rel="stylesheet" media="(max-width: 980px)" href="../../config/css/menu_side.css">
</head>
<body>
<?php
include 'header.php';
?>
<main>
    <div class="container">
        <form method="POST" action="/register" enctype="multipart/form-data">
            <h2>Register</h2>
            <input type="text" name="username" placeholder="Username" required>
            <div style="font-size: 1vw;">* Letters, digits and symbols like '-', '_' and '.' are allowed only.</div>
            <input type="password" name="password" id="password1" placeholder="Password" required>
            <input type="password" name="confirm_password" id="password2" placeholder="Confirm password" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <?php if (isset($_SESSION['session_username']) && isset($_SESSION['admin_level']) && $_SESSION['admin_level'] = 10) {
                echo'<input type="number" name="admin_level" placeholder="Admin_level" required>';
            } else {
                echo '<div>
                        <input id="checkbox" type="checkbox" name="checkbox">
                        <label for="checkbox">Subscribe to our newsletter</label>
                    </div>';
            } ?>
            <section class="load-photo">
                <input type="file" name="inputfile" id="file">
                <label for="file" class="load-label">Choose a photo</label>
            </section>
            <div style="color: red; text-align: center"><?php if (!empty($data)) echo $data;?></div>
            <input type="submit" value="Register" name="register">
        </form>
    </div>
    <script type="text/javascript">
        window.onload = function () {
            document.getElementById("password1").onkeyup = validatePassword;
            document.getElementById("password2").onkeyup = validatePassword;
        };

        function validatePassword() {
            var pass2 = document.getElementById("password2").value;
            var pass1 = document.getElementById("password1").value;
            if ((pass1 == pass2) && (pass1.length != 0) && (pass2.length != 0)) {
                document.getElementById("password2").style.backgroundImage = "url(img/check-circle-regular.svg)";
                document.getElementById("password2").style.border = "";
                document.getElementById("password1").style.backgroundImage = "url(img/check-circle-regular.svg)";
                document.getElementById("password1").style.border = "";
            } else {
                document.getElementById("password2").style.backgroundImage = "";
                document.getElementById("password2").style.border = "1px solid red";
                document.getElementById("password1").style.backgroundImage = "";
                document.getElementById("password1").style.border = "1px solid red";
            }
        }
    </script>
</main>