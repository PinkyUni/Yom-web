<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 26.04.2019
 * Time: 7:47
 */

class Register_Controller extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new Register_Model();
    }

    function action_index()
    {
        session_start();
        if (isset($_SESSION['session_username']) && strcmp($_SESSION['session_username'], 'admin') != 0)
            header("Location: /profile");
        $message = '';
        if (isset($_POST['register']))
            $message = $this->model->add_user();
        require_once 'application/core/cache.php';
        $this->view->generate('register_view.php', $message);
    }
}