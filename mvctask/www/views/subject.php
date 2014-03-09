        <?php
		include ("models/faculty_class.php");
		include ("models/lector_class.php");
		include ("models/support_class.php");
		
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

	function editSubject(){
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
?>