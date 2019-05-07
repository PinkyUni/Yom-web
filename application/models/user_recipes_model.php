<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 02.05.2019
 * Time: 0:04
 */

class User_Recipes_Model extends Model
{
    public function get_data($condition = '')
    {
        require_once 'mysqlconnector.php';

        $data['recipes'] = $this->get_recipes($condition);
        $data['fav_ids'] = $this->get_favourite_ids();
        return $data;
    }

    private function get_recipes($condition = '')
    {
        $mySQLConnector = MySQLConnector::getInstance();

        $table = 'recipes';
        $query = "SELECT * FROM $table $condition;";
        $data = $mySQLConnector->getQueryResult($query);

        $recipes = array();
        foreach ($data as $elem) {
            $recipes[] = array(
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
        $recipes = $this->customMultiSort($recipes, 'name');
        return $recipes;
    }

    private function customMultiSort($array, $field)
    {
        $sortArr = array();
        foreach ($array as $key => $val) {
            $sortArr[$key] = $val[$field];
        }
        array_multisort($sortArr, $array);
        return $array;
    }

    private function get_favourite_ids()
    {

        if (isset($_SESSION['session_username'])) {
            $mySQLConnector = MySQLConnector::getInstance();

            $query = "SELECT fav_recipes FROM users WHERE name = '" . $_SESSION['session_username'] . "';";;
            $result = $mySQLConnector->getSingleValue($query, 'fav_recipes');
            return $result;
        }
    }
}