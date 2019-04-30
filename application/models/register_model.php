<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 27.04.2019
 * Time: 2:45
 */

class Register_Model extends Model
{

    function get_data()
    {

    }

    function add_user()
    {
        require_once 'constants.php';
        require_once 'mysqlconnector.php';

        $mysqlconnector = new MySQLConnector(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $message = '';

        if (isset($_POST["register"])) {
            if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {

                $username = $mysqlconnector->transformString($_POST['username']);
                $email = $mysqlconnector->transformString($_POST['email']);
                $password = $mysqlconnector->transformString($_POST['password']);

                $query = "SELECT * FROM users WHERE name='" . $username . "';";
                $res = $mysqlconnector->getQueryResultWithoutTransformation($query);
                $numrows = $mysqlconnector->getRowsNumber($res);

                if ($numrows == 0) {
                    $sql = "INSERT INTO users (name, email, password) VALUES ('$username','$email', '$password')";
                    $result = $mysqlconnector->getQueryResultWithoutTransformation($sql);
                    if ($result) {
                        $message = "Account Successfully Created";
                        header("Location: /profile");
                    } else {
                        $message = "Failed to insert data information!";
                    }
                } else {
                    $message = "That username already exists! Please try another one!";
                }
            } else {
                $message = "All fields are required!";
            }
        }
        if (!empty($message)) {
            return $message;
        }
    }
}