<?php

class MySQLConnector
{

    private $connection;

    public function __construct($host, $user, $password, $db_name)
    {
        $this->connection = mysqli_connect($host, $user, $password, $db_name);
        mysqli_query($this->connection, "SET NAMES 'utf8'");
    }

    public function executeQuery($query)
    {
        mysqli_query($this->connection, $query);
    }

    public function getQueryResult($query)
    {
        $result = mysqli_query($this->connection, $query);
        $data = array();
        for (; $row = mysqli_fetch_assoc($result); $data[] = $row) ;
        return $data;
    }

    function getSingleValue($query, $columnName)
    {
        $q = mysqli_query($this->connection, $query);
        $f = mysqli_fetch_assoc($q);
        $result = $f[$columnName];
        return $result;
    }

    public function transformAll($res)
    {
        return mysqli_fetch_all($res);
    }

    public function getQueryResultWithoutTransformation($query)
    {
        return mysqli_query($this->connection, $query);
    }

    public function transformString($string)
    {
        return htmlentities(mysqli_real_escape_string($this->connection, $string));
    }

    public function getRowsNumber($res)
    {
        return mysqli_num_rows($res);
    }

    function existsTable($tablename)
    {
        $table_list = mysqli_query($this->connection, "SHOW TABLES from yom;");
        while ($row = mysqli_fetch_row($table_list)) {
            if (strcmp($tablename, $row[0]) == 0) {
                return true;
            }
        }
        return false;
    }
}

?>