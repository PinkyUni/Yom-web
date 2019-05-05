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

    private function get_recipe($id)
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

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

    public function update_recipe($id)
    {
        if (isset($_POST['save_recipe'])) {
            require_once 'mysqlconnector.php';

            $mySQLConnector = MySQLConnector::getInstance();

            $table = "recipes";
            $query = "SELECT * FROM $table WHERE id = $id";
            $data = $mySQLConnector->getQueryResult($query);

            if ($data) {
                $query = "UPDATE $table SET name = '" . $_POST["name"] . "', portions = '" . $_POST['portions'] . "', calories = '" . $_POST['calories'] . "', 
                time = '" . $_POST['time'] . "', ingredients = '" . $_POST['ingredients'] . "', cooking = '" . $_POST['cooking'] . "' WHERE id = $id;";
                $mySQLConnector->executeQuery($query);
            }
        }
    }

    public function delete_recipe($id)
    {
        if (isset($_POST['delete_recipe'])) {
            require_once 'mysqlconnector.php';

            $mySQLConnector = MySQLConnector::getInstance();

            $query = "DELETE FROM recipes WHERE id = $id";
            $mySQLConnector->executeQuery($query);

            $query = "SELECT * FROM users;";
            $users = $mySQLConnector->getQueryResult($query);

            foreach ($users as $user) {
                if (!empty($user['fav_recipes'])) {
                    $faves = str_replace($id, '', $user['fav_recipes']);
                    $query = "UPDATE users SET fav_recipes = '$faves' WHERE name = '" . $user['name'] . "';";
                    $mySQLConnector->executeQuery($query);
                }
            }

            $query = "DELETE FROM comments WHERE id = $id;";
            $mySQLConnector->executeQuery($query);
        }
    }

}