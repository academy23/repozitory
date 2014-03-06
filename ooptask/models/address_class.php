<?php
include_once("db_class.php");
include_once("interface.php");
	
class Address extends Database implements IDatabaseFunction {
	private $id;
	private $country_id;
	private $city;
	private $street;
	private $house;
	private $zip_code;
	
	const UNKNOWN_STR = "Unknown";
	const UNKNOWN_INT = 0;

	function __construct() {
		$this->country_id = self::UNKNOWN_INT;
		$this->city = self::UNKNOWN_STR;
		$this->street = self::UNKNOWN_STR;
		$this->house = self::UNKNOWN_INT;
		$this->zip_code = self::UNKNOWN_STR;
	}

	public function getId() {
		return $this->id;
	}
	
	public function setId($value) {
		$this->id = $value;
	}

	public function getCountryId() {
		return $this->country_id;
	}

	public function setCountryId($value) {
		$this->country_id = $value;
	}
	
	public function getCity() {
		return $this->city;
	}
	
	public function setCity($value) {
		$this->city = $value;
	}
	
	public function getStreet() {
		return $this->street;
	}
	
	public function setStreer($value) {
		$this->street = $value;
	}
	
	public function getHouse() {
		return $this->house;
	}
	
	public function setHouse($value) {
		$this->house = $value;
	}
	
	public function getZipCode() {
		return $this->zip_code;
	}
	
	public function setZipCode($value) {
		$this->zip_code = $value;
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
		$sqlQuery = "INSERT INTO addresses(country) VALUES('".$this->country."')";
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function insertValue($value) {
		$con = $this->getConnector();
		$sqlQuery = 'INSERT INTO addresses (country_id, city, street, house, zip_code) VALUES("'.$value['country'].'", "'.$value['city'].'", "'.$value['street'].'", "'.$value['house'].'", "'.$value['zip_code'].'")';
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