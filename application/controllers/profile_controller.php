<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 26.04.2019
 * Time: 7:36
 */

class Profile_Controller extends Controller
{

    function __construct()
    {
        $this->model = new Profile_Model();
        $this->view = new View();
    }

    function action_index()
    {
        session_start();
        if ($this->model->check_session()) {
            $data = $this->model->get_data();
            $_SESSION['uri'] = $_SERVER['REQUEST_URI'];
            $this->view->generate('profile_view.php', $data);
        }
    }

    function action_recipes()
    {
        $this->action_index();
    }

    function action_favourites()
    {
        $this->action_index();
    }

    function action_add_to_favourite()
    {
        session_start();
        if (isset($_SESSION['session_username'])) {
            $vars = explode('/', $_SERVER['REQUEST_URI']);
            $this->model->add_to_favourite($vars[4]);
            header("Location: " . $_SESSION['uri']);
        } else
            header("Location: /login");
    }

}