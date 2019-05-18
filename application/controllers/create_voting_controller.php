<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 08.05.2019
 * Time: 16:50
 */

class Create_Voting_Controller extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new Create_Voting_Model();
    }

    public function action_index()
    {
        session_start();
        $this->view->generate("create_voting_view.php");
    }

    public function action_add() {
        session_start();
        if (isset($_SESSION['session_username']) && isset($_POST['add'])) {
            $this->model->add_voting();
        }
        echo $_SESSION['uri'];
        header("Location: " . $_SESSION['uri']);
    }
}