<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 29.04.2019
 * Time: 18:59
 */

class Recipe_Controller extends Controller
{

    /**
     * Recipe_Controller constructor.
     */
    function __construct() {
        $this->model = new Recipe_Model();
        $this->view = new View();
    }

    function action_index() {
        session_start();
        $vars = explode('/', $_SERVER['REQUEST_URI']);
        if (isset($_POST['place']))
            $this->model->add_comment($vars[2], $vars[3]);
        $data = $this->model->get_data($vars[3]);
        $this->view->generate('recipe_view.php', $data);
    }

}