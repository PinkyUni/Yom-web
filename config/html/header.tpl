<nav>
	<a class="title" href="../main/main.html">Yom</a>
	<ul class="main-menu">
		<a href="../recipes/recipes.html"><li>Recipes</li></a>
		<a href="../ingredients/ingredients.html"><li>Ingredients</li></a>
		<a href="../ideas/ideas.html"><li>Ideas</li></a>
		<a href="" title="Your profile"><img class="user-icon" src="../kek.jpg"></a>
	</ul>
	<span class="button-menu" onclick="openNav()">&#9776;</span>
	<div id="mySidenav" class="sidenav">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		<a href="../recipes/recipes.html">Recipes</a>
		<a href="../ingredients/ingredients.html">Ingredients</a>
		<a href="../ideas/ideas.html">Ideas</a>
		<a href="../login/login.html">Login</a>
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