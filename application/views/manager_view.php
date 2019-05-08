<head>
    <title>Manager</title>
    <link rel="stylesheet" href="../../../../../config/css/for_all.css">
    <link rel="stylesheet" href="../../../../../config/css/menu.css">
    <link rel="stylesheet" media="(max-width: 980px)" href="../../../../../config/css/menu_side.css">
    <link rel="stylesheet" href="../../../../../css/manager.css">
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
    <div class="tabs"><?php
        $tabs = '<span class="tab" style="{C}"><a href="/manager/comments">Comments</a></span>
                 <span class="tab" style="{V}"><a href="/manager/voting">Voting</a></span></div>
            <div class="comments">
            <div class="row"><h2>{TITLE}</h2>{PLUS}</div>  ';

        $vars = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($vars[2]) && (strcmp($vars[2], 'voting') == 0)) {
            $replace = '{V}';
            $title = "Votings";
            $plus = '<a href="/create_voting"><i class="fas fa-plus"></i></a>';
        } else {
            $replace = '{C}';
            $title = "New comments";
            $plus = '';
        }
        $tabs = str_replace('{TITLE}', $title, $tabs);
        $tabs = str_replace($replace, "background-color: white; box-shadow: 0 -1px 2px #585858;", $tabs);
        $tabs = str_replace('{PLUS}', $plus, $tabs);
        echo $tabs;
        ?>

        <form method="post" action="/manager/process">
            <?php
            $vars = explode('/', $_SERVER['REQUEST_URI']);

            if (!empty($vars[2]) && (strcmp($vars[2], 'voting') != 0)) {
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
            } else {
                $votings = '';
                foreach ($data as $voting) {
                    $item = "<article>
                                <h2>{NAME}</h2>
                                <div class=\"options\">
                                    <div class=\"option\">
                                        <div class=\"count\">{C1}</div>
                                        <div class=\"option_name\">{N1}</div>
                                    </div>
                                    <div class=\"option\">
                                        <div class=\"count\">{C2}</div>
                                        <div class=\"option_name\">{N2}</div>
                                    </div>
                                    <div class=\"option\">
                                        <div class=\"count\">{C3}</div>
                                        <div class=\"option_name\">{N3}</div>
                                    </div>
                                    <div class=\"option\">
                                        <div class=\"count\">{C4}</div>
                                        <div class=\"option_name\">{N4}</div>
                                    </div>
                                </div>
                            </article>";

                    $item = str_replace('{NAME}', $voting['name'], $item);

                    $options = explode("\n", $voting['info']);
                    for ($i = 1; $i <= 4; $i++) {
                        $item = str_replace("{C$i}", $voting["var$i"], $item);
                        $item = str_replace("{N$i}", $options[$i - 1], $item);
                    }
                    $votings .= $item;
                }
                if (!empty($votings)) {
                    print $votings;
//                    echo "<input type=\"submit\" name=\"accept\" id=\"accept\" value=\"Accept selected comments\">
//                      <input type=\"submit\" name=\"delete\" id=\"delete\" value=\"Delete selected comments\">";
                } else
                    echo "<p style=\"text-align: center\">There's no votings now</p>";
            }
            ?>
        </form>
    </div>
</main>
</body>