<?php
include_once("db_class.php");

class Lector extends Database{
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

	public function listLectors($order = null) {
		$con = $this->getConnector();
		
		if(isset($_GET['filter'])){
			switch ($_GET['filter']){
				case 'search':
					$filter = "AND surname LIKE '%{$_GET['query']}%'";
					break;
				case 'surname':
					$filter = 'ORDER BY surname '.$_GET['order'].', firstname '.$_GET['order'];
					break;
				case 'date_of_birth':
					$filter = 'ORDER BY date_of_birth '.$_GET['order'];
					break;
				
				default: $filter = '';
					break;
			}
		}else{
			$filter = "";
		}
		
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
					lectors.id_faculty_work=faculties.id
					{$filter}";
		$result = $this->getQueryResult($con, $sqlQuery);		
		$GLOBALS['h1'] = "Лектори";
		$GLOBALS['content'] .= <<<TPL
		<div class="row-fluid"><a href="/?action=addLector" class="btn btn-info right">Додати лектора</a></div>
		<div class="row-fluid">
			<table class="table table-bordered" id="dt_gal">
				<thead>
					<tr style="text-align:center;">
						<th>№</th>
						<th>Прізвище Ім'я <a href="/?action=listLectors&filter=surname&order=ASC"><i class='icon-arrow-up'></i></a><a href="/?action=listLectors&filter=surname&order=DESC"><i class='icon-arrow-down'></i></a></th>
						<th>Дата народження <a href="/?action=listLectors&filter=date_of_birth&order=ASC"><i class='icon-arrow-up'></i></a><a href="/?action=listLectors&filter=date_of_birth&order=DESC"><i class='icon-arrow-down'></i></a></th>
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

	public function addLector(){
		$GLOBALS['h1'] = "Додавання нового лектора";
		$faculty_work = Faculty::getList();
					
		$GLOBALS['content'] = <<<HTML
		<div class="row-fluid">
			<div class="span6">
				<form class="well form-inline" method="POST" action="/?action=addLectorDo">
					<div class="row-fluid">
						<label>Прізвище</label>
						<input type="text" name="surname" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						<label>Ім'я</label>
						<input type="text" name="firstname" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						<label>Дата народження</label>
						<input type="text" name="date_of_birth" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						<label>Науковий ступінь</label>
						<select name="degree" class="span12">
							<option value=""></option>
							<option value="Кандидат наук">Кандидат наук</option>
							<option value="Доктор наук">Доктор наук</option>
						</select>
					</div>
					<div class="row-fluid">
						<label>Посада</label>
						<select name="post" class="span12">
							<option value=""></option>
							<option value="Асистент">Асистент</option>
							<option value="Викладач">Викладач</option>
							<option value="Доцент">Доцент</option>
							<option value="Професор">Професор</option>
						</select>
					</div>
					<div class="row-fluid">
						<label>Факультет на якому працює</label>
						<select name='id_faculty' class='span12'>
						{$faculty_work}
						</select>
					</div>
					<div class="row-fluid">
						<button type="submit" name="submitLector" class="btn">Додати</button>
					</div>
				</form>
			</div>
		</div>
HTML;
	}
	
	public function addLectorDo() {
		$con = $this->getConnector();
		
		$this->surname = $_POST['surname'];
		$this->firstname = $_POST['firstname'];
		$array_date = explode('.', $_POST['date_of_birth']);
		$this->date_of_birth = strtotime($array_date['0'].".".$array_date['1'].".".$array_date['2']);
		$this->degree = $_POST['degree'];
		$this->post = $_POST['post'];
		$this->id_faculty = $_POST['id_faculty'];								
		
		$sqlQuery = 'INSERT INTO lectors (surname, firstname, date_of_birth, degree, post, id_faculty_work) 
			VALUES ("'.$this->surname.'", "'.$this->firstname.'", "'.$this->date_of_birth.'", "'.$this->degree.'", "'.$this->post.'", "'.$this->id_faculty.'")';
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}
	
	public function editLector(){
		$id = $_GET['id'];
		$faculties = Faculty::getList();
					
		$db = new Database();
		$con = $db->getConnector();
		$sqlQuery="SELECT * FROM lectors WHERE id = {$id}";
		$res = $db->getQueryResult($con, $sqlQuery);
		$row = mysql_fetch_array($res,MYSQL_ASSOC);
		
		$text_degree = '<option value=""></option>
			<option value="Кандидат наук">Кандидат наук</option>
			<option value="Доктор наук">Доктор наук</option>';		
		$var_degree = 'value="'.$row['degree'].'"';
		$chose_degree = Support::getSelect($text_degree,$var_degree);

		$text_post = '<option value=""></option>
			<option value="Асистент">Асистент</option>
			<option value="Викладач">Викладач</option>
			<option value="Доцент">Доцент</option>
			<option value="Професор">Професор</option>';		
		$var_post = 'value="'.$row['post'].'"';
		$chose_post = Support::getSelect($text_post,$var_post);
		
		$var_faculty = 'value="'.$row['id_faculty_work'].'"';
		$chose_faculty = Support::getSelect($faculties, $var_faculty);
		
		$date_of_birth = date('d.m.Y', $row['date_of_birth']);

		$GLOBALS['h1'] = "Редагування";
		$GLOBALS['content'] = <<<HTML
		<div class="row-fluid">
			<div class="span6">
				<form class="well form-inline" method="POST" action="/?action=editLectorDo">
					<div class="row-fluid">
						<label>Прізвище</label>
						<input type="text" name="surname" class="span12" value="{$row['surname']}"/>
					</div>
					<div class="row-fluid">
						<label>Ім'я</label>
						<input type="text" name="firstname" class="span12" value="{$row['firstname']}"/>
					</div>
					<div class="row-fluid">
						<label>Дата народження</label>
						<input type="text" name="date_of_birth" class="span12" value="{$date_of_birth}"/>
					</div>
					<div class="row-fluid">
						<label>Науковий ступінь</label>
						<select name="degree" class="span12">
							{$chose_degree}
						</select>
					</div>
					<div class="row-fluid">
						<label>Посада</label>
						<select name="post" class="span12">
							{$chose_post}
						</select>
					</div>
					<div class="row-fluid">
						<label>Факультет на якому працює</label>
						<select name='id_faculty' class='span12'>
						{$chose_faculty}
						</select>
					</div>
					<div class="row-fluid">
						<button type="submit" name="submitLector" class="btn">Змінити</button>
						<input type="hidden" name="id" value="{$row['id']}"/>
					</div>
				</form>
			</div>
		</div>
HTML;
		$db->closeConnection($res, $con);
	}
	
	public function editLectorDo() {
		$con = $this->getConnector();
		$array_date = explode('.', $_POST['date_of_birth']);
		$date_of_birth = strtotime($array_date['0'].".".$array_date['1'].".".$array_date['2']);
		$sqlQuery = 'UPDATE lectors SET surname = "'.$_POST["surname"].'",  firstname = "'.$_POST["firstname"].'",  date_of_birth = "'.$date_of_birth.'",  degree = "'.$_POST["degree"].'",  post = "'.$_POST["post"].'",  id_faculty_work = "'.$_POST["id_faculty"].'" WHERE id = "'.$_POST['id'].'"';
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function deleteById($index) {
		$con = $this->getConnector();
		$sqlQuery = "DELETE FROM lectors WHERE id=".intval($index)." LIMIT 1";
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
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
	
	public function subjectOfLector(){
		$con = $this->getConnector();
		$sqlQuery="SELECT 
					subjects.title_subject,
					subjects.id_lector,
					subjects.id_faculty,
					faculties.title_faculty,
					faculties.id,
					lectors.surname,
					lectors.firstname
				FROM 
					subjects,
					faculties,
					lectors
				WHERE
					subjects.id_lector={$_GET['id']} AND subjects.id_faculty=faculties.id AND lectors.id={$_GET['id']}";
					
		$result = $this->getQueryResult($con, $sqlQuery);
		$i = 0;
		
		$GLOBALS['content'] = '';
		$GLOBALS['content'] .= <<<TPL
		<div class="row-fluid">
			<table class="table table-bordered" id="dt_gal">
				<thead>
					<tr style="text-align:center;">
						<th>№</th>
						<th>Факультет</th>
						<th>Назва предмету</th>
					</tr>
				</thead>
			<tbody>
TPL;
		while($row=mysql_fetch_array($result)){
			if($i==0){
				$surname = $row['surname'];
				$firstname = $row['firstname'];
			}
			$i = $i+1;
			
			$GLOBALS['h1'] = "Лектор: ".$surname." ".$firstname;
			$GLOBALS['content'] .= "
				<tr>
					<td>".$i."</td>
					<td>".$row['title_faculty']."</td>
					<td>".$row['title_subject']."</td>
				<tr/>";
		}
		$GLOBALS['content'] .= '</tbody></table></div>';
		$this->closeConnection($result, $con);
	}
}
?>