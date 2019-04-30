<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 29.04.2019
 * Time: 18:59
 */

class Recipe_Controller extends Controller
{

    function __construct() {
        $this->model = new Recipe_Model();
        $this->view = new View();
    }

    function action_index() {
//        $data = $this->model->get_data();
//        require_once 'application/core/cache.php';
//        $cache = new Cache();
//        $cache->read_cache();
        $this->view->generate('recipe_view.php');
//        $cache->write_cache();
    }

    function action_more_info() {
        $vars = explode('/', $_SERVER['REQUEST_URI']);
        $data = $this->model->get_recipe($vars[3], $vars[4]);
        $this->view->generate('recipe_view.php', $data);
    }

}