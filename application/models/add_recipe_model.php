<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 29.04.2019
 * Time: 10:13
 */

class Add_Recipe_Model extends Model
{

    public function add_recipe() {

        session_start();
        if (isset($_SESSION["session_username"])) {

            require_once 'constants.php';
            require_once 'mysqlconnector.php';

            $mySQLConnector = new MySQLConnector(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

            $username = $_SESSION['session_username'];
            $table = "recipes";

            if(isset($_POST['name'])){

                $img = "empty.jpg";

                if ($_FILES['inputfile']['error'] == UPLOAD_ERR_OK && $_FILES['inputfile']['type'] == 'image/jpeg' && !is_null($_FILES['inputfile']['tmp_name'])) {
                    $destination_dir = 'img/users/' . $_SESSION["session_username"];
                    if (!file_exists($destination_dir)) {
                        mkdir($destination_dir);
                    }
                    $destination_dir .= '/' . $_FILES['inputfile']['name'];
                    if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $destination_dir)) {
                        $img = $mySQLConnector->transformString($_FILES['inputfile']['name']);
                    }
                }

                $name = $mySQLConnector->transformString($_POST['name']);
                $portions = $mySQLConnector->transformString($_POST['portions']);
                $calories = $mySQLConnector->transformString($_POST['calories']);
                $time = $mySQLConnector->transformString($_POST['time']);
                $ingredients = $mySQLConnector->transformString($_POST['ingredients']);
                $cooking = $mySQLConnector->transformString($_POST['cooking']);

                $query = "INSERT INTO " . $table . " (name, img, portions, calories, time, ingredients, cooking, username) VALUES ('$name', '$img', '$portions', $calories, '$time', '$ingredients', 
					'$cooking', '$username');";
                $mySQLConnector->executeQuery($query);
                header("Location: /profile");
                exit;
            }
            else
                echo 'kek';
        }
        else
            echo 'puk';
    }
}