<?php
class Consumption extends Base {
	
	
	public function Consumption($connection) {
		parent::__construct($connection);
	}
	/**
	 *
	 * @param Timestamp $start:
	 * @param Integer $duration: Seconds
	 * @param Integer $cost: 4 decimals float
	 * @param Integer $value: Watts
	 */
	public function insertConsumption($data) {

		$result = false;
	
// 		$data = $this->activity_for_update();
	
		$fields = array_keys($data);
		foreach($fields as $field) {
			$vals[] = $data[$field];
			$sqls[] = "?";
		}
	
		$sql = "INSERT INTO Consumptions
		(" . implode(', ', $fields) . ")
		VALUES (" . implode(', ', $sqls) . ")";
				echo $sql;
		$this->stmt = $this->dbh->prepare($sql);
		if ( $result = $this->stmt->execute($vals) ) {
			$this->ActivityId = $this->dbh->lastInsertId();
		} else  {
// 			error_log(serialize($this->stmt->errorInfo()));
			echo '<pre>';print_r($this->stmt->errorInfo());echo '</pre>';
		}
		
		return $result;
	}
}