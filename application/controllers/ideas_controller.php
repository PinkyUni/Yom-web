<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 25.04.2019
 * Time: 22:52
 */

class Ideas_Controller extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new Ideas_Model();
    }

    function action_index()
    {
        session_start();
        require_once 'application/core/cache.php';
        $data = $this->model->get_votings();
//        $cache = new Cache();
//        $cache->read_cache();
        $this->view->generate('ideas_view.php', $data);
//        $cache->write_cache();
    }

    public function action_add()
    {
        $this->model->add_votes();
        header("Location: /ideas");
    }

}