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
                parent::__construct();
                $this->model = new Add_Recipe_Model();
            }

            function action_index()
            {
                if (isset($_POST['add_recipe'])) {
                    session_start();
                    $this->model->add_recipe();
                }
                session_start();
                $this->view->generate('add_recipe_view.php');
            }

        }