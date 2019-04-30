<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 27.04.2019
 * Time: 3:35
 */

class login_model extends Model
{
    public function get_data()
    {

    }

    public function has_user()
    {
        require_once 'constants.php';
        require_once 'mysqlconnector.php';

        session_start();

        if (isset($_SESSION["session_username"])) {
            header("Location: /profile");
        }

        $message = '';
        if (isset($_POST["login"])) {

            $mysqlconnector = new MySQLConnector(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

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