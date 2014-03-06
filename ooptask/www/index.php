<?php
	include_once("../models/db_class.php");
	include_once("../models/interface.php");
	
	$content = '';
	$title = 'University';
	$h1 = '';
	$mesg = '';
	$chat = '';
	$admin_menu = '';
	$user_name = '';
	
	//include 'fnc_system.php';
	
	//include 'fnc_lector.php';
	//include 'fnc_faculty.php';
	//include 'fnc_subject.php';
	//include 'search.php';
	include("../models/country_class.php");
	include("../models/address_class.php");
	include("../models/lector_class.php");
	include("../models/faculty_class.php");
	include("../models/support_class.php");
	include_once("../models/db_class.php");
	include_once("../models/interface.php");
	
	
				
		
		if(isset($_GET['action'])){
			switch ($_GET['action']){
				case 'listCountries':{
					$country = new Country();
					$country->select($order); 
					break;
				}//+
				
				case 'addCountry':{ 
					$GLOBALS['h1'] = "Додавання нової країни";
					$GLOBALS['content'] = <<<HTML
						<div class="row-fluid">
							<div class="span6">
								<form class="well form-inline" method="POST">
									<div class="row-fluid">
										<label>Назва країни</label>
										<input type="text" name="country" class="span12" value=""/>
									</div>
									<div class="row-fluid">
										<button type="submit" name="submitCountry" class="btn">Додати</button>
									</div>
								</form>
							</div>
						</div>
HTML;
						if(isset($_REQUEST['submitCountry'])){
							$country['country'] = $_POST['country'];									
							$obj = new Country();
							$obj->insertValue($country);					
							header('Location: /?action=listCountries', true, 303);
						}
						break;
				}
				
				case 'deleteCountry':{
					$id = $_GET['id'];
					$obj = new Country();
					$obj->deleteById($id);
					header('Location: /?action=listCountries', true, 303);
					break;
				}
				
				case 'addLector':{ 
					$GLOBALS['h1'] = "Додавання нового лектора";
					$faculty_work = Faculty::getList();
					
					$GLOBALS['content'] = <<<HTML
					<div class="row-fluid">
						<div class="span6">
							<form class="well form-inline" method="POST">
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
						if(isset($_REQUEST['submitLector'])){
							$lector['surname'] = $_POST['surname'];
							$lector['firstname'] = $_POST['firstname'];
							$array_date = explode('.', $_POST['date_of_birth']);
							$lector['date_of_birth'] = strtotime($array_date['0'].".".$array_date['1'].".".$array_date['2']);
							$lector['degree'] = $_POST['degree'];
							$lector['post'] = $_POST['post'];
							$lector['id_faculty'] = $_POST['id_faculty'];								
							$obj = new Lector();
							$obj->insertValue($lector);
							header('Location: /?action=listLectors', true, 303);
						}
						break;
				}
				
				case 'editLector':{ 
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
							<form class="well form-inline" method="POST">
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
					if(isset($_REQUEST['submitLector'])){
							$id = $_POST['id'];
							$lector['surname'] = $_POST['surname'];
							$lector['firstname'] = $_POST['firstname'];
							$array_date = explode('.', $_POST['date_of_birth']);
							$lector['date_of_birth'] = strtotime($array_date['0'].".".$array_date['1'].".".$array_date['2']);
							$lector['degree'] = $_POST['degree'];
							$lector['post'] = $_POST['post'];
							$lector['id_faculty_work'] = $_POST['id_faculty'];								
							$obj = new Lector();
							$obj->updateValue($id, $lector);
							header('Location: /?action=listLectors', true, 303);
					}
					$db->closeConnection($res, $con);
					break;
				
				}//+
				
				case 'listLectors':{
					$lector = new Lector();
					$lector->select($order);
					break;
				}
				
				case 'deleteLector':{
					$id = $_GET['id'];
					$obj = new Lector();
					$obj->deleteById($id);
					header('Location: /?action=listLectors', true, 303);
					break;
				}
				
				case 'listFaculties':{
					$faculty = new Faculty();
					$faculty->select($order); 
					break;
				}//+
				
				case 'addFaculty':{
					$list_country = Country::getList();
					$GLOBALS['h1'] = "Додавання нового факультету";
					$GLOBALS['content'] = <<<HTML
					<div class="row-fluid">
						<div class="span6">
							<form class="well form-inline" method="POST">
								<div class="row-fluid">
									<label>Назва факультету</label>
									<input type="text" name="faculty" class="span12" value=""/>
								</div>
								<div class="row-fluid">
									Якщо немає потрібної країни, просто додайте її при редагуванні<br/>
									<label>Країна</label>
									<select name="country" class="span12">
										{$list_country}
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
									<button type="submit" name="submitFaculty" class="btn">Додати</button>
								</div>
							</form>
						</div>
					</div>
HTML;

					if(isset($_REQUEST['submitFaculty'])){
							
							$faculty['title_faculty'] = $_POST['faculty'];
							$faculty['year_foundation'] = $_POST['year_foundation'];
							$faculty['id_decan'] = '0';
							$address['country'] = $_POST['country'];
							$address['city'] = $_POST['city'];
							$address['street'] = $_POST['street'];
							$address['house'] = $_POST['house'];
							$address['zip_code'] = $_POST['zip_code'];
							$obj_address = new Address();
							$obj_address->insertValue($address);
							
							$db = new Database();
							$con = $db->getConnector();
							$sqlQuery="SELECT max(id) as max_id FROM addresses";
							$res = $db->getQueryResult($con, $sqlQuery);
							$row = mysql_fetch_array($res,MYSQL_ASSOC);
							$faculty['id_address'] = $row['max_id'];
							$db->closeConnection($res, $con);
							$obj = new Faculty();
							$obj->insertValue($faculty);
							header('Location: /?action=listFaculties', true, 303);
						
						}
					break;
	
				}
				
				default: 
					$country = new Country();
					$country->select($order); 
					break; 
			}
		}else{
			$country = new Country();
			$country->select($order); 
		}
		
		
		include 'tpl.php'; echo $main_tpl;//вивід шаблона
	
?>