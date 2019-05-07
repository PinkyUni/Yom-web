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
    <div class="comments">
        <h2>New comments:</h2>
        <?php

        $comments = '';
        foreach ($data['comments'] as $comment) {
            $item = '<div class="comment">
                        <div class="col info">
                            <div class="comment-text">{COMMENT_TEXT}</div>
                        </div>
                    </div>';

            $lines = explode("\n", $comment['text']);
            $text = '';
            foreach ($lines as $line) {
                $text .= $line . '<br>';
            }

            $item = str_replace("{COMMENT_TEXT}", $text, $item);
            $comments .= $item;

        }

        print $comments;

        ?>
    </div>
</main>
</body>