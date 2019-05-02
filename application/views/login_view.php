<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/login.css">
    <link rel="stylesheet" href="../../config/css/for_all.css">
    <link rel="stylesheet" href="../../config/css/menu.css">
    <link rel="stylesheet" media="(max-width: 980px)" href="../../config/css/menu_side.css">
</head>
<body">
<?php
    include 'header.php';
?>
<main>
    <div class="container">
        <form method="POST" action="/login" enctype="multipart/form-data">
            <div class="row">
                <h2 style="text-align:center">Login</h2>
                <div class="vl">
                    <span class="vl-innertext">or</span>
                </div>

                <div class="col">
                    <a href="#" class="fb btn">
                        <i class="fa fa-facebook fa-fw"></i> Login with Facebook
                    </a>
                    <a href="#" class="twitter btn">
                        <i class="fa fa-twitter fa-fw"></i> Login with Twitter
                    </a>
                    <a href="#" class="google btn"><i class="fa fa-google fa-fw">
                        </i> Login with Google+
                    </a>
                </div>

                <div class="col">
                    <div class="hide-md-lg">
                        <p>Or</p>
                    </div>

                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" value="Login" name="login">
                </div>

            </div>
        </form>
        <div class="bottom-container">
            <div class="row">
                <div class="col">
                    <a href="/register" style="color:white;" class="btn">Sign up</a>
                </div>
                <div class="col">
                    <a href="#" style="color:white" class="btn">Forgot password?</a>
                </div>
            </div>
        </div>
    </div>
</main>

