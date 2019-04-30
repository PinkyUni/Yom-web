<nav>
    <a class="title" href="/">Yom</a>
    <ul class="main-menu">
        <li><a href="/recipes">Recipes</a></li>
        <li><a href="/ingredients">Ingredients</a></li>
        <li><a href="/ideas">Ideas</a></li>
        <a href="/profile" title="Your profile"><img class="user-icon" src="../../img/kek.jpg"></a>
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
            document.getElementById("main").style.marginLeft= "0";
        }
    </script>
</nav>