<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 25.04.2019
 * Time: 22:52
 */

class Ideas_Controller extends Controller
{

    function action_index()
    {
        session_start();
        require_once 'application/core/cache.php';
        $cache = new Cache();
        $cache->read_cache();
        $this->view->generate('ideas_view.php');
        $cache->write_cache();
    }

}