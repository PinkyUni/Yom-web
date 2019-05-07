<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 24.04.2019
 * Time: 23:52
 */

class Ingredients_Controller extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->model = new Ingredients_Model();
    }

    function action_index()
    {
        session_start();
        $data = $this->model->get_data();
        require_once 'application/core/cache.php';
        $cache = new Cache();
        $cache->read_cache();
        $this->view->generate('ingredients_view.php', $data);
        $cache->write_cache();
    }

}