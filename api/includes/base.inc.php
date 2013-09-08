<?php
class Base 
{
	protected $dbh;
	protected $stmt;
	
	public function __construct($connection) {
		// Development Stage: To by replaced by Prod Stage when no more warnings are issued
		if (!isset($connection)) {
			$db = new Db();
			$this->dbh = $db->connect();
		} else 
			$this->dbh = $connection;

		// Prod Stage
// 		$this->dbh = $connection;
	}
	
	public function __destruct() {
		$this->dbh = null;
	}
	
	/**
	 * Insert a row into a table
	 * @param String $table: Table name where to insert
	 * @param AssociativeArray $data: Array where keys are the name of the fields and values are the content
	 * @return Boolean|SqlErrorCode: True on success. SqlError otherwise.
	 * @uses Usage Examples:
	 * 			Table 'Users': 'UserId', 'Name', 'Surname'
	 * 			insertGeneric('Users', array('UserId' => 1,'Name' => 'John', 'Surname' => 'Smith'));
	 *
	 * 			Table 'Users' with UserId set as AutoIncrement.
	 * 			insertGeneric('Users', array('Name' => 'John', 'Surname' => 'Smith'));
	 */
	protected function insertGeneric($table, $data = array()) {
		// Updated fields information
		$fields = array_keys($data);
		foreach($fields as $field):
		$vals[] = $data[$field];
		$sqls[] = "?";
		endforeach;
	
		// Id information
		// 		$idFields = array_keys($ids);
		// 		foreach($idFields as $idField):
		// 		$idValues[] = $ids[$idField];
		// 		$idSqls[] = "$idField = ?";
		// 		endforeach;
	
		// Insert
		$sql = "INSERT INTO ".$table." (".implode(', ',$fields).") VALUES (".implode(', ',$sqls).")";
		$this->stmt = $this->dbh->prepare($sql);
// 		echo $sql."\n";print_r($vals);echo "\n";
		$sqlerror = true;
		try {
			if ( !$this->stmt->execute($vals) ) {
				$sqlerror = $this->stmt->errorCode();
			}
		} catch (PDOException $e) {
			$sqlerror = $e->getCode();
		}
		//TODO: Log the actions taken by the users
		// 		if(empty($sqlerror))
		// 			$this->log_action($userdb['id'],'update',$this->table,$id);
		return $sqlerror;
	}
	
	/**
	 * Update table information.
	 * @param String $table: Table name you want to update
	 * @param AsociativeArray $data: Array where keys are the name of the fields and values are the content
	 * @param AsociativeArray $id: Array with key elements to identify a single row in the table. (Keys = Id Field Names), (Values = Id Field Content)
	 * @return Boolean|SQLErrorCode: True on success. SqlError otherwise.
	 * @uses Usage Example:
	 * 			Table 'Users': 'UserId', 'Name', 'Surname'
	 * 			updateGeneric('Users',
	 * 							array('Name' => 'John', 'Surname' => 'Smith'),
	 * 							array('UserId' => 0));
	 */
	protected function updateGeneric($table, $data = array(), $ids = array()) {
		// Updated fields information
		$fields = array_keys($data);
		foreach($fields as $field):
		$vals[] = $data[$field];
		$sqls[] = "$field = ?";
		endforeach;
	
		// Id information
		$idFields = array_keys($ids);
		foreach($idFields as $idField):
		$idValues[] = $ids[$idField];
		$idSqls[] = "$idField = ?";
		endforeach;
	
		// Update
		$sql = "UPDATE ". $table ." SET ".implode(', ',$sqls)." WHERE ".implode(' AND ',$idSqls)."";
		$this->stmt = $this->dbh->prepare($sql);//echo $sql."\n";print_r(array_merge($vals,$idValues));echo "\n";
		$sqlerror = true;
		try {
			if ( !$this->stmt->execute(array_merge($vals, $idValues)) ) {
				$sqlerror = $this->stmt->errorCode();
			}
		} catch (PDOException $e) {
			$sqlerror = $e->getCode();
		}
	
		//TODO: Log the actions taken by the users
		// 		if(empty($sqlerror))
		// 			$this->log_action($userdb['id'],'update',$this->table,$id);
		$this->stmt->closeCursor();
		return $sqlerror;
	}
	
}