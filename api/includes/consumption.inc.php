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
// 				echo $sql;
		$this->stmt = $this->dbh->prepare($sql);
		if ( $result = $this->stmt->execute($vals) ) {
			$this->ActivityId = $this->dbh->lastInsertId();
		} 
// 		else  {
// // 			error_log(serialize($this->stmt->errorInfo()));
// 			echo '<pre>';print_r($this->stmt->errorInfo());echo '</pre>';
// 		}
		
		return $result;
	}
	
	/**
	 * 
	 * @param DateTime $date: SQL datetime 'Y-m-i' format
	 * @return Ambigous <boolean, multitype:>
	 */
	public function getConsumptionHourly($date) {
		
		$result = false;
		
		$search = "";
		$params = array();
		
		$search = " AND DATE(Start) = ?";
		$params[] = $date;
		
		$sql = "SELECT Start, Duration, ROUND(Cost, 4) AS Cost, ROUND(Value, 4) AS Value 
				FROM Consumptions
				WHERE 1 $search
				ORDER BY Start DESC";
// 		echo $sql;print_r($params);

		$this->stmt = $this->dbh->prepare($sql);
		if($this->stmt->execute($params)) {
			$result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
			$this->stmt->closeCursor();
		} 
		
		return $result;
	}
	
	public function getConsumptionTotal($start = '', $end = '') {
	
		$result = false;
	
		$search = "";
		$params = array();
	
		if(!empty($start)) {
			$search .= " AND DATE(Start) >= ?";
			$params[] = $start;
		}
		if(!empty($end)) {
			$search .= " AND DATE(Start) < ?";
			$params[] = $end;
		}
	
		$sql = "SELECT ROUND(SUM(Cost), 4) AS Cost, ROUND(SUM(Value), 4) AS Value
				FROM Consumptions
				WHERE 1 $search
				ORDER BY DATE(Start) DESC";
// 		echo $sql;print_r($params);
	
		$this->stmt = $this->dbh->prepare($sql);
		if($this->stmt->execute($params)) {
		$result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
		$this->stmt->closeCursor();
		}
	
		return $result;
	}
	
	public function getConsumptionDailyTotal($start = '', $end = '') {
	
		$result = false;
	
		$search = "";
		$params = array();
	
		if(!empty($start)) {
			$search .= " AND DATE(Start) >= ?";
			$params[] = $start;
		}
		if(!empty($end)) {
			$search .= " AND DATE(Start) < ?";
			$params[] = $end;
		}
	
		$sql = "SELECT DATE(Start) AS Day, ROUND(SUM(Cost), 4) AS Cost, ROUND(SUM(Value), 4) AS Value
				FROM Consumptions
				WHERE 1 $search
				GROUP BY DATE(Start)
				ORDER BY DATE(Start) DESC";
// 		echo $sql;print_r($params);
	
		$this->stmt = $this->dbh->prepare($sql);
		if($this->stmt->execute($params)) {
		$result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
		$this->stmt->closeCursor();
		}
	
		return $result;
	}
	
	public function getConsumptionDailyAverage($start = '', $end = '') {
	
		$result = false;
	
		$search = "";
		$params = array();
	
		if(!empty($start)) {
			$search .= " AND DATE(Start) >= ?";
			$params[] = $start;
		}
		if(!empty($end)) {
			$search .= " AND DATE(Start) < ?";
			$params[] = $end;
		}
		
		$sql = "SELECT DATE(Start) AS Day, AVG(Cost) AS Cost, AVG(Value) AS Value 
				FROM Consumptions
				WHERE 1 $search
				GROUP BY DATE(Start)";
// 		echo $sql;print_r($params);
		
		$this->stmt = $this->dbh->prepare($sql);
		if($this->stmt->execute($params)) {
			$result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
			$this->stmt->closeCursor();
		}
	
		return $result;
	}
}