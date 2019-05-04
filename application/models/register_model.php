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
        require_once 'mysqlconnector.php';

        $mysqlconnector = MySQLConnector::getInstance();

        if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {

            $username = $mysqlconnector->transformString($_POST['username']);

            $query = "SELECT * FROM users WHERE name='" . $username . "';";
            $res = $mysqlconnector->getQueryResultWithoutTransformation($query);
            $numrows = $mysqlconnector->getRowsNumber($res);

            if ($numrows == 0) {

                $email = $mysqlconnector->transformString($_POST['email']);
                $password = $mysqlconnector->transformString($_POST['password']);

                if (isset($_POST['checkbox'])) {
                    $subscribed = "yes";
                } else {
                    $subscribed = "no";
                }

                $img = "empty.jpg";

                $message = '';
                if ($_FILES['inputfile']['error'] == UPLOAD_ERR_OK && $_FILES['inputfile']['type'] == 'image/jpeg' && !is_null($_FILES['inputfile']['tmp_name'])) {
                    $destination_dir = "img/users/" . $username . '/';
                    if (!file_exists($destination_dir)) {
                        mkdir($destination_dir);
                    }
                    $destination_dir .= $_FILES['inputfile']['name'];
                    if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $destination_dir)) {
                        $img = $mysqlconnector->transformString($_FILES['inputfile']['name']);
                    } else {
                        $message = 'File not uploaded';
                    }
                } else {
                    switch ($_FILES['inputfile']['error']) {
                        case UPLOAD_ERR_FORM_SIZE:
                        case UPLOAD_ERR_INI_SIZE:
                            $message = 'File Size exceed';
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            $message = 'FIle Not selected';
                            break;
                        default:
                            $message = 'Something is wrong';
                    }
                }

                if (!empty($message))
                    return $message;

                $sql = "INSERT INTO users (name, email, password, img, subscribed, fav_recipes) VALUES ('$username','$email', '$password', '$img', '$subscribed', '');";
                $result = $mysqlconnector->executeQuery($sql);
                if ($result) {
                    header("Location: /profile");
                }
            } else {
                $message = 'User with such name already exists!';
                return $message;
            }
        }
    }
}