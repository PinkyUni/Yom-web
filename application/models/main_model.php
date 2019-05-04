<?php

class Main_Model extends Model
{

    public function get_data()
    {

        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $table = 'main';
        $query = "SELECT * FROM " . $table . ";";
        $result = $mySQLConnector->getQueryResult($query);

        $data = array();
        foreach ($result as $elem) {

            $name = $elem['name'];
            $url = $elem['url'];

            $text = "";
            $fd = fopen("data/" . $elem['description'], 'r') or die("не удалось открыть файл");
            while (!feof($fd)) {
                $text .= fgets($fd);
            }
            fclose($fd);

            $img = $elem['image'];

            $data[] = array(
                'name' => $name,
                'url' => $url,
                'text' => $text,
                'img' => $img,
            );
        }

        return $data;
    }
}
