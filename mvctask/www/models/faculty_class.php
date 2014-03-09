<?php
include_once("db_class.php");

class Faculty extends Database{
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
	
	public function listFaculties($order = null) {
		if(isset($_GET['filter'])){
			switch ($_GET['filter']){
				case 'search':
					$filter = "WHERE title_faculty LIKE '%{$_GET['query']}%'";
					break;
				case 'title_faculty':
					$filter = 'ORDER BY title_faculty '.$_GET['order'];
					break;
				case 'year_foundation':
					$filter = 'ORDER BY year_foundation '.$_GET['order'];
					break;
				
				default: $filter = '';
					break;
			}
		}else{
			$filter = "";
		}
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
				LEFT JOIN countries ON addresses.country_id=countries.id
				{$filter}";
		
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
	
	public function addFacultyDo(){
		include ("models/address_class.php");
		$address['country'] = $_POST['country'];
		$address['city'] = $_POST['city'];
		$address['street'] = $_POST['street'];
		$address['house'] = $_POST['house'];
		$address['zip_code'] = $_POST['zip_code'];
		
		$obj_address = new Address();
		$obj_address->addAdress($address);
		
		$this->title_faculty = $_POST['faculty'];
		$this->year_foundation = $_POST['year_foundation'];
		$this->id_decan = '0';
		
		$db = new Database();
		$con = $db->getConnector();
		$sqlQuery="SELECT max(id) as max_id FROM addresses";
		$res = $db->getQueryResult($con, $sqlQuery);
		$row = mysql_fetch_array($res,MYSQL_ASSOC);
		$this->id_address = $row['max_id'];
		
		$sqlQuery = 'INSERT INTO faculties (title_faculty, id_address, year_foundation, id_decan) VALUES ("'.$this->title_faculty.'", "'.$this->id_address.'", "'.$this->year_foundation.'", "'.$this->id_decan.'")';
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}
	
	public function editFacultyDo(){
		$con = $this->getConnector();
		$sqlQuery = "UPDATE faculties SET title_faculty='".$_POST['faculty']."', year_foundation = '".$_POST['year_foundation']."', id_decan = '".$_POST['decan']."'  WHERE id=".intval($_POST['id']);
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
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
	
	public function search(){
		$GLOBALS['h1'] = "Пошук";
		$GLOBALS['content'] = <<<HTML
		<div class="row-fluid">
			<div class="span6">
				<form class="well form-inline" method="POST" action="/?action=searchDo">
					<div class="row-fluid">
						<label>Ключове слово</label>
						<input type="text" name="search" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						<label>Таблиця</label>
						<select name="table" class="span12">
							<option value=""></option>
							<option value="faculties">Факультет</option>
							<option value="lectors">Лектор</option>
							<option value="subjects">Предмет</option>
						</select>
					</div>
					<div class="row-fluid">
						<button type="submit" class="btn">Пошук</button>
					</div>
				</form>
			</div>
		</div>
HTML;
	}
	
	public function searchDo(){
		if($_POST['table']=='lectors'){
			header('Location: /?action=listLectors&filter=search&query='.$_POST['search'], true, 303);
		}elseif($_POST['table']=='faculties'){
			header('Location: /?action=listFaculties&filter=search&query='.$_POST['search'], true, 303);
		}elseif($_POST['table']=='subjects'){
			header('Location: /?action=listSubjects&filter=search&query='.$_POST['search'], true, 303);
		}else{
			header('Location: /?action=listLectors', true, 303);
		}
	}
	
	public function subjectOfFaculty(){
		$con = $this->getConnector();
		$sqlQuery="SELECT 
					subjects.title_subject,
					subjects.id_lector,
					subjects.id_faculty,
					faculties.id,
					faculties.title_faculty,
					lectors.surname,
					lectors.firstname
				FROM 
					subjects
				LEFT JOIN faculties ON subjects.id_faculty=faculties.id
				LEFT JOIN lectors ON subjects.id_lector=lectors.id
				WHERE subjects.id_faculty={$_GET['id']}";
		$result = $this->getQueryResult($con, $sqlQuery);
		$i = 0;
		$GLOBALS['content'] = '';
		$GLOBALS['content'] .= <<<TPL
		<div class="row-fluid">
			<table class="table table-bordered" id="dt_gal">
				<thead>
					<tr style="text-align:center;">
						<th>№</th>
						<th>Назва предмету</th>
						<th>Лектор</th>	
					</tr>
				</thead>
			<tbody>
TPL;
		while($row=mysql_fetch_array($result)){
			if($i==0){
				$title_faculty = $row['title_faculty'];
			}
			$GLOBALS['h1'] = "Факультет: ".$title_faculty;
			$i = $i+1;
			$GLOBALS['content'] .= "
				<tr>
					<td>".$i."</td>
					<td>".$row['title_subject']."</td>
					<td>".$row['surname']." ".$row['firstname']."</td>
				<tr/>";
		}
		$GLOBALS['content'] .= '</tbody></table></div>';
		$this->closeConnection($result, $con);
	}
	
	function lectorOfFaculty(){
		$con = $this->getConnector();
		$sqlQuery="SELECT 
					faculties.id,
					faculties.title_faculty,
					lectors.surname,
					lectors.firstname,
					lectors.id_faculty_work
				FROM 
					lectors
				LEFT JOIN faculties ON lectors.id_faculty_work=faculties.id
				WHERE lectors.id_faculty_work={$_GET['id']}";
		$result = $this->getQueryResult($con, $sqlQuery);
		$i = 0;
		$GLOBALS['content'] = '';
		$GLOBALS['content'] .= <<<TPL
		<div class="row-fluid">
			<table class="table table-bordered" id="dt_gal">
				<thead>
					<tr style="text-align:center;">
						<th>№</th>
						<th>Лектор</th>	
					</tr>
				</thead>
			<tbody>
TPL;
		while($row=mysql_fetch_array($result)){
			if($i==0){
				$title_faculty = $row['title_faculty'];
			}
			$GLOBALS['h1'] = "Факультет: ".$title_faculty;
			$i = $i+1;
			$GLOBALS['content'] .= "
				<tr>
					<td>".$i."</td>
					<td>".$row['surname']." ".$row['firstname']."</td>
				<tr/>";
		}
		$GLOBALS['content'] .= '</tbody></table></div>';
		$this->closeConnection($result, $con);
	}
	
	
	
}
	
	
?>