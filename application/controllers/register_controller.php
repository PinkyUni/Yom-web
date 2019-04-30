<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 26.04.2019
 * Time: 7:47
 */

class Register_Controller extends Controller
{
    function __construct() {
        $this->model = new Register_Model();
        $this->view = new View();
    }

    function action_index() {
        $data = $this->model->add_user();
        require_once 'application/core/cache.php';
        $cache = new Cache();
        $cache->read_cache();
        $this->view->generate('register_view.php');
        $cache->write_cache();
        echo $data;
    }

}