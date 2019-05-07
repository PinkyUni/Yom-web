<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 07.05.2019
 * Time: 22:57
 */

class Comments_Manager_Controller extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new Comments_Manager_Model();
    }

    public function action_index()
    {
        session_start();
        if (isset($_SESSION['session_username'])) {
            $data = $this->model->get_data();
            $this->view->generate("comments_manager_view.php", $data);
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
        header("Location: /comments_manager");
    }
}