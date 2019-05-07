<nav>
    <a class="title" href="/">Yom</a>
    <ul class="main-menu"><?php
        if (strstr($_SERVER['REQUEST_URI'], "/user_recipes")) {
            $search = '<form method="POST" action="/user_recipes">
                            <div class="row">
                                <input type="search" autocomplete="off" name="searching" placeholder="Search" id="search">
                                <label for="btn" id="btnLabel"><i class="fa fa-search"></i></label>
                                <input type="submit" name="search" id="btn">
                            </div> 
                        </form>';
            echo $search;
        }
        ?>
        <li><a href="/recipes">Recipes</a></li>
        <li><a href="/ingredients">Ingredients</a></li>
        <li><a href="/ideas">Ideas</a></li>
        <a href="<?php
        if (isset($_SESSION['session_username']) && $_SESSION['session_username'] == 'admin')
            echo "/comments_manager";
        else
            echo "/profile";
        ?>" title="Your profile"><img class="user-icon" alt="Your profile"
                                      src="<?php if (strstr($_SERVER['REQUEST_URI'], "/recipe/")) echo "../../../"; ?>../../img/users/<?php
                                      if (!isset($_SESSION['session_username'])) {
                                          echo 'cat-profile.png';
                                      } elseif (strcmp($_SESSION['user_img'], 'empty.jpg') != 0) {
                                          echo $_SESSION['session_username'] . '/' . $_SESSION['user_img'];
                                      } else {
                                          echo $_SESSION['user_img'];
                                      }
                                      ?>"</a>
    </ul>
    <span class="button-menu" onclick="openNav()">&#9776;</span>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="/recipes">Recipes</a>
        <a href="/ingredients">Ingredients</a>
        <a href="/ideas">Ideas</a>
        <a href="/login">Login</a>
    </div>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>
</nav>