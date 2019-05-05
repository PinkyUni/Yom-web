<head>
    <title>Recipe</title>
    <link rel="stylesheet" href="../../../../../config/css/for_all.css">
    <link rel="stylesheet" href="../../../../../config/css/menu.css">
    <link rel="stylesheet" media="(max-width: 980px)" href="../../../../../config/css/menu_side.css">
    <link rel="stylesheet" href="../../../../../css/recipe-edit.css">
</head>
<body>

<?php
include 'header.php';
?>

<?php $uri = $_SERVER['REQUEST_URI']; $uri = str_replace('recipe_edit', 'recipe', $uri); $_SESSION['new_uri'] = $uri;?>
<main>
    <div class="main-container">
        <form id="EditRecipe" method="POST" action="/recipe_edit/save_changes" enctype="multipart/form-data">
            <div class="basic-info">
                <input class="recipe-name" type="text" value="<?php echo $data['recipe']['name'] ?>" name="name" required>
                <div class="image">
                    <img src="../../../../../img/users/<?php
                    if (strcmp($data['recipe']['img'], 'empty.jpg') != 0)
                        echo $data['recipe']['username'] . '/' . $data['recipe']['img'];
                    else
                        echo $data['recipe']['img'];
                    ?>
                    ">
                </div>
                <div class="cooking-info">
                    <div class="cooking-el">
                        <input type="number" value="<?php echo $data['recipe']['calories'] ?>" name="calories" required>
                        <span>Calories</span>
                    </div>
                    <span class="del"></span>
                    <div class="cooking-el">
                        <input type="text" value="<?php echo $data['recipe']['time'] ?>" name="time" required>
                        <span>Time</span>
                    </div>
                    <span class="del"></span>
                    <div class="cooking-el">
                        <input type="text" value="<?php echo $data['recipe']['portions'] ?>" name="portions" required>
                        <span>Portions</span>
                    </div>
                </div>
            </div>
            <div class="ingredients">
                <label for="ingredients" class="section-title"><u>Ingredients:</u></label>
                <textarea id="ingredients" form="EditRecipe" name="ingredients" required><?php
                    $ingredients = explode("\n", $data['recipe']['ingredients']);

                    foreach ($ingredients as $ingredient) {
                        echo $ingredient;
                    }
                    ?></textarea>
            </div>
            <div class="cooking">
                <label for="steps" class="section-title"><u>Cooking steps:</u></label>
                <textarea id="steps" form="EditRecipe" name="cooking" required><?php
                    $steps = explode("\n", $data['recipe']['cooking']);

                    foreach ($steps as $step) {
                        echo $step;
                    }
                    ?>
                </textarea>
            </div>
            <input type="submit" value="Save changes" name="save_recipe">
            <input type="submit" value="Delete recipe" name="delete_recipe">
        </form>
    </div>
</main>
</body>