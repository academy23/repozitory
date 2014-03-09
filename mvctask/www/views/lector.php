        <?php
		include ("models/faculty_class.php");
		include ("models/support_class.php");
		
		function addLector() {
		
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

	function editLector(){
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
?>