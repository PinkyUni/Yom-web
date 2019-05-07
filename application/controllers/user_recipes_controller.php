<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 02.05.2019
 * Time: 8:11
 */

class User_Recipes_Controller extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new User_Recipes_Model();
    }

    public function action_index()
    {
        session_start();
        $condition = '';
        if (isset($_POST['search']) && !empty($_POST['searching'])) {
            $condition = $this->create_searching_condition();
        }
        $data = $this->model->get_data($condition);
        $_SESSION['uri'] = $_SERVER['REQUEST_URI'];
        $this->view->generate('user_recipes_view.php', $data);
    }

    private function create_searching_condition()
    {
        $condition = "WHERE MATCH (name) AGAINST ( '" . $_POST['searching'] . "')";
        return $condition;
    }
}