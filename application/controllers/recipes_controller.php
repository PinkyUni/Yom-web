<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 25.04.2019
 * Time: 16:01
 */

class Recipes_Controller extends Controller {

    function __construct() {
//        $this->model = new Recipes_Model();
        $this->view = new View();
    }

    function action_index() {
//        $data = $this->model->get_data();
        session_start();
        require_once 'application/core/cache.php';
        $cache = new Cache();
        $cache->read_cache();
        $this->view->generate('recipes_view.php');
        $cache->write_cache();
    }

}