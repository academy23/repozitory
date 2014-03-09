        <?php
		include ("models/country_class.php");
		include ("models/support_class.php");
		
	function addFaculty(){
		$countries = Country::getList();
	
		$GLOBALS['h1'] = "Додавання нового факультету";
		$GLOBALS['content'] = <<<HTML
		<div class="row-fluid">
			<div class="span6">
				<form class="well form-inline" method="POST" action="/?action=addFacultyDo">
					<div class="row-fluid">
						<label>Назва факультету</label>
						<input type="text" name="faculty" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						Якщо немає потрібної країни, просто додайте її при редагуванні<br/>
						<label>Країна</label>
						<select name="country" class="span12">
							{$countries}
						</select>
					</div>
					<div class="row-fluid">
						<label>Місто</label>
						<input type="text" name="city" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						<label>Вулиця</label>
						<input type="text" name="street" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						<label>Будинок</label>
						<input type="text" name="house" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						<label>Поштовий індекс</label>
						<input type="text" name="zip_code" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						<label>Рік заснування</label>
						<input type="text" name="year_foundation" class="span12" value=""/>
					</div>
					<div class="row-fluid">
						<button type="submit" class="btn">Додати</button>
					</div>
				</form>
			</div>
		</div>
HTML;
	}

	function editFaculty() {
		$db = new Database();
		$con = $db->getConnector();
		
		$decan = '<option value=""></option>';
		$query_decan="SELECT * FROM lectors WHERE id_faculty_work = '{$_GET['id']}'";
		$res_decan = $db->getQueryResult($con, $query_decan);
		while($row_decan=mysql_fetch_array($res_decan,MYSQL_ASSOC)){
			$decan .= "<option value=".$row_decan['id'].">".$row_decan['surname']." ".$row_decan['firstname']."</option>";
		}
		
		$query="SELECT * FROM faculties WHERE id = '{$_GET['id']}'";
		$res=$db->getQueryResult($con,$query);
		$row=mysql_fetch_array($res);
		$id = $row['id'];
		$title_faculty = $row['title_faculty'];
		$year_of_foundation = $row['year_foundation'];
		$id_decan = $row['id_decan'];
		
		$GLOBALS['h1'] = "Редагування факультета {$row['title_faculty']}";
		$GLOBALS['content'] = <<<HTML
		<div class="row-fluid">
			<div class="span6">
				<form class="well form-inline" method="POST" action="/?action=editFacultyDo">
						<div class="row-fluid">
						<label>Назва факультету</label>
						<input type="text" name="faculty" class="span12" value="{$title_faculty}"/>
					</div>
					<div class="row-fluid">
						<label>Рік заснування</label>
						<input type="text" name="year_foundation" class="span12" value="{$year_of_foundation}"/>
					</div>
					<div class="row-fluid">
						<label>Декан</label>
						<select name="decan" class="span12">
							{$decan}
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
		$db->closeConnection($res, $con);
	}
?>