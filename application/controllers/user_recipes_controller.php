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
        $this->model = new User_Recipes_Model();
        $this->view = new View();
    }

    public function action_index()
    {
        $data = $this->model->get_data();
        $this->view->generate('user_recipes_view.php', $data);
    }

}