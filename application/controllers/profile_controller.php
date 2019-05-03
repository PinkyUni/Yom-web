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

    function action_send() {
        //TODO get_users_email

        $to  = "444negativ@gmail.com";

        $subject = "Заголовок письма";

        $message = "puk <br> puk";

        $headers  = "Content-type: text/html; charset=windows-1251 \r\n";
        $headers .= "From: От кого письмо <from@example.com>\r\n";
        $headers .= "Reply-To: reply-to@example.com\r\n";

        $res = mail($to, $subject, $message, $headers);
        if ($res) {
            echo 'done';
        }
        else {
            echo 'no';
        }
    }

}