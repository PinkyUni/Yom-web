<?php
/**
 * Created by PhpStorm.
 * User: Anya
 * Date: 07.05.2019
 * Time: 22:57
 */

class Comments_Manager_Model extends Model
{
    public function get_data() {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        $query = "SELECT * FROM comments WHERE accepted = 0";
        $data = $mySQLConnector->getQueryResult($query);

        $comments = array();
        foreach ($data as $elem) {
            $comments[] = array(
                'id' => $elem['id'],
                'text' => $elem['text'],
            );
        }
        return $comments;
    }

    public function accept_data() {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        foreach ($_POST['comments'] as $comment) {
            $query = "UPDATE comments SET accepted = 1 WHERE id = $comment;";
            $mySQLConnector->executeQuery($query);
        }
    }

    public function delete_data() {
        require_once 'mysqlconnector.php';

        $mySQLConnector = MySQLConnector::getInstance();

        var_dump($_POST['comments']);
        foreach ($_POST['comments'] as $comment) {
            $query = "DELETE FROM comments WHERE id = $comment;";
            $mySQLConnector->executeQuery($query);
        }
    }
}