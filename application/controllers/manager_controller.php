<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 07.05.2019
 * Time: 22:57
 */

class Manager_Controller extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new Manager_Model();
    }

    public function action_index()
    {
        session_start();
        if (isset($_SESSION['session_username']) && isset($_SESSION['admin_level']) && $_SESSION['admin_level'] > 0) {
            if ($this->model->has_user()) {
                $data = $this->model->get_comments();
                $_SESSION['uri'] = $_SERVER['REQUEST_URI'];
                $this->view->generate("manager_view.php", $data);
            } else
                header("Location: /login/logout");
        } else
            header("Location: /login");
    }

    public function action_users()
    {
        session_start();
        if (isset($_SESSION['session_username']) && $_SESSION['admin_level'] > 0) {
            $data = $this->model->get_users();
            $_SESSION['uri'] = $_SERVER['REQUEST_URI'];
            $this->view->generate("manager_view.php", $data);
        } else
            header("Location: /login");
    }

    public function action_admins()
    {
        session_start();
        if (isset($_SESSION['session_username']) && $_SESSION['admin_level'] = 10) {
            $data = $this->model->get_admins();
            $_SESSION['uri'] = $_SERVER['REQUEST_URI'];
            $this->view->generate("manager_view.php", $data);
        } else
            header("Location: /login");
    }

    public function action_recipes()
    {
        session_start();
        if (isset($_SESSION['session_username']) && $_SESSION['admin_level'] > 0) {
            $data = $this->model->get_recipes();
            $_SESSION['uri'] = $_SERVER['REQUEST_URI'];
            $this->view->generate("manager_view.php", $data);
        } else
            header("Location: /login");
    }

    public function action_comments()
    {
        $this->action_index();
    }

    public function action_voting()
    {
        session_start();
        if (isset($_SESSION['session_username']) && $_SESSION['admin_level'] > 0) {
            $data = $this->model->get_votes();
            $_SESSION['uri'] = $_SERVER['REQUEST_URI'];
            $this->view->generate("manager_view.php", $data);
        } else
            header("Location: /login");
    }

    public function action_process()
    {
        if (isset($_POST['comments']) && !empty($_POST['comments']))
            if (isset($_POST['accept']))
                $this->model->accept_data();
            else
                $this->model->delete_data();
        header("Location: /manager/comments");
    }

    public function action_delete()
    {
        session_start();
        if (isset($_SESSION['session_username']) && $_SESSION['admin_level'] > 0) {
            $vars = explode('/', $_SERVER['REQUEST_URI']);
            if (strcmp($vars[3], 'voting') == 0)
                $this->model->delete_by_id($vars[4], 'votings');
            elseif (strcmp($vars[3], 'users') == 0) {
                $this->model->delete_notice($vars[4], 'Your Yom-account was deleted.');
                $name = $this->model->get_name_by_id($vars[4]);
                $this->model->delete_by_id($vars[4], 'users');
                if (isset($_SESSION['session_username']) && strcmp($_SESSION['session_username'], $name) == 0) {
                    unset($_SESSION['session_username']);
                    unset($_SESSION['session_username']);
                    unset($_SESSION['user_img']);
                    unset($_SESSION['admin_level']);
                    session_destroy();
                    header("location: /login");
                }
            } elseif (strcmp($vars[3], 'recipes') == 0) {
                if ($this->model->user_exists($vars[4])) {
                    $user_id = $this->model->get_user_id_by_recipe_id($vars[4]);
                    $this->model->delete_notice($user_id, 'Admin deleted your recipe.');
                }
                $this->model->delete_by_id($vars[4], 'recipes');
            }
            header("Location: " . $_SESSION['uri']);
        }
    }
}