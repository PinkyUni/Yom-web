<head>
    <title>Adding the recipe</title>
    <link rel="stylesheet" href="../../css/addRecipe.css">
    <link rel="stylesheet" href="../../config/css/for_all.css">
    <link rel="stylesheet" href="../../config/css/menu.css">
    <link rel="stylesheet" media="(max-width: 1200px)" href="../../config/css/menu_side.css">
</head>
<body>

<?php
    include 'header.php';
?>

<main>
    <section class="main-img" id="main-img">
        <div class="el">
            <input type="text" name="name" placeholder="Name" form="recipeForm" maxlength="100" autocomplete="off" required>
        </div>
    </section>
    <div class="container">
        <div class="delimetr"><img src="../../img/delimetr_top.png"></div>
        <form id="recipeForm" method="POST" action="/add_recipe" enctype="multipart/form-data">
            <section class="additional-info">
                <div class="form-element">
                    <label for="calories">Calories</label>
                    <input type="number" name="calories" id="caloris" placeholder="143" required>
                </div>
                <div class="form-element">
                    <label for="time">Time</label>
                    <input type="time" name="time" id="time" required>
                </div>
                <div class="form-element">
                    <label for="portions">Portions</label>
                    <input type="text" name="portions" id="portions" placeholder="4" required>
                </div>
            </section>
            <section class="main-info">
                <script type="text/javascript">
                    var textAreas = document.getElementsByTagName('textarea');
                    Array.prototype.forEach.call(textAreas, function(elem) {
                        elem.placeholder = elem.placeholder.replace(/\\n/g, '\n');
                    });
                </script>
                <div class="ingredients">
                    <textarea form="recipeForm" name="ingredients" placeholder="Flour 100g" required></textarea>
                </div>
                <div class="cooking">
                    <textarea form="recipeForm" name="cooking" required placeholder="1. Prepare all ingredients..."></textarea>
                </div>
            </section>
            <div class="comment">* Please enter each ingredient and cooking step <b>from new line</b> for better understanding :)</div>
            <section class="load-photo">
                <input type="file" name="inputfile" id="file">
                <label for="file" class="load-label">Choose a photo</label>
            </section>
            <section class="submit">
                <input type="submit" value="ADD" name="add_recipe">
            </section>
        </form>
        <script>
            function handleFileSelectSingle(evt) {
                var file = evt.target.files; // FileList object
                var f = file[0];

                if (!f.type.match('image.*')) {
                    alert("Только изображения....");
                }

                var reader = new FileReader();

                reader.onload = (function(theFile) {
                    return function(e) {

                        document.getElementById('main-img').style.backgroundImage = "url(" + e.target.result + ")";
                    };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
            }
            document.getElementById('file').addEventListener('change', handleFileSelectSingle, false);
        </script>
        <div class="delimetr"><img src="../../img/delimetr_bottom.png"></div>
    </div>
</main>