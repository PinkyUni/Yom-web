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
        $tabs = '<span class="tab" style="{U}"><a href="/manager/users">Users</a></span>
                 <span class="tab" style="{R}"><a href="/manager/recipes">Recipes</a></span>
                 <span class="tab" style="{C}"><a href="/manager/comments">Comments</a></span>
                 <span class="tab" style="{V}"><a href="/manager/voting">Voting</a></span>';
        if ($_SESSION['admin_level'] == 10)
            $tabs .= '<span class="tab" style="{A}"><a href="/manager/admins">Admins</a></span></div>';
        $tabs .= '</div><div class="comments"><div class="row"><h2>{TITLE}</h2>{PLUS}</div>';

        $vars = explode('/', $_SERVER['REQUEST_URI']);

        if (empty($vars[2]))
            $vars[2] = 'comments';
        switch ($vars[2]) {
            case 'voting':
                $replace = '{V}';
                $title = "Votings";
                $plus = '<a href="/create_voting"><i class="fas fa-plus"></i></a>';
                break;
            case 'recipes':
                $replace = '{R}';
                $title = "Recipes";
                $plus = '<a href="/add_recipe"><i class="fas fa-plus"></i></a>';
                break;
            case 'comments':
                $replace = '{C}';
                $title = "New comments";
                $plus = '';
                break;
            case 'users':
                $replace = '{U}';
                $title = "Users";
                $plus = '<a href="/register"><i class="fas fa-plus"></i></a>';
                break;
            case 'admins':
                $replace = '{A}';
                $title = "Admins";
                $plus = '<a href="/register"><i class="fas fa-plus"></i></a>';
                break;
        }

        $tabs = str_replace('{TITLE}', $title, $tabs);
        $tabs = str_replace($replace, "background-color: white; box-shadow: 0 -1px 2px #585858;", $tabs);
        $tabs = str_replace('{PLUS}', $plus, $tabs);
        echo $tabs;
        ?>

        <form method="post" action="/manager/process">
            <?php
            $vars = explode('/', $_SERVER['REQUEST_URI']);

            if (!empty($vars[2]) && (strcmp($vars[2], 'admins') == 0)) {
                $admins = '';
                foreach ($data as $admin) {
                    $item = "<article>
                                <div class='row'>
                                    <div class='user-photo'>
                                        <img class='photo' src={IMAGE} alt={ID}>
                                    </div>
                                    <div class='fill' style='padding: 1vw;'>
                                        <div class='row'>
                                            <h3>{NAME}</h3>
                                            <a href='/manager/delete/users/{ID}'><i class=\"fas fa-times\"></i></a>
                                        </div>
                                        <div class='fill'>
                                            <div>Admin level: {LVL}</div>
                                        </div>
                                    </div>
                                </div>                                
                            </article>";

                    $item = str_replace('{IMAGE}', '../img/users/' . $admin['name'] . '/' . $admin['img'], $item);
                    $item = str_replace('{NAME}', $admin['name'], $item);
                    $item = str_replace('{ID}', $admin['id'], $item);
                    $item = str_replace('{LVL}', $admin['admin_level'], $item);

                    $admins .= $item;
                }
                if (!empty($admins)) {
                    print $admins;
                } else
                    echo "<p style=\"text-align: center\">There's no other admins</p>";
            } elseif (!empty($vars[2]) && (strcmp($vars[2], 'comments') == 0)) {
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
            } elseif (!empty($vars[2]) && (strcmp($vars[2], 'voting') == 0)) {
                $votings = '';
                foreach ($data as $voting) {
                    $item = "<article>
                                <div class='row'>
                                    <h3>{NAME}</h3>
                                    <a href='/manager/delete/voting/{ID}'><i class=\"fas fa-times\"></i></a>
                                </div>                                
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
                    $item = str_replace('{ID}', $voting['id'], $item);

                    $options = explode("\n", $voting['info']);
                    for ($i = 1; $i <= 4; $i++) {
                        $item = str_replace("{C$i}", $voting["var$i"], $item);
                        $item = str_replace("{N$i}", $options[$i - 1], $item);
                    }
                    $votings .= $item;
                }
                if (!empty($votings)) {
                    print $votings;
                } else
                    echo "<p style=\"text-align: center\">There's no votings now</p>";
            } elseif (!empty($vars[2]) && (strcmp($vars[2], 'users') == 0)) {
                $users = '';
                foreach ($data as $user) {
                    $item = "<article>
                                <div class='row'>
                                    <div class='user-photo'>
                                        <img class='photo' src={IMAGE} alt={ID}>
                                    </div>
                                    <div class='fill' style='padding: 1vw;'>
                                        <div class='row'>
                                            <h3>{NAME}</h3>
                                            <a href='/manager/delete/users/{ID}'><i class=\"fas fa-times\"></i></a>
                                        </div>
                                        <div class='fill'>
                                            <div>Recipes: {REC}</div>
                                            <div>Favourites: {FAV}</div>
                                        </div>
                                    </div>
                                </div>                                
                            </article>";

                    $item = str_replace('{IMAGE}', '../img/users/' . $user['name'] . '/' . $user['img'], $item);
                    $item = str_replace('{NAME}', $user['name'], $item);
                    $item = str_replace('{ID}', $user['id'], $item);
                    $item = str_replace('{REC}', $user['recipes'], $item);
                    $item = str_replace('{FAV}', $user['fav_recipes'], $item);

                    $users .= $item;
                }
                if (!empty($users)) {
                    print $users;
                } else
                    echo "<p style=\"text-align: center\">There's no registered users</p>";
            } elseif (!empty($vars[2]) && (strcmp($vars[2], 'recipes') == 0)) {
                if (count($data)) {
                    $page_data = '';
                    foreach ($data as $elem) {
                        $card = '<div class="recipe">
                            <div class="img-el" {IMAGE}>
                            </div>
                            <div class="info-el">
                                <div class="row">
                                    <div class="recipe-name">{NAME}</div>
                                    <a href=\'/manager/delete/recipes/{ID}\'><i class="fas fa-times"></i></a>
                                </div>
                                <div class="main-info-el">
                                    <div class="ingredients">
                                        <span class="ing-title"><u>Ingredients:</u></span>
                                        <ul class="list">
                                            {INGREDIENT_LIST}
                                        </ul>
                                    </div>
                                    <div class="cooking-info">
                                        <div class="cooking-el">
                                            <span>{CALORIES}</span>
                                            <span>Calories</span>
                                        </div>
                                        <span class="del"></span>
                                        <div class="cooking-el">
                                            <span>{TIME}</span>
                                            <span>Time</span>
                                        </div>
                                        <span class="del"></span>
                                        <div class="cooking-el">
                                            <span>{PORTIONS}</span>
                                            <span>Portions</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn">
                                    <div class="btn-name"><a href="/recipe/{HREF}">See more</a></div>
                                </div>
                            </div>
                        </div>';

                        $items = "";
                        $ingredients_list = explode("\n", $elem['ingredients']);
                        foreach ($ingredients_list as $item) {
                            $item_html = '<li>{INGREDIENT}</li>';
                            $item_html = str_replace("{INGREDIENT}", $item, $item_html);
                            $items .= $item_html;
                        }

                        $card = str_replace('{ID}', $elem['id'], $card);
                        $card = str_replace('{NAME}', $elem['name'], $card);
                        $img_path = '../../img/users/';
                        if (strcmp($elem["img"], 'empty.jpg') != 0)
                            $img_path .= $elem['username'] . '/';
                        $style = 'style="background: url(' . $img_path . $elem["img"] . '); 
                             background-size: cover;
	                         background-repeat: no-repeat;"';
                        $card = str_replace('{IMAGE}', $style, $card);
                        $card = str_replace('{PORTIONS}', $elem['portions'], $card);
                        $card = str_replace('{CALORIES}', $elem['calories'], $card);
                        $card = str_replace('{TIME}', $elem['time'], $card);
                        $card = str_replace('{INGREDIENT_LIST}', $items, $card);
                        $card = str_replace('{HREF}', $_SESSION['session_username'] . '/' . $elem['id'], $card);

                        $page_data .= $card;
                    }
                    print $page_data;
                } else {
                    echo "<p style=\"text-align: center\">There's no recipes</p>";
                }
            }
            ?>
        </form>
    </div>
</main>
</body>