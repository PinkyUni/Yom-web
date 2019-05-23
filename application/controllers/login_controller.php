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
        $this->check_session();
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
            $this->check_session();
        }
    }

    private function check_session()
    {
        if (isset($_SESSION['session_username']))
            if (strcasecmp($_SESSION['session_username'], 'admin') == 0)
                header("Location: /manager/comments");
            else
                header("Location: /profile");
        else
            $this->login();
    }

    function action_logout()
    {
        session_start();
        unset($_SESSION['session_username']);
        unset($_SESSION['user_img']);
        session_destroy();
        header("location: /login");
    }

}