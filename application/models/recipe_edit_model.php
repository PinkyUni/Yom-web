<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 03.05.2019
 * Time: 0:28
 */

class Recipe_Edit_Model extends Model
{
    public function get_data($id)
    {
        $recipe = $this->get_recipe($id);
        $data = array(
            'recipe' => $recipe,
        );
        return $data;
    }

    public function get_recipe($id)
    {
        require_once 'constants.php';
        require_once 'mysqlconnector.php';

        $mySQLConnector = new MySQLConnector(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        $table = "recipes";

        $query = "SELECT * FROM $table WHERE id = $id";
        $data = $mySQLConnector->getQueryResult($query);

        if (count($data)) {
            foreach ($data as $elem) {
                $recipe = array(
                    'username' => $elem['username'],
                    'id' => $elem['id'],
                    'name' => $elem['name'],
                    'img' => $elem['img'],
                    'portions' => $elem['portions'],
                    'calories' => $elem['calories'],
                    'time' => date("h:i", strtotime($elem['time'])),
                    'ingredients' => $elem['ingredients'],
                    'cooking' => $elem['cooking'],
                );
            }
            return $recipe;
        } else
            header("Location: /error");
    }

    public function update_recipe($id) {

        if (isset($_POST['save_recipe'])) {
            $uri = $_SESSION['uri'];

            require_once 'constants.php';
            require_once 'mysqlconnector.php';

            $mySQLConnector = new MySQLConnector(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

            $table = "recipes";

            $query = "SELECT * FROM $table WHERE id = $id";
            $data = $mySQLConnector->getQueryResult($query);

            if ($data) {
                $query = "UPDATE $table SET name = '" . $_POST["name"] . "', portions = '". $_POST['portions'] . "', calories = '" . $_POST['calories'] . "', 
                time = '" . $_POST['time'] . "', ingredients = '" . $_POST['ingredients'] . "', cooking = '" . $_POST['cooking'] . "' WHERE id = $id;";
                $mySQLConnector->executeQuery($query);
            }
        }
    }

}