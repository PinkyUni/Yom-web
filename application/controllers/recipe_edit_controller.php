<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 03.05.2019
 * Time: 0:23
 */

class Recipe_Edit_Controller extends Controller
{

    public function __construct()
    {
        $this->model = new Recipe_Edit_Model();
        $this->view = new View();
    }

    public function action_index()
    {
        session_start();
        $vars = explode('/', $_SERVER['REQUEST_URI']);
        $data = $this->model->get_data($vars[3]);
        $this->view->generate('recipe_edit_view.php', $data);
    }

    public function action_save_changes() {
        session_start();
        $vars = explode('/', $_SESSION['new_uri']);
        if (isset($_POST['save_recipe'])) {
            $this->model->update_recipe($vars[3]);
            header("Location: " . $_SESSION['new_uri']);
        } elseif (isset($_POST['delete_recipe'])) {
            $this->model->delete_recipe($vars[3]);
            header("Location: " . $_SESSION['uri']);
        }
    }


}