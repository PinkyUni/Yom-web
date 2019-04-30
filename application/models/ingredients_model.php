<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 24.04.2019
 * Time: 23:53
 */

class Ingredients_Model extends Model {

    function get_data()
    {
        include 'mysqlconnector.php';
        $host = 'localhost';
        $user = 'root';
        $password = 'suka';
        $db_name = 'Yom';
        $mySQLConnector = new MySQLConnector($host, $user, $password, $db_name);

        $table = 'ingredients';
        $query = "SELECT * FROM $table;";
        $result = $mySQLConnector->getQueryResult($query);

        $data = array();
        $i = 0;
        foreach ($result as $elem) {

            $name = $elem['name'];

            $text = "";
            $fd = fopen("data/" . $elem['description'], 'r') or die("не удалось открыть файл");
            while (!feof($fd)) {
                $text .= fgets($fd);
            }
            fclose($fd);

            $img1 = $elem['img1'];
            $img2 = $elem['img2'];

            $data[$i] = array(
                'name' => $name,
                'text' => $text,
                'img1' => $img1,
                'img2' => $img2,
            );
            $i++;
        }

        return $data;
    }

}