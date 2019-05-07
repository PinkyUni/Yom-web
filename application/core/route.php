<?php

/*
Класс-маршрутизатор для определения запрашиваемой страницы.
> цепляет классы контроллеров и моделей;
> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
*/

class Route
{

    static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'Main';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // получаем имя контроллера
        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }

        $c_name = $controller_name;
        // получаем имя экшена
        if (!empty($routes[2])) {
            $action_name = $routes[2];
            $method = 'action_' . $action_name;
            $c_name .= '_Controller';
            $c = $c_name;
            $c_file = strtolower($c_name) . '.php';
            $c_path = "application/controllers/" . $c_file;
            require_once $c_path;
            if (!method_exists($c, $method))
                $action_name = 'index';
        }
        // добавляем префиксы
        $model_name = $controller_name . '_Model';
        $controller_name .= '_Controller';
        $action_name = 'action_' . $action_name;

        // подцепляем файл с классом модели (файла модели может и не быть)
        $model_file = strtolower($model_name) . '.php';
        $model_path = "application/models/" . $model_file;
        if (file_exists($model_path)) {
            require_once $model_path;
        }

        // подцепляем файл с классом контроллера
        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = "application/controllers/" . $controller_file;
        try {
            if (file_exists($controller_path)) {
                require_once $controller_path;

                $controller = new $controller_name;
                $action = $action_name;

                if (method_exists($controller, $action)) {
                    // вызываем действие контроллера
                    $controller->$action();
                } else {
                    throw new Exception();
                }
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            Route::ErrorPage404();
        }
    }

    private static function ErrorPage404()
    {
//        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location: /error');
    }

}
