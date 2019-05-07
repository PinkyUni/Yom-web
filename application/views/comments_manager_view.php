<head>
    <title>Recipe</title>
    <link rel="stylesheet" href="../../../../../config/css/for_all.css">
    <link rel="stylesheet" href="../../../../../config/css/menu.css">
    <link rel="stylesheet" media="(max-width: 980px)" href="../../../../../config/css/menu_side.css">
    <link rel="stylesheet" href="../../../../../css/comments_manager.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css"
          integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
</head>
<body>

<?php
include 'header.php';
?>

<main>
    <a href="/login/logout">
        <div class="btn_out"><i class="fas fa-sign-out-alt"></i>Log out</div>
    </a>
    <div class="comments">
        <h2>New comments:</h2>
        <form method="post" action="/comments_manager/process">
            <?php

            $comments = '';
            foreach ($data as $comment) {
                $item = '<div class="comment">
                            <div>{COMMENT_TEXT}</div>
                            <input type="checkbox" name="comments[]" value="{ID}">
                         </div>';

                $lines = explode("\n", $comment['text']);
                $text = '';
                foreach ($lines as $line) {
                    $text .= $line . '<br>';
                }
                $item = str_replace("{COMMENT_TEXT}", $text, $item);

                $item = str_replace("{ID}", $comment['id'], $item);
                $comments .= $item;
            }
            if (!empty($comments)) {
                print $comments;
                echo "<input type=\"submit\" name=\"accept\" id=\"accept\" value=\"Accept selected comments\">
                      <input type=\"submit\" name=\"delete\" id=\"delete\" value=\"Delete selected comments\">";
            } else
                echo "<p style=\"text-align: center\">There's no new comments</p>";
            ?>
        </form>
    </div>
</main>
</body>