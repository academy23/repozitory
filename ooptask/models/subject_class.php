<?php
include_once("db_class.php");

class Subject extends Database{
	private $id;
	private $title_subject;
	private $id_faculty;
	private $number_of_semestr;
	private $form_control;
	private $id_lector;
	
	const UNKNOWN_STR = "Unknown";
	const UNKNOWN_INT = 0;

	function __construct() {
		$this->title_subject = self::UNKNOWN_STR;
		$this->id_faculty = self::UNKNOWN_INT;
		$this->number_of_semestr = self::UNKNOWN_INT;
		$this->form_control = self::UNKNOWN_STR;
		$this->id_lector = self::UNKNOWN_INT;
	}

	public function getId() {
		return $this->id;
	}
	
	public function setId($value) {
		$this->id = $value;
	}
	
	public function getTitleSubject() {
		return $this->title_subject;
	}
	
	public function setTitleSubject($value) {
		$this->title_subject = $value;
	}
	
	public function getIdFaculty() {
		return $this->id_faculty;
	}
	
	public function setIdFaculty($value) {
		$this->id_faculty = $value;
	}
	
	public function getNumberOfSemestr() {
		return $this->number_of_semestr;
	}
	
	public function setNumberOfSemestr($value) {
		$this->number_of_semestr = $value;
	}

	public function getFormControl() {
		return $this->form_control;
	}

	public function setFormControl($value) {
		$this->form_control = $value;
	}
	
		public function getIdLector() {
		return $this->id_lector;
	}

	public function setIdLector($value) {
		$this->id_lector = $value;
	}
	
	public function listSubjects($order = null) {
		$con = $this->getConnector();
		
		if(isset($_GET['filter'])){
			switch ($_GET['filter']){
				case 'search':
					$filter = "WHERE title_subject LIKE '%{$_GET['query']}%'";
					break;
				default: $filter = '';
					break;
			}
		}else{
			$filter = "";
		}
		
		$GLOBALS['h1'] = "Предмети";
		$GLOBALS['content'] = '';
		$GLOBALS['content'] .= <<<TPL
		<div class="row-fluid"><a href="/?action=addSubject" class="btn btn-info right">Добавити предмет</a></div>
		<div class="row-fluid">
			<table class="table table-bordered" id="dt_gal">
				<thead>
					<tr style="text-align:center;">
						<th>№</th>
						<th>Назва предмету</th>
						<th>Факультет</th>
						<th>Номер семестру</th>
						<th>Форма контролю</th>
						<th>Лектор</th>
						<th></th>
					</tr>
				</thead>
			<tbody>
TPL;
		$sqlQuery="SELECT 
					subjects.id as id_subject,
					subjects.title_subject,
					subjects.id_faculty,
					subjects.number_of_semestr,
					subjects.form_control,
					subjects.id_lector,
					faculties.id,
					faculties.title_faculty,
					lectors.id,
					lectors.firstname,
					lectors.surname
				FROM 
					subjects
				LEFT JOIN faculties ON subjects.id_faculty=faculties.id
				LEFT JOIN lectors ON subjects.id_lector=lectors.id
				{$filter}";
					
		$result = $this->getQueryResult($con, $sqlQuery);
		$i = 0;
		while($row=mysql_fetch_array($result)){
			if($row['form_control']==1){
				$form_control = 'Залік';
			}else{
				$form_control = 'Екзамен';
			}
			$i = $i+1;
			$GLOBALS['content'] .= "
				<tr>
					<td>".$i."</td>
					<td>".$row['title_subject']."</td>
					<td>".$row['title_faculty']."</td>
					<td>".$row['number_of_semestr']."</td>
					<td>".$form_control."</td>
					<td>".$row['surname']." ".$row['firstname']."</td>
					<td><a title='Змінити' href='/?action=editSubject&id=".$row['id_subject']."'><i class='icon-pencil'></i></a><a title='Видалити' class='confirm del' href='/?action=deleteSubject&id=".$row['id_subject']."'><i class='icon-trash'></i></a></td>
				<tr/>";
		}
		$GLOBALS['content'] .= '</tbody></table></div>';
		$this->closeConnection($result, $con);
	}
	
	function addSubject(){
		$faculty = Faculty::getList();
		$lector = Lector::getList();
		
		$GLOBALS['h1'] = "Додавання нового предмету";
		$GLOBALS['content'] = <<<HTML
		<div class="row-fluid">
			<div class="span6">
				<form class="well form-inline" method="POST" action="/?action=addSubjectDo">
					<div class="row-fluid">
						<label>Назва предмету</label>
						<input type="text" name="title_subject" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						<label>Факультет</label>
						<select name="id_faculty" class="span12">
							{$faculty}
						</select>
					</div>
					<div class="row-fluid">
						<label>Номер семестру</label>
						<input type="text" name="number_of_semestr" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						<label>Форма контролю</label>
						<select name="form_control" class="span12">
							<option value="1">Залік</option>
							<option value="2">Екзамен</option>
						</select>
					</div>
					<div class="row-fluid">
						<label>Лектор</label>
						<select name="id_lector" class="span12">
							{$lector}
						</select>
					</div>
					<div class="row-fluid">
						<button type="submit" class="btn">Додати</button>
					</div>
				</form>
			</div>
		</div>
HTML;
	}
	
	function addSubjectDo(){//додавання країни
		$con = $this->getConnector();
		$this->title_subject = $_POST['title_subject'];
		$this->id_faculty = $_POST['id_faculty'];
		$this->number_of_semestr = $_POST['number_of_semestr'];
		$this->form_control = $_POST['form_control'];
		$this->id_lector = $_POST['id_lector'];
		
		$sqlQuery = 'INSERT INTO subjects (title_subject, id_faculty, number_of_semestr, form_control, id_lector) 
			VALUES ("'.$this->title_subject.'", "'.$this->id_faculty.'", "'.$this->number_of_semestr.'", "'.$this->form_control.'", "'.$this->id_lector.'")';
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}
	
	public function editSubject(){
		$id = $_GET['id'];
		
		$faculty = Faculty::getList();
		$lector = Lector::getList();
			
		$db = new Database();
		$con = $db->getConnector();
		$sqlQuery="SELECT * FROM subjects WHERE id = {$id}";
		$res = $db->getQueryResult($con, $sqlQuery);
		$row = mysql_fetch_array($res,MYSQL_ASSOC);
			
		$text_form_control = '<option value="1">Залік</option><option value="2">Екзамен</option>';		
		$var = 'value="'.$row['form_control'].'"';
		$chose_form_control = Support::getSelect($text_form_control,$var);
		
		if($row['id_lector']!=0){
		$var_lector = 'value="'.$row['id_lector'].'"';
		$chose_lector = Support::getSelect($lector, $var_lector);
		}else{
			$chose_lector = $lector;
		}
		
		if($row['id_faculty']!=0){
		$var_faculty = 'value="'.$row['id_faculty'].'"';
		$chose_faculty = Support::getSelect($faculty, $var_faculty);
		}else{
			$chose_faculty = $faculty;
		}
		$GLOBALS['h1'] = "Редагування предмету";
		$GLOBALS['content'] = <<<HTML
		<div class="row-fluid">
			<div class="span6">
				<form class="well form-inline" method="POST" action="/?action=editSubjectDo">
					<div class="row-fluid">
						<label>Назва предмету</label>
						<input type="text" name="title_subject" class="span12" value="{$row['title_subject']}"/>
					</div>
					<div class="row-fluid">
						<label>Факультет</label>
						<select name="id_faculty" class="span12">
							{$chose_faculty}
						</select>
					</div>
					<div class="row-fluid">
						<label>Номер семестру</label>
						<input type="text" name="number_of_semestr" class="span12" value="{$row['number_of_semestr']}"/>
					</div>
					<div class="row-fluid">
						<label>Форма контролю</label>
						<select name="form_control" class="span12">
							{$chose_form_control}
						</select>
					</div>
					<div class="row-fluid">
						<label>Лектор</label>
						<select name="id_lector" class="span12">
							{$chose_lector}
						</select>
					</div>
					<div class="row-fluid">
						<button type="submit" class="btn">Змінити</button>
						<input type="hidden" name="id" value="{$id}"/>
					</div>
				</form>
			</div>
		</div>
HTML;
		}
		
	function editSubjectDo(){
		$con = $this->getConnector();
		$sqlQuery = 'UPDATE subjects SET title_subject = "'.$_POST["title_subject"].'", id_faculty = "'.$_POST["id_faculty"].'", number_of_semestr = "'.$_POST["number_of_semestr"].'", form_control = "'.$_POST["form_control"].'", id_lector = "'.$_POST["id_lector"].'" WHERE id = "'.$_POST['id'].'"';
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
	}

	public function deleteById($index) {
		$con = $this->getConnector();
		$sqlQuery = "DELETE FROM subjects WHERE id=".intval($index)." LIMIT 1";
		$this->getQueryResult($con, $sqlQuery);
		mysql_close($con);
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