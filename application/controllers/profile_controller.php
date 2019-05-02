<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 26.04.2019
 * Time: 7:36
 */

class Profile_Controller extends Controller
{

    function __construct()
    {
        $this->model = new Profile_Model();
        $this->view = new View();
    }

    function action_index()
    {
        session_start();
        if ($this->model->check_session()) {
            $data = $this->model->get_data();
            $this->view->generate('profile_view.php', $data);
        }
    }

}