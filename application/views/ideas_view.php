<head>
    <title>Ideas</title>
    <link rel="stylesheet" href="../../css/ideas.css">
    <link rel="stylesheet" href="../../config/css/for_all.css">
    <link rel="stylesheet" href="../../config/css/menu.css">
    <link rel="stylesheet" media="(max-width: 980px)" href="../../config/css/menu_side.css">
</head>
<body>
<?php
include 'header.php';
?>
<header></header>
<h1>Ideas</h1>
<div class="container">

    <?php

    $votings = '';
    foreach ($data as $voting) {
        $item = "<form method=\"post\" action=\"/ideas/add/{ID}\">
                    <h2>{NAME}</h2>
                    <div class=\"el\">
                        <input type=\"checkbox\" name=\"var[]\" value='1' id=\"1\">
                        <label for=\"1\">{O1}</label>
                    </div>
                    <div class=\"el\">
                        <input type=\"checkbox\" name=\"var[]\"  value='2' id=\"2\">
                        <label for=\"2\">{O2}</label>
                    </div>
                    <div class=\"el\">
                        <input type=\"checkbox\" name=\"var[]\" value='3' id=\"3\">
                        <label for=\"3\">{O3}</label>
                    </div>
                    <div class=\"el\">
                        <input type=\"checkbox\" name=\"var[]\" value='4' id=\"4\">
                        <label for=\"4\">{O4}</label>
                    </div>
                    <input type=\"submit\" name=\"add\" value=\"Confirm\">
                </form>";

        $item = str_replace('{NAME}', $voting['name'], $item);

        $options = explode("\n", $voting['info']);
        for ($i = 1; $i <= 4; $i++) {
            $item = str_replace("{O$i}", $options[$i - 1], $item);
        }

        $item = str_replace('{ID}', $voting['id'], $item);
        $votings .= $item;
    }

    print $votings;
    ?>

</div>

<div class="bgimg">
    <div class="info">
        <h2>COMING SOON</h2>
        <hr>
        <p id="time" style="font-size:30px"></p>
    </div>
</div>
<script>
    var countDownDate = new Date("Jun 17, 2019 15:37:25").getTime();
    var countdownfunction = setInterval(function () {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById("time").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
        if (distance < 0) {
            clearInterval(countdownfunction);
            document.getElementById("time").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>

