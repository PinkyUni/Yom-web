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
        if (isset($_SESSION['session_username'])) {
            $data = $this->model->get_comments();
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
        if (isset($_SESSION['session_username'])) {
            $data = $this->model->get_votes();
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

}