<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 08.05.2019
 * Time: 16:52
 */

class Create_Voting_Model extends Model
{

    public function add_voting() {

        require_once "mysqlconnector.php";

        $mysqlconnector = MySQLConnector::getInstance();

        $info = implode("\n", $_POST['var']);
        $name = $_POST['name'];
        $query = "INSERT INTO votes (name, info) VALUES ('$name', '$info');";
        $mysqlconnector->executeQuery($query);

    }


}