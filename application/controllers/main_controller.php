<?php

class Main_Controller extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->model = new Main_Model();
    }

    function action_index()
    {
        $data = $this->model->get_data();

        require_once 'application/core/cache.php';
        $cache = new Cache();
        $cache->read_cache();
        $this->view->generate('main_view.php', $data);
        $cache->write_cache();
    }

}