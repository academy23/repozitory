<?php
include_once("db_class.php");
	
class Address extends Database{
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
	
	public function addAdress($value) {
		$con = $this->getConnector();
		$sqlQuery = 'INSERT INTO addresses (country_id, city, street, house, zip_code) VALUES("'.$value['country'].'", "'.$value['city'].'", "'.$value['street'].'", "'.$value['house'].'", "'.$value['zip_code'].'")';
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}
}
	
	
?>