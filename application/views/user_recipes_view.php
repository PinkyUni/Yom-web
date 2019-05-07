<head>
    <title>User recipes</title>
    <link rel="stylesheet" type="text/css" href="../../css/user_recipes.css">
    <link rel="stylesheet" href="../../config/css/for_all.css">
    <link rel="stylesheet" href="../../config/css/menu.css">
    <link rel="stylesheet" media="(max-width: 1200px)" href="../../config/css/menu_side.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css"
          integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
</head>
<body>
<?php
include 'header.php';
?>
<main>
	<section class="container">

        <?php
        $recipes = $data['recipes'];
        if (count($recipes)) {
            $page_data = '';
            foreach ($recipes as $elem) {
                $card = '<div class="recipe">
                            <div class="img-el" {IMAGE}>
                            </div>
                            <div class="info-el">
                                <div class="row">
                                    <div class="recipe-name">{NAME}</div>
                                    <a href="/profile/add_to_favourite/{HREF}" ><i class="fas fa-star" style="{STYLE}"></i></a>
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

                $card = str_replace('{NAME}', $elem['name'], $card);
                $img_path = '../../img/users/';
                if (strcmp($elem["img"], 'empty.jpg') != 0)
                    $img_path .= $elem["username"] . '/';
                $style = 'style="background: url(' . $img_path . $elem["img"] . '); 
                             background-size: cover;
	                         background-repeat: no-repeat;"';
                $card = str_replace('{IMAGE}', $style, $card);
                $card = str_replace('{PORTIONS}', $elem['portions'], $card);
                $card = str_replace('{CALORIES}', $elem['calories'], $card);
                $card = str_replace('{TIME}', $elem['time'], $card);
                $card = str_replace('{INGREDIENT_LIST}', $items, $card);
                $card = str_replace('{HREF}', $elem['username'] . '/' . $elem['id'], $card);

                if (strpos($data['fav_ids'], $elem['id']) === FALSE) {
                    $card = str_replace('{STYLE}', 'color: #585858;', $card);
                } else {
                    $card = str_replace('{STYLE}', 'color: #ffb000;', $card);
                }

                $page_data .= $card;
            }
            print $page_data;
        } else {
            echo '<p style="text-align: center">"List of recipes is empty."</p>';
        }

        ?>

    </section>
</main>
