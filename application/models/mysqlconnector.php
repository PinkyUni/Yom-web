<?php

class MySQLConnector
{

    private static $connection;
    private static $_instance = null;

    private function __construct()
    {
        require_once 'constants.php';
        self::$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        mysqli_query(self::$connection, "SET NAMES 'utf8'");
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (self::$_instance != null) {
            return self::$_instance;
        }

        return new self;
    }

    public function executeQuery($query)
    {
        return mysqli_query(self::$connection, $query);
    }

    public function getQueryResult($query)
    {
        $result = mysqli_query(self::$connection, $query);
        $data = array();
        for (; $row = mysqli_fetch_assoc($result); $data[] = $row) ;
        return $data;
    }

    function getSingleValue($query, $columnName)
    {
        $q = mysqli_query(self::$connection, $query);
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
        return mysqli_query(self::$connection, $query);
    }

    public function transformString($string)
    {
        return htmlentities(mysqli_real_escape_string(self::$connection, $string));
    }

    public function getString($string)
    {
        return html_entity_decode($string);
    }

    public function getRowsNumber($res)
    {
        return mysqli_num_rows($res);
    }

    function existsTable($tablename)
    {
        $table_list = mysqli_query(self::$connection, "SHOW TABLES from yom;");
        while ($row = mysqli_fetch_row($table_list)) {
            if (strcmp($tablename, $row[0]) == 0) {
                return true;
            }
        }
        return false;
    }
}

?>