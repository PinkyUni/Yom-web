<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 02.05.2019
 * Time: 0:04
 */

class User_Recipes_Model extends Model
{
    public function get_data()
    {
        require_once 'mysqlconnector.php';
        require_once 'constants.php';

        $mySQLConnector = new MySQLConnector(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        $table = 'recipes';
        $query = "SELECT * FROM $table;";
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
        return $recipes;
    }
}