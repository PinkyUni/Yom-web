<?php

class MySQLConnector {
	
	private $connection;
	
	public function __construct($host, $user, $password, $db_name) {
		$this->connection = mysqli_connect($host, $user, $password, $db_name);
		mysqli_query($this->connection, "SET NAMES 'utf8'");
	}
	
	public function executeQuery($query) {
		mysqli_query($this->connection, $query);
	}
	
	public function getQueryResult($query) {
		$result = mysqli_query($this->connection, $query);
        $data = array();
		for (; $row = mysqli_fetch_assoc($result); $data[] = $row);
		return $data;
	}

	public function getQueryResultWithoutTransformation($query) {
	    return mysqli_query($this->connection, $query);
    }

	public function transformString($string) {
		return htmlentities(mysqli_real_escape_string($this->connection, $string));
	}

	public function getRowsNumber($res) {
        return mysqli_num_rows($res);
    }
}

?>