<?php

class Main_Model extends Model
{

    public function get_data()
    {

        require_once 'mysqlconnector.php';
        require_once 'constants.php';

        $mySQLConnector = new MySQLConnector(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        $table = 'main';
        $query = "SELECT * FROM " . $table . ";";
        $result = $mySQLConnector->getQueryResult($query);

        $data = array();
        $i = 0;
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

            $data[$i] = array(
                'name' => $name,
                'url' => $url,
                'text' => $text,
                'img' => $img,
            );
            $i++;
        }

        return $data;
    }
}
