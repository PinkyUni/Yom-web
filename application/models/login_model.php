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

    public function get_admin_level($name) {
        require_once 'mysqlconnector.php';

        $mysqlconnector = MySQLConnector::getInstance();
        $res = $mysqlconnector->getSingleValue("SELECT admin_level FROM users WHERE name='$name';", 'admin_level');
        return $res;
    }

    public function has_user()
    {
        require_once 'mysqlconnector.php';

        if (isset($_POST["login"])) {

            if (!empty($_POST['username']) && !empty($_POST['password'])) {
                $mysqlconnector = MySQLConnector::getInstance();

                $username = $mysqlconnector->transformString($_POST['username']);
                $password = $mysqlconnector->transformString($_POST['password']);
                $password = hash('sha512', $password);

                $res = $mysqlconnector->getSingleValue("SELECT password FROM users WHERE name='" . $username . "';", 'password');
                $res = $mysqlconnector->getString($res);

                if (strcmp($password, $res) == 0) {
                    return 1;
                } else
                    return 0;
            }
        }
    }
}