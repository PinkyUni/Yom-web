<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 26.04.2019
 * Time: 7:26
 */

class Add_Recipe_Controller extends Controller
{

    function __construct()
    {
        $this->model = new Add_Recipe_Model();
        $this->view = new View();
    }

    function action_index()
    {
//        $data = $this->model->add_recipe();
        $this->view->generate('add_recipe_view.php');
    }

    function action_add_recipe() {
        $this->model->add_recipe();
    }
}