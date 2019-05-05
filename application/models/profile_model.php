<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 27.04.2019
 * Time: 7:22
 */

class Profile_Model extends Model
{
    public $userdata;

    public function get_data()
    {
        require_once 'mysqlconnector.php';

        $this->userdata = $this->get_user_data();

        $vars = explode('/', $_SERVER['REQUEST_URI']);
        if (!empty($vars[2]) && strcmp($vars[2], 'favourites') == 0)
            $recipes = $this->get_favourite_recipes();
        else
            $recipes = $this->get_recipes();
        $this->userdata['recipes'] = $recipes;
        return $this->userdata;
    }

    private function get_user_data()
    {
        $mySQLConnector = MySQLConnector::getInstance();

        $username = $_SESSION["session_username"];
        $query = "SELECT * FROM users WHERE name = '$username';";
        $data = $mySQLConnector->getQueryResult($query);

        foreach ($data as $elem) {
            $name = $elem['name'];
            $img = $elem['img'];
        }

        $query = "SELECT * FROM recipes WHERE username =  '" . $_SESSION['session_username'] . "';";
        $res = $mySQLConnector->getQueryResultWithoutTransformation($query);
        $rec_count = 0;
        if ($res)
            $rec_count = $mySQLConnector->getRowsNumber($res);

        $query = "SELECT fav_recipes FROM users WHERE name =  '" . $_SESSION['session_username'] . "';";
        $fav_recipes = $mySQLConnector->getSingleValue($query, 'fav_recipes');
        $faves = explode(' ', $fav_recipes);
        $faves = \array_diff($faves, ['']);
        $fav_count = 0;
        if (is_array($faves))
            $fav_count = count($faves);

        $userdata = array(
            'name' => $name,
            'img' => $img,
            'rec_count' => $rec_count,
            'fav_count' => $fav_count,
            'fav_recipes' => $fav_recipes,
        );
        return $userdata;
    }

    private function get_recipes()
    {
        $mySQLConnector = MySQLConnector::getInstance();

        $table = 'recipes';
        $username = $_SESSION['session_username'];
        $query = "SELECT * FROM $table WHERE username = '$username';";
        $data = $mySQLConnector->getQueryResult($query);

        $recipes = array();
        foreach ($data as $elem) {
            $recipes[] = array(
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
        return $recipes;
    }

    public function get_favourite_recipes()
    {
        if (isset($_SESSION['session_username'])) {

            require_once 'mysqlconnector.php';

            $mySQLConnector = MySQLConnector::getInstance();

            $query = "SELECT fav_recipes FROM users WHERE name = '" . $_SESSION['session_username'] . "';";;
            $result = $mySQLConnector->getSingleValue($query, 'fav_recipes');

            $recipes = array();
            $ids = explode(' ', $result);
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $query = "SELECT * FROM recipes WHERE id = $id;";
                    $elem = $mySQLConnector->getQueryResult($query);

                    $elem = $elem[0];
                    $recipes[] = array(
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
            }
            return $recipes;
        }
    }

    public function add_to_favourite($id)
    {
        if (isset($_SESSION['session_username'])) {

            require_once 'mysqlconnector.php';

            $mySQLConnector = MySQLConnector::getInstance();

            $query = "SELECT fav_recipes FROM users WHERE name = '" . $_SESSION['session_username'] . "';";;
            $result = $mySQLConnector->getSingleValue($query, 'fav_recipes');

            if (strpos($result, $id) === FALSE) {
                $query = "UPDATE users SET fav_recipes = CONCAT(fav_recipes, '$id ') WHERE name = '" . $_SESSION['session_username'] . "';";
                $mySQLConnector->executeQuery($query);
            } else {
                $fav = str_replace("$id ", "", $result);
                $query = "UPDATE users SET fav_recipes = '$fav' WHERE name = '" . $_SESSION['session_username'] . "';";
                $mySQLConnector->executeQuery($query);
            }
        }
    }

    public function check_session()
    {
        if (!isset($_SESSION["session_username"]))
            header("location: /login");
        return true;
    }

}