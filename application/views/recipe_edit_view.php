<head>
    <title>Recipe</title>
    <link rel="stylesheet" href="../../../../../config/css/for_all.css">
    <link rel="stylesheet" href="../../../../../config/css/menu.css">
    <link rel="stylesheet" media="(max-width: 980px)" href="../../../../../config/css/menu_side.css">
    <link rel="stylesheet" href="../../../../../css/recipe.css">
</head>
<body>

<?php
$header = file_get_contents('application/views/header.php');
$header = str_replace('../../', '../../../../../', $header);

print $header;
?>

<main>
    <div class="main-container">
        <div class="basic-info">
            <h1><?php echo $data['recipe']['name'] ?></h1>
            <div class="image">
                <img src="../../../../../img/users/<?php
                if (strcmp($data['recipe']['img'], 'empty.jpg') != 0)
                    echo $data['recipe']['username']. '/' . $data['recipe']['img'];
                else
                    echo $data['recipe']['img'];
                ?>
                ">
            </div>
            <div class="cooking-info">
                <div class="cooking-el">
                    <span><?php echo $data['recipe']['calories'] ?></span>
                    <span>Calories</span>
                </div>
                <span class="del"></span>
                <div class="cooking-el">
                    <span><?php echo $data['recipe']['time'] ?></span>
                    <span>Time</span>
                </div>
                <span class="del"></span>
                <div class="cooking-el">
                    <span><?php echo $data['recipe']['portions'] ?></span>
                    <span>Portions</span>
                </div>
            </div>
        </div>
        <div class="ingredients">
            <span class="section-title"><u>Ingredients:</u></span>
            <ul class="list">
                <?php
                $ingredients = explode("\n", $data['recipe']['ingredients']);

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
                $steps = explode("\n", $data['recipe']['cooking']);

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
        <?php

        $comments = '';
        foreach ($data['comments'] as $comment) {
            $item = '<div class="comment">
                        <div class="col">
                            <img src="../../../../../img/users/{IMAGE}" class="user-icon">
                        </div>
                        <div class="col info">
                            <div class="row">
                                <div class="username">{USERNAME}</div>
                                <div class="time">{TIME}</div>
                            </div>
                            <div class="comment-text">{COMMENT_TEXT}</div>
                        </div>
                    </div>';

            $item = str_replace("{IMAGE}", $comment['img'], $item);
            $item = str_replace("{USERNAME}", $comment['username'], $item);

            $lines = explode("\n", $comment['text']);
            $text = '';
            foreach ($lines as $line)
            {
                $text .= $line . '<br>';
            }

            $item = str_replace("{COMMENT_TEXT}", $text, $item);
            $item = str_replace("{TIME}", $comment['time'], $item);

            $comments .= $item;
        }

        print $comments;

        ?>

        <form id="comment-form" method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
            <div class="form-content">
                <div class="col">
                    <img src="../../../../../img/users/kek.jpg" class="user-icon">
                </div>
                <div class="textarea col">
                    <textarea form="comment-form" name="comment-text" placeholder="Leave a comment..."
                              required></textarea>
                </div>
            </div>
            <div class="submit">
                <input type="submit" value="Comment" name="place">
            </div>
        </form>
    </div>
</main>

</body>