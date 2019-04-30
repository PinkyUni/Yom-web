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
        require_once 'constants.php';
        require_once 'mysqlconnector.php';

        $this->userdata = $this->get_user_data();
        $recipes = $this->get_recipes();
        $this->userdata['recipes'] = $recipes;
        return $this->userdata;
    }

    private function get_user_data() {
        $mySQLConnector = new MySQLConnector(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        $username = $_SESSION["session_username"];
        $query = "SELECT * FROM users WHERE name = '$username';";
        $data = $mySQLConnector->getQueryResult($query);

        foreach ($data as $elem) {
            $name = $elem['name'];
            $img = $elem['img'];
            $recipeTable = $elem['recipeTable'];
            $favTable = $elem['favTable'];
        }

        $query = "SELECT * FROM $recipeTable;";
        $res = $mySQLConnector->getQueryResultWithoutTransformation($query);
        $rec_count = $mySQLConnector->getRowsNumber($res);

        $query = "SELECT * FROM $favTable;";
        $res = $mySQLConnector->getQueryResultWithoutTransformation($query);
        $fav_count = $mySQLConnector->getRowsNumber($res);

        $userdata = array(
            'name' => $name,
            'img' => $img,
            'recTable' => $recipeTable,
            'rec_count' => $rec_count,
            'favTable' => $favTable,
            'fav_count' => $fav_count,
        );
        return $userdata;
    }

    function get_recipes() {
        $mySQLConnector = new MySQLConnector(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        $table = $this->userdata['recTable'];
        $query = "SELECT * FROM $table;";
        $data = $mySQLConnector->getQueryResult($query);

        $recipes = array();
        $i = 0;
        foreach ($data as $elem) {
            $recipes[$i] = array(
                'id' => $elem['id'],
                'name' => $elem['name'],
                'img' => $elem['img'],
                'portions' => $elem['portions'],
                'calories' => $elem['calories'],
                'time' => date("h:i", strtotime($elem['time'])),
                'ingredients' => $elem['ingredients'],
                'cooking' => $elem['cooking'],
            );
            $i++;
        }
        return $recipes;
    }

    public function check_session()
    {
        session_start();

        if (!isset($_SESSION["session_username"]))
            header("location: /login");
        return $_SESSION['session_username'];
    }

}