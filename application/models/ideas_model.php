<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 08.05.2019
 * Time: 18:29
 */

class Ideas_Model extends Model
{
    public function get_votings()
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT * FROM votes";
        $data = $mySQLConnector->getQueryResult($query);

        $votes = array();
        foreach ($data as $elem) {
            $votes[] = array(
                'id' => $elem['id'],
                'name' => $elem['name'],
                'info' => $elem['info'],
            );
        }
        return $votes;
    }

    public function add_votes()
    {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        foreach ($_POST['var'] as $elem) {
            $query = "UPDATE votes SET var$elem = var$elem + 1;";
            $mySQLConnector->executeQuery($query);
        }
    }

}
