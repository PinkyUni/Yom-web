<head>
    <title>Recipe</title>
    <link rel="stylesheet" href="../../../../../config/css/for_all.css">
    <link rel="stylesheet" href="../../../../../config/css/menu.css">
    <link rel="stylesheet" media="(max-width: 980px)" href="../../../../../config/css/menu_side.css">
    <link rel="stylesheet" href="../../../../../css/recipe.css">
</head>
<body>

<?php
include 'header.php';
?>

<main>
    <div class="main-container">
        <div class="basic-info">
            <h1><?php echo $data['name']?></h1>
            <div class="image">
                <img src="../../../../../img/users/<?php
                if (strcmp($data['img'], 'empty.jpg' ) != 0)
                    echo $_SESSION['session_username'] . '/' . $data['img'];
                else
                    echo $data['img'];
                ?>
                ">
            </div>
            <div class="cooking-info">
                <div class="cooking-el">
                    <span><?php echo $data['calories'] ?></span>
                    <span>Calories</span>
                </div>
                <span class="del"></span>
                <div class="cooking-el">
                    <span><?php echo $data['time'] ?></span>
                    <span>Time</span>
                </div>
                <span class="del"></span>
                <div class="cooking-el">
                    <span><?php echo $data['portions'] ?></span>
                    <span>Portions</span>
                </div>
            </div>
        </div>
        <div class="ingredients">
            <span class="section-title"><u>Ingredients:</u></span>
            <ul class="list">
                <?php
                $ingredients = explode("\n", $data['ingredients']);

                $list = '';
                foreach ($ingredients as $ingredient) {
                    $item = '<li>' . $ingredient . '</li>';
                    $list .= $item;
                }
                echo $list;
                ?>
            </ul>
        </div>
        <div class="cooking">
            <span class="section-title"><u>Cooking steps:</u></span>
            <ol class="list">
                <?php
                //                    $item = '<li>{INGREDIENT}</li>';
                $steps = explode("\n", $data['cooking']);

                $list = '';
                foreach ($steps as $step) {
                    $item = '<li>' . $step . '</li>';
                    $list .= $item;
                }
                echo $list;
                ?>
            </ol>
        </div>
    </div>
    <div class="comments">
        <h2>Comments:</h2>
        <div class="comment">
            <div class="col">
                <img src="../../../../../img/kek.jpg" class="user-icon">
            </div>
            <div class="col">
                <div class="username">{USERNAME}</div>
                <div class="comment-text">{COMMENT_TEXT}</div>
            </div>
        </div>
        <div class="comment">
            <div class="col">
                <img src="../../../../../img/kek.jpg" class="user-icon">
            </div>
            <div class="col">
                <div class="username">anyakek</div>
                <div class="comment-text">I'll try to cook it.<br>flksngln<br>lnlnl</div>
            </div>
        </div>
        <form id="comment-form" method="POST" action="">
            <div class="form-content">
                <div class="col">
                    <img src="../../../../../img/kek.jpg" class="user-icon">
                </div>
                <div class="textarea col">
                    <textarea form="comment-form" name="comment-text" placeholder="Leave a comment..."></textarea>
                </div>
            </div>
            <div class="submit">
                <input type="submit" value="Comment" name="place_comment">
            </div>
        </form>
    </div>
</main>

</body>