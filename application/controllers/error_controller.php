<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 25.04.2019
 * Time: 18:22
 */

class Error_Controller extends Controller
{

    function __construct() {
//        $this->model = new Error_Model();
        $this->view = new View();
    }

    function action_index() {
//        $data = $this->model->get_data();
        require_once 'application/core/cache.php';
        $cache = new Cache();
        $cache->read_cache();
        $this->view->generate('error_view.php');
        $cache->write_cache();
    }

}