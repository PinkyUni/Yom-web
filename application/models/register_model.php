<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 27.04.2019
 * Time: 2:45
 */

class Register_Model extends Model
{
    function add_user()
    {
        require_once 'mysqlconnector.php';

        $mysqlconnector = MySQLConnector::getInstance();

        if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {

            $username = $_POST['username'];

            $query = "SELECT * FROM users WHERE name='" . $username . "';";
            $res = $mysqlconnector->getQueryResultWithoutTransformation($query);
            $numrows = $mysqlconnector->getRowsNumber($res);

            if ($numrows == 0) {

                $email = $_POST['email'];
                $password = $_POST['password'];
                $password = hash('sha512', $password);

                if (isset($_POST['checkbox'])) {
                    $subscribed = "yes";
                } else {
                    $subscribed = "no";
                }

                $img = "empty.jpg";

                if ($_FILES['inputfile']['error'] == UPLOAD_ERR_OK && ($_FILES['inputfile']['type'] == 'image/png' || $_FILES['inputfile']['type'] == 'image/jpeg') && !is_null($_FILES['inputfile']['tmp_name'])) {
                    $destination_dir = "img/users/" . $username . '/';
                    if (!file_exists($destination_dir)) {
                        mkdir($destination_dir);
                    }
                    $destination_dir .= $_FILES['inputfile']['name'];
                    if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $destination_dir)) {
                        $img = $mysqlconnector->transformString($_FILES['inputfile']['name']);
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
                    return $message;
                }

                $sql = "INSERT INTO users (name, email, password, img, subscribed, fav_recipes) VALUES ('$username','$email', '$password', '$img', '$subscribed', '');";
                echo $sql;
                $result = $mysqlconnector->executeQuery($sql);
                if ($result && strcmp($_SESSION['session_username'], 'admin') != 0) {
                    header("Location: /profile");
                } else
                    header("Location: " . $_SESSION['uri']);
            } else {
                $message = 'User with such name already exists!';
                return $message;
            }
        }
    }
}