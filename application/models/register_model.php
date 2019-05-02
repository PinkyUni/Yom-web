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

        if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {

            $username = $mysqlconnector->transformString($_POST['username']);
            $email = $mysqlconnector->transformString($_POST['email']);
            $password = $mysqlconnector->transformString($_POST['password']);

            $query = "SELECT * FROM users WHERE name='" . $username . "';";
            $res = $mysqlconnector->getQueryResultWithoutTransformation($query);
            $numrows = $mysqlconnector->getRowsNumber($res);

            if ($numrows == 0) {

                $img = "empty.jpg";

                if ($_FILES['inputfile']['error'] == UPLOAD_ERR_OK && $_FILES['inputfile']['type'] == 'image/jpeg' && !is_null($_FILES['inputfile']['tmp_name'])) {
                    $destination_dir = "img/users/" . $username . '/';
                    if (!file_exists($destination_dir)) {
                        mkdir($destination_dir);
                    }
                    $destination_dir .= $_FILES['inputfile']['name'];
                    if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $destination_dir)) {
                        $img = $mysqlconnector->transformString($_FILES['inputfile']['name']);
                    }
                }

                $sql = "INSERT INTO users (name, email, password, img) VALUES ('$username','$email', '$password', '$img');";
                $result = $mysqlconnector->getQueryResultWithoutTransformation($sql);
                if ($result) {
                    header("Location: /profile");
                }
            }
        }
    }
}