<?php
include_once("db_class.php");
include_once("interface.php");
	
class Faculty extends Database implements IDatabaseFunction {
	private $id;
	private $title_faculty;
	private $id_address;
	private $year_foundation;
	private $id_decan;
	
	const UNKNOWN_STR = "Unknown";
	const UNKNOWN_INT = 0;
	
	function __construct() {
		$this->title_faculty = self::UNKNOWN_STR;
		$this->id_address = self::UNKNOWN_INT;
		$this->year_foundation = self::UNKNOWN_INT;
		$this->id_decan = self::UNKNOWN_INT;
	}

	function writeArray($args) {
		$this->title_faculty = $args['title_faculty'];
		$this->id_address = $args['id_address'];
		$this->year_foundation = $args['year_foundation'];
		$this->id_decan = $args['id_decan'];
	}

	function writeArrayForId($index, $args) {
		$this->id = $index;
		$this->title_faculty = $args['title_faculty'];
		$this->id_address = $args['id_address'];
		$this->year_foundation = $args['year_foundation'];
		$this->id_decan = $args['id_decan'];
	}

	public function getId() {
		return $this->id;
	}
	
	public function setId($value) {
		$this->id = $value;
	}

	public function getTitleFaculty() {
		return $this->title_faculty;
	}

	public function setTitleFaculty($value) {
		$this->title_faculty = $value;
	}
	
	public function getIdAddress() {
		return $this->id_address;
	}

	public function setIdAddress($value) {
		$this->id_address = $value;
	}
	
	public function getYearFoundation() {
		return $this->year_foundation;
	}

	public function setYearFoundation($value) {
		$this->year_foundation = $value;
	}
	
	public function getIdDecan() {
		return $this->id_decan;
	}

	public function setIdDecan($value) {
		$this->id_decan = $value;
	}
	
	public function select($order = null) {
		$con = $this->getConnector();
		$GLOBALS['h1'] = "Факультети";
		$GLOBALS['content'] = '';
		$GLOBALS['content'] .= <<<TPL
		<div class="row-fluid"><a href="/?action=addFaculty" class="btn btn-info right">Додати факультет</a></div>
		<div class="row-fluid">
			<table class="table table-bordered" id="dt_gal">
				<thead>
					<tr style="text-align:center;">
						<th>№</th>
						<th>Назва факультету <a href="/?action=listFaculty&filter=title_faculty&order=ASC"><i class='icon-arrow-up'></i></a><a href="/?action=listFaculty&filter=title_faculty&order=DESC"><i class='icon-arrow-down'></i></a></th>
						<th>Адреса</th>
						<th>Рік заснування <a href="/?action=listFaculty&filter=year_foundation&order=ASC"><i class='icon-arrow-up'></i></a><a href="/?action=listFaculty&filter=year_foundation&order=DESC"><i class='icon-arrow-down'></i></a></th>
						<th>Декан</th>
						<th></th>
						<th>Предмети, <br/>що читаються на факультеті</th>
						<th>Викладачі, <br/>які працюють на факультеті</th>
					</tr>
				</thead>
			<tbody>
TPL;
		$query ="SELECT
					faculties.id as id_faculty, 
					faculties.id_address, 
					faculties.title_faculty, 
					faculties.year_foundation, 
					faculties.id_decan,
					lectors.id,
					lectors.surname,
					lectors.firstname,
					addresses.city,
					addresses.street,
					addresses.house,
					addresses.zip_code,
					addresses.country_id,
					countries.id,
					countries.country
				FROM 
					faculties
				LEFT JOIN lectors ON faculties.id_decan=lectors.id
				LEFT JOIN addresses ON faculties.id_address=addresses.id
				LEFT JOIN countries ON addresses.country_id=countries.id";
		
		$res=mysql_query($query);
		$i = 0;
		while($row=mysql_fetch_array($res)){
			$i = $i+1;
			$GLOBALS['content'] .= "
				<tr>
					<td>".$i."</td>
					<td>".$row['title_faculty']."</td>
					<td>".$row['country'].", ".$row['city'].", ".$row['street'].", ".$row['house'].".<br/>Поштовий індекс: ".$row['zip_code']."</td>
					<td>".$row['year_foundation']."</td>
					<td>".$row['surname']." ".$row['firstname']."</td>
					<td><a title='Редактировать' href='/?action=editFaculty&id=".$row['id_faculty']."'><i class='icon-pencil'></i></a></td>
					<td><a title='Предмети' href='/?action=subjectOfFaculty&id=".$row['id_faculty']."'><i class='icon-th-large'></i></a></td>
					<td><a title='Предмети' href='/?action=lectorOfFaculty&id=".$row['id_faculty']."'><i class='icon-home'></i></a></td>
				<tr/>";
		}
		$GLOBALS['content'] .= '</tbody></table></div>';

		$this->closeConnection($res, $con);
	}
	
	public function insert() {
		$con = $this->getConnector();
		$sqlQuery = "INSERT INTO faculties(title_faculty, id_address, year_foundation, id_decan) VALUES('".$this->title_faculty."', '".$this->id_address."', '".$this->year_foundation."','".$this->id_decan."')";
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function insertValue($value) {
		$con = $this->getConnector();
		$sqlQuery = 'INSERT INTO faculties(title_faculty, id_address, year_foundation, id_decan) 
						VALUES("'.$value['title_faculty'].'", "'.$value['id_address'].'", "'.$value['year_foundation'].'", "'.$value['id_decan'].'")';
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function update() {
		$con = $this->getConnector();
		$sqlQuery = "UPDATE faculties SET title_faculty='".$this->title_faculty."', year_foundation = '".$this->year_foundation."', id_decan = '".$this->id_decan."'  WHERE id=".intval($this->id);
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function updateValue($index, $value) {
		$con = $this->getConnector();
		$sqlQuery = "UPDATE faculties SET title_faculty='".$value['title_faculty']."', year_foundation = '".$value['year_foundation']."', id_decan = '".$value['id_decan']."'  WHERE id=".intval($index);
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
		$sqlQuery = "SELECT id, title_faculty FROM faculties";
		$result = $db->getQueryResult($con, $sqlQuery);
		$list_faculties = "<option value=''></option>";
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$list_faculties .= "<option value=\"".$row['id']."\">".$row['title_faculty']."</option>";
		}
		$db->closeConnection($result, $con);
		
		return $list_faculties;
	}
	
	
	
}
	
	
?>