<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 27.04.2019
 * Time: 3:35
 */

class login_model extends Model
{
    public function get_user_photo()
    {
        require_once 'mysqlconnector.php';

        $mysqlconnector = MySQLConnector::getInstance();
        $res = $mysqlconnector->getSingleValue("SELECT img FROM users WHERE name='" . $_SESSION['session_username'] . "';", 'img');
        return $res;
    }

    public function has_user()
    {
        require_once 'mysqlconnector.php';

        if (isset($_SESSION["session_username"])) {
            header("Location: /profile");
        }

        $message = '';
        if (isset($_POST["login"])) {

            $mysqlconnector = MySQLConnector::getInstance();
            if (!empty($_POST['username']) && !empty($_POST['password'])) {

                $username = $mysqlconnector->transformString($_POST['username']);
                $password = $mysqlconnector->transformString($_POST['password']);
                $res = $mysqlconnector->getQueryResultWithoutTransformation("SELECT * FROM users WHERE name='" . $username . "' AND password='" . $password . "'");
                $numrows = $mysqlconnector->getRowsNumber($res);
                return $numrows;

            } else {
                $message = "All fields are required!";
            }
        }

        if (!empty($message)) {
            return $message;
        }
    }

}