<?php
class View {

//    public $template_view = 'template_view.php'; // здесь можно указать общий вид по умолчанию.

    /*
    $content_file - виды отображающие контент страниц;
    $template_file - общий для всех страниц шаблон;
    $data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
    */

    function generate($content_view, $data = null) {

        /*
        динамически подключаем общий шаблон (вид),
        внутри которого будет встраиваться вид
        для отображения контента конкретной страницы.
        */

        include 'application/views/template_view.php';
    }

}