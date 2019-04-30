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
        $data = $this->login();
        require_once 'application/core/cache.php';
        $cache = new Cache();
        $cache->read_cache();
        $this->view->generate('login_view.php');
        $cache->write_cache();
    }

    function login() {
        if ($this->model->has_user()) {
            $_SESSION['session_username'] = $_POST['username'];
            header("Location: /profile");
        } 
    }

    function action_logout() {
        session_start();
        unset($_SESSION['session_username']);
        session_destroy();
        header("location: /login");
    }

}