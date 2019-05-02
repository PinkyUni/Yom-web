<head>
    <title>* Yom *</title>
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" media="(max-width: 980px)" href="../../css/main_min.css">
    <link rel="stylesheet" href="../../config/css/for_all.css">
</head>
<body>
<nav>
    <h1>Yom</h1>
    <ul class="main-menu">
        <a href="/recipes">
            <li>Recipes</li>
        </a>
        <a href="/ingredients">
            <li>Ingredients</li>
        </a>
        <a href="/ideas">
            <li>Ideas</li>
        </a>
    </ul>
</nav>
<main>
    <section class="main-wrap">
        <div class="delimetr"><img src="../../img/delimetr_top.png"></div>
        <section class="main_img">
            <div class="img_text"><b>Yom</b> may become your personal cookbook.<br><br> Just try to use it...</div>
        </section>
        <section class="main_description">
            <b>Yom</b> is the first project made by <a href="https://github.com/PinkyUni">PinkyUni</a> using HTML & CSS. It is just an experiece for today, but may be in the future it will become a serious project, the cookbook with all necessary and very important functions, that will be convinient for users c:
        </section>
        <div class="delimetr"><img src="../../img/delimetr_bottom.png"></div>
    </section>
    <section class="login">
        <a href="/login"><div class="logreg-button login-button">Login</div></a>
        <a href="/register"><div class="logreg-button register-button">Register</div></a>
    </section>
    <section class="description-wrap">
        <h1 class="title-description">Description</h1>

        <?php
            $page_data = '';

            foreach ($data as $elem) {

                $item = '<section class="section-description">
                            <img src="{IMAGE}">
                            <div class="section-element">
                                <h2><a href="{URL}">{NAME}</a></h2>
                                <span>
                                    {TEXT}
                                </span>
                            </div>
                        </section>';

                $item = str_replace('{NAME}', $elem['name'], $item);
                $item = str_replace('{IMAGE}', '../../img/' . $elem['img'], $item);
                $item = str_replace('{URL}', $elem['url'], $item);
                $item = str_replace('{TEXT}', $elem['text'], $item);

                $page_data .= $item;
            }
            print $page_data;

        ?>
    </section>

</main>

