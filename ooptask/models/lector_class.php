<?php
include_once("db_class.php");
include_once("interface.php");


class Lector extends Database implements IDatabaseFunction {
	private $id;
	private $surname;
	private $firstname;
	private $date_of_birth;
	private $degree;
	private $post;
	private $id_faculty_work;

	const UNKNOWN_STR = "Unknown";
	const UNKNOWN_INT = 0;

	function __construct() {		
		$this->surname = self::UNKNOWN_STR;
		$this->firstname = self::UNKNOWN_STR;
		$this->date_of_birth = self::UNKNOWN_INT;
		$this->degree = self::UNKNOWN_STR;
		$this->post = self::UNKNOWN_STR;
		$this->id_faculty_work = self::UNKNOWN_INT;
	}

	function writeArray($args) {
		$this->surname = $args['surname'];
		$this->firstname = $args['firstname'];
		$this->date_of_birth = $args['date_of_birth'];
		$this->degree = $args['degree'];
		$this->post = $args['post'];
		$this->id_faculty_work = $args['id_faculty_work'];
	}

	function writeArrayForId($index, $args) {
		$this->id = $index;
		$this->surname = $args['surname'];
		$this->firstname = $args['firstname'];
		$this->date_of_birth = $args['date_of_birth'];
		$this->degree = $args['degree'];
		$this->post = $args['post'];
		$this->id_faculty_work = $args['id_faculty_work'];
	}

	public function getId() {
		return $this->id;
	}

	public function setId($value) {
		$this->id = $value;
	}

	public function getSurname() {
		return $this->surname;
	}

	public function setSurname($value) {
		$this->surname = $value;
	}

	public function getFirstname() {
		return $this->firstname;
	}

	public function setFirstname($value) {
		$this->firstname = $value;
	}

	public function getDateOfBirth() {
		return $this->date_of_birth;
	}

	public function setDateOfBirth($value) {
		$this->date_of_birth = $value;
	}

	public function getDegree() {
		return $this->degree;
	}

	public function setDegree($value) {
		$this->degree = $value;
	}

	public function getPost() {
		return $this->post;
	}

	public function setPost($value) {
		$this->post = $value;
	}
	
	public function getIdFacultyWork() {
		return $this->id_faculty_work;
	}

	public function setIdFacultyWork($value) {
		$this->id_faculty_work = $value;
	}

	public function select($order = null) {
		$con = $this->getConnector();
		$sqlQuery="SELECT 
					lectors.id,
					lectors.surname,
					lectors.firstname,
					lectors.date_of_birth,
					lectors.degree,
					lectors.post,
					lectors.id_faculty_work,
					faculties.title_faculty
				FROM 
					lectors,
					faculties
				WHERE 
					lectors.id_faculty_work=faculties.id";
		$result = $this->getQueryResult($con, $sqlQuery);		
		$GLOBALS['h1'] = "Лектори";
		$GLOBALS['content'] .= <<<TPL
		<div class="row-fluid"><a href="/?action=addLector" class="btn btn-info right">Додати лектора</a></div>
		<div class="row-fluid">
			<table class="table table-bordered" id="dt_gal">
				<thead>
					<tr style="text-align:center;">
						<th>№</th>
						<th>Прізвище Ім'я <a href="/?action=listLector&filter=surname&order=ASC"><i class='icon-arrow-up'></i></a><a href="/?action=listLector&filter=surname&order=DESC"><i class='icon-arrow-down'></i></a></th>
						<th>Дата народження <a href="/?action=listLector&filter=date_of_birth&order=ASC"><i class='icon-arrow-up'></i></a><a href="/?action=listLector&filter=date_of_birth&order=DESC"><i class='icon-arrow-down'></i></a></th>
						<th>Науковий ступінь</th>
						<th>Посада</th>
						<th>Факультет</th>
						<th></th>
						<th>Предмети лектора</th>
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
					<td>".$row['surname']." ".$row['firstname']."</td>
					<td>".date('d.m.Y', $row['date_of_birth'])."</td>
					<td>".$row['degree']."</td>
					<td>".$row['post']."</td>
					<td>".$row['title_faculty']."</td>
					<td><a href=\"?action=editLector&id=".$row['id']."\"><i class='icon-pencil'></i></a><a class='confirm del' href=\"?action=deleteLector&id=".$row['id']."\"><i class='icon-trash'></i></a></td>
					<td><a href=\"?action=subjectOfLector&id=".$row['id']."\"><i class='icon-user'></i></a></td>
				<tr/>";
		}
		$GLOBALS['content'] .= '</tbody></table></div>';
		$this->closeConnection($result, $con);
	}


	public function insert() {
		$con = $this->getConnector();
		$sqlQuery = 'INSERT INTO lectors(surname, firstname, date_of_birth, degree, post, id_faculty_work)
				VALUES("'.$this->surname.'", "'.$this->firstname.'", "'.$this->date_of_birth.'", "'.$this->degree.'", "'.$this->post.'", "'.intval($this->id_faculty_work).'")';
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function insertValue($value) {
		$con = $this->getConnector();
		$sqlQuery = 'INSERT INTO lectors (surname, firstname, date_of_birth, degree, post, id_faculty_work) 
			VALUES ("'.$value['surname'].'", "'.$value['firstname'].'", "'.$value['date_of_birth'].'", "'.$value['degree'].'", "'.$value['post'].'", "'.$value['id_faculty'].'")';
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function update() {
		$con = $this->getConnector();
		$sqlQuery = "UPDATE lectors SET surname='".$this->surname."', firstname='".$this->firstname."', date_of_birth='".$this->date_of_birth."', degree='".$this->degree."', post='".$this->post."', id_faculty_work=".intval($this->id_faculty_work)." WHERE id=".intval($this->id);
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function updateValue($index, $value) {
		$con = $this->getConnector();
		$sqlQuery = "UPDATE lectors SET surname='".$value['surname']."', firstname='".$value['firstname']."', date_of_birth='".$value['date_of_birth']."', degree='".$value['degree']."', post='".$value['post']."', id_faculty_work=".intval($value['id_faculty_work'])." WHERE id=".intval($index);
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function delete() {
		$con = $this->getConnector();
		$sqlQuery = "DELETE FROM lectors WHERE id=".intval($this->id);
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function deleteById($index) {
		$con = $this->getConnector();
		$sqlQuery = "DELETE FROM lectors WHERE id=".intval($index)." LIMIT 1";
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function search($part_of_word) {
		
	}

	public static function getList() {
		$db = new Database();
		$con = $db->getConnector();
		$sqlQuery = "SELECT id, surname, firstname FROM lectors";
		$result = $db->getQueryResult($con, $sqlQuery);
		$list_lectors = "<option value=''></option>";
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$list_lectors .= "<option value=\"".$row['id']."\">".$row['surname']." ".$row['firstname']."</option>";
		}
		$db->closeConnection($result, $con);
		
		return $list_lectors;
	}
}
?>