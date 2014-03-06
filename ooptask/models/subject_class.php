<?php
include_once("db_class.php");
include_once("interface.php");
	
class Country extends Database implements IDatabaseFunction {
	private $id;
	private $country;
	
	const UNKNOWN_STR = "Unknown";

	function __construct() {
		$this->country = self::UNKNOWN_STR;
	}

	function writeArray($args) {
		$this->country = $args['country'];
	}

	function writeArrayForId($index, $args) {
		$this->id = $index;
		$this->country = $args['country'];
	}

	public function getId() {
		return $this->id;
	}
	
	public function setId($value) {
		$this->id = $value;
	}

	public function getCountry() {
		return $this->country;
	}

	public function setCountry($value) {
		$this->country = $value;
	}
	
	public function select($order = null) {
		$con = $this->getConnector();
		$sqlQuery = "SELECT * FROM countries";
		$result = $this->getQueryResult($con, $sqlQuery);
		$GLOBALS['h1'] = "Країни";
		$GLOBALS['content'] = '';
		$GLOBALS['content'] .= <<<TPL
		<div class="row-fluid"><a href="/?action=addCountry" class="btn btn-info right">Додати країну</a></div>
		<div class="row-fluid">
			<table class="table table-bordered" id="dt_gal">
				<thead>
					<tr style="text-align:center;">
						<th>№</th>
						<th>Країна</th>
						<th></th>
					</tr>
				</thead>
			<tbody>
TPL;
		$i=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$i=$i+1;
			$GLOBALS['content'] .= "
				<tr>
					<td>".$i."</td>
					<td>".$row['country']."</td>
					<td><a href='/?action=deleteCountry&id={$row['id']}'>Видалити</a></td>
				<tr/>";
		}
		$GLOBALS['content'] .= '</tbody></table></div>';
		$this->closeConnection($result, $con);
	}
	
	public function insert() {
		$con = $this->getConnector();
		$sqlQuery = "INSERT INTO countries(country) VALUES('".$this->country."')";
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function insertValue($value) {
		$con = $this->getConnector();
		$sqlQuery = 'INSERT INTO countries (country) VALUES("'.$value['country'].'")';
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function update() {
		$con = $this->getConnector();
		$sqlQuery = "UPDATE countries SET country='".$this->country."' WHERE id=".intval($this->id);
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function updateValue($index, $value) {
		$con = $this->getConnector();
		$sqlQuery = "UPDATE countries SET country='".$value."' WHERE id=".intval($index);
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function delete() {
		$con = $this->getConnector();
		$sqlQuery = "DELETE FROM countries WHERE id=".intval($this->id);
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function deleteById($index) {
		$con = $this->getConnector();
		$sqlQuery = "DELETE FROM countries WHERE id=".intval($index)." LIMIT 1";
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function search($part_of_word) {
		$con = $this->getConnector();
		$sqlQuery = "SELECT id, country FROM countries WHERE country LIKE '%".$part_of_word."%'";
		$result = $this->getQueryResult($con, $sqlQuery);
		$GLOBALS['h1'] = "Країни";
		$GLOBALS['content'] = '';
		$GLOBALS['content'] .= <<<TPL
		<div class="row-fluid"><a href="/?action=addCountry" class="btn btn-info right">Додати країну</a></div>
		<div class="row-fluid">
			<table class="table table-bordered" id="dt_gal">
				<thead>
					<tr style="text-align:center;">
						<th>№</th>
						<th>Країна</th>
					</tr>
				</thead>
			<tbody>
TPL;
		$i=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$i=$i+1;
			$GLOBALS['content'] .= "
				<tr>
					<td>".$i."</td>
					<td>".$row['country']."</td>
				<tr/>";
		}
		$GLOBALS['content'] .= '</tbody></table></div>';
		$this->closeConnection($result, $con);
	}

	public static function getList() {
		$db = new Database();
		$con = $db->getConnector();		
		$sqlQuery = "SELECT id, country FROM countries";
		$result = $db->getQueryResult($con, $sqlQuery);
		$list_country = "<select name='countries' class='span12'><option value=''></option>";
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$list_country.="<option value='".$row['id']."'>".$row['country']."</option>";
		}
		$list_country.="</select>";
		$db->closeConnection($result, $con);
		
		return $list_country;
	}
	
	
	
}
	
	
?>