<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 30.04.2019
 * Time: 12:40
 */

class Recipe_Model extends Model
{

    public function get_data($id)
    {
        $recipe = $this->get_recipe($id);
        $comments = $this->get_comments($id);
        $data = array(
            'recipe' => $recipe,
            'comments' => $comments,
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

    function add_comment($username, $id)
    {
        if (isset($_POST['place'])) {
            if (!empty($_POST['comment-text'])) {

                require_once 'constants.php';
                require_once 'mysqlconnector.php';

                $mySQLConnector = new MySQLConnector(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

                $table = 'recipes';
                $query = "SELECT comments FROM $table WHERE id = $id;";
                $res = $mySQLConnector->getSingleValue($query, 'comments');

                if (!$res) {
                    $comments_table = $username . $id;
                    $query = "UPDATE $table SET comments = '" . $comments_table . "' WHERE id = " . $id . ';';
                    $mySQLConnector->executeQuery($query);
                    $query = "CREATE TABLE $comments_table (id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY, username VARCHAR(30) NOT NULL, img VARCHAR(30), text VARCHAR(100) NOT NULL, time DATETIME NOT NULL);";
                    $mySQLConnector->executeQuery($query);
                } else {
                    $query = "SELECT comments FROM $table WHERE id = $id;";
                    $res = $mySQLConnector->getQueryResultWithoutTransformation($query);
                    $res = $mySQLConnector->transformAll($res);
                    $comments_table = $res[0][0];
                }

                $query = "SELECT img FROM users WHERE name = '" . $_SESSION['session_username'] . "';";
                $img = $mySQLConnector->getSingleValue($query, 'img');

                date_default_timezone_set('Europe/Minsk');
                $query = "INSERT INTO $comments_table (username, img,  text, time) VALUES ('" . $_SESSION['session_username'] . "', '$img','" . $_POST["comment-text"] . "', '" . date("Y-m-d H:i:s") . "');";
                $mySQLConnector->executeQuery($query);
            }
        }
    }

    public function get_comments($id)
    {
        require_once 'constants.php';
        require_once 'mysqlconnector.php';

        $mySQLConnector = new MySQLConnector(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        $table = "recipes";
        $comments = array();

        if ($mySQLConnector->existsTable($table)) {
            $query = "SELECT comments FROM $table WHERE id = $id;";
            $data = $mySQLConnector->getSingleValue($query, 'comments');

            if ($mySQLConnector->existsTable($data)) {
                $query = 'SELECT * FROM ' . $data . ';';
                $data = $mySQLConnector->getQueryResult($query);

                foreach ($data as $elem) {
                    $comments[] = array(
                        'username' => $elem['username'],
                        'img' => $elem['img'],
                        'text' => $elem['text'],
                        'time' => $elem['time'],
                    );
                }
            }
        }
        return $comments;
    }

}