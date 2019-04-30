<head>
    <title>Ingredients</title>
    <link rel="stylesheet" href="../../css/ingredients.css">
    <link rel="stylesheet" href="../../config/css/for_all.css">
    <link rel="stylesheet" href="../../config/css/menu.css">
    <link rel="stylesheet" media="(max-width: 1200px)" href="../../config/css/menu_side.css">
    <link rel="stylesheet" media="(max-width: 1200px)" href="../../css/ingredients_min.css">
</head>
<body>
<?php
    include 'header.php';
?>
<header>
    <!-- картинка -->
</header>
<h1>Ingredients</h1>
<main>
    <section class="ingredients">

        <?php
            $page_data = '';

            foreach ($data as $elem) {

                $item = '	<section class="ingredient-info">
                                <div class="imgs">
                                    <img src="{IMAGE1}">
                                    <img src="{IMAGE2}">
                                </div>
                                <div class="ingredient-descripton">
                                    <h2>
                                        {NAME}
                                    </h2>
                                    <span>
                                        {TEXT}
                                    </span>
                                </div>
                            </section>';

                $item = str_replace('{NAME}', $elem['name'], $item);
                $item = str_replace('{IMAGE1}', '../img/'.$elem['img1'], $item);
                $item = str_replace('{IMAGE2}', '../img/'.$elem['img2'], $item);
                $item = str_replace('{TEXT}',$elem['text'], $item);

                $page_data .= $item;
            }
            print $page_data;
        ?>

    </section>
</main>
