<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 25.04.2019
 * Time: 22:58
 */

class Login_Controller extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->model = new Login_Model();
    }

    function action_index()
    {
        session_start();
        $this->login();
        require_once 'application/core/cache.php';
        $cache = new Cache();
        $cache->read_cache();
        $this->view->generate('login_view.php');
        $cache->write_cache();
    }

    function login()
    {
        if ($this->model->has_user()) {
            $_SESSION['session_username'] = $_POST['username'];
            $_SESSION['user_img'] = $this->model->get_user_photo();
            array_map('unlink', glob("application/cache/*.html"));
            if ($_SESSION['session_username'] != 'admin')
                header("Location: /profile");
            else
                header("Location: /manager/comments");
        }
    }

    function action_logout()
    {
        session_start();
        unset($_SESSION['session_username']);
        unset($_SESSION['user_img']);
        session_destroy();
        array_map('unlink', glob("application/cache/*.html"));
        header("location: /login");
    }

}