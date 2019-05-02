<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 25.04.2019
 * Time: 22:58
 */

class Login_Controller extends Controller {

    function __construct() {
        $this->model = new Login_Model();
        $this->view = new View();
    }

    function action_index() {
        session_start();
        $this->login();
        require_once 'application/core/cache.php';
        $cache = new Cache();
        $cache->read_cache();
        $this->view->generate('login_view.php');
        $cache->write_cache();
    }

    function login() {
        if ($this->model->has_user()) {
            $_SESSION['session_username'] = $_POST['username'];
            $_SESSION['user_img'] = $this->model->get_user_photo();
            echo $_SESSION['user_img'];
            header("Location: /profile");
        } 
    }

    function action_logout() {
        session_start();
        unset($_SESSION['session_username']);
        unset($_SESSION['user_img']);
//        unset($_COOKIE);
        session_destroy();
        header("location: /login");
    }

}