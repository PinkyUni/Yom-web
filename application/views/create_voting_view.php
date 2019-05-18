<head>
    <title>Recipe</title>
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
    <div>
        <form method="post" action="/create_voting/add">
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="var[]" placeholder="1">
            <input type="text" name="var[]" placeholder="2">
            <input type="text" name="var[]" placeholder="3">
            <input type="text" name="var[]" placeholder="4">
            <input type="submit" name="add" id="accept" value="Create voting">
            <input type="submit" name="cancel" id="cancel" value="Cancel">
        </form>
    </div>
</main>
</body>