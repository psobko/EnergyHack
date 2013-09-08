<?php
class Db {
    
	private $error;
	 
    function __construct() {
		$error = null;
	}

	public function getError() {
		return $this->error;
	}
	
	public function connect() {
		$dbconnection = false;
		
		$dsn = DSNDB;
		$user = USERDB;
		$password = PASSWORDDB;
		
		try {
			$dbconnection = new PDO($dsn, $user, $password);
			$dbconnection->setAttribute(PDO::ATTR_PERSISTENT, false);
			$dbconnection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
				
		} catch (PDOException $e) {
			$this->error = 'Connection failed: ' . $e->getMessage();
		}
		
		return $dbconnection;
	}
}
?>