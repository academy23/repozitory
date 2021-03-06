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
	include("../models/subject_class.php");
	include("../models/support_class.php");
	include_once("../models/db_class.php");
	include_once("../models/interface.php");
	
	
				
		
		if(isset($_GET['action'])){
			switch ($_GET['action']){
				case 'listCountries':{
					$country = new Country();
					$country->listCountries($order); 
					break;
				}
				
				case 'addCountry':{ 
					$obj = new Country();
					$obj->addCountry();
					break;
				}
				
				case 'addCountryDo':{ 
					$obj = new Country();
					$obj->addCountryDo();
					header('Location: /?action=listCountries', true, 303);
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
					$obj = new Lector();
					$obj->addLector();
					break;
				}
				
				case 'addLectorDo':{ 
					$obj = new Lector();
					$obj->addLectorDo();
					header('Location: /?action=listLectors', true, 303);
					break;
				}
				
				case 'editLector':{ 
					$obj = new Lector();
					$obj->editLector();
					break;
				}//+
					
				case 'editLectorDo':{
					$obj = new Lector();
					$obj->editLectorDo();
					header('Location: /?action=listLectors', true, 303);
					break;
				}					
					
				
				case 'listLectors':{
					$lector = new Lector();
					$lector->listLectors($order);
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
					$faculty->listFaculties($order); 
					break;
				}//+
				
				case 'addFaculty':{
					$faculty = new Faculty();
					$faculty->addFaculty();
					break;
				}
				
				case 'addFacultyDo':{
					$obj = new Faculty();
					$obj->addFacultyDo();
					header('Location: /?action=listFaculties', true, 303);
					break;
				}
				
				case 'editFaculty':{
					$faculty = new Faculty();
					$faculty->editFaculty();
					break;
				}
				
				case 'editFacultyDo':{
					$obj = new Faculty();
					$obj->editFacultyDo();
					header('Location: /?action=listFaculties', true, 303);
					break;
				}
				
				
				case 'addSubject':{ 
					$obj = new Subject();
					$obj->addSubject();
					break;
				}
				
				case 'addSubjectDo':{ 
					$obj = new Subject();
					$obj->addSubjectDo();
					header('Location: /?action=listSubjects', true, 303);
					break;
				}
				
				case 'editSubject':{ 
					$obj = new Subject();
					$obj->editSubject();
					break;
				}//+
					
				case 'editSubjectDo':{
					$obj = new Subject();
					$obj->editSubjectDo();
					header('Location: /?action=listSubjects', true, 303);
					break;
				}					
					
				
				case 'listSubjects':{
					$lector = new Subject();
					$lector->listSubjects($order);
					break;
				}
				
				case 'deleteSubject':{
					$id = $_GET['id'];
					$obj = new Subject();
					$obj->deleteById($id);
					header('Location: /?action=listSubjects', true, 303);
					break;
				}
				
				case 'search':{
					$obj = new Faculty();
					$obj->search();
					break;
				}
				
				case 'searchDo':{
					$obj = new Faculty();
					$obj->searchDo();
					break;
				}
				
				case 'subjectOfLector':{
					$lector = new Lector;
					$lector->subjectOfLector();
					break;
				}
				
				case 'subjectOfFaculty':{
					$faculty = new Faculty;
					$faculty->subjectOfFaculty();
					break;
				}
				
				case 'lectorOfFaculty':{
					$faculty = new Faculty;
					$faculty->lectorOfFaculty();
					break;
				}
				
				default: 
					$country = new Country();
					$country->listCountries($order); 
					break; 
			}
		}else{
			$country = new Country();
			$country->listCountries($order); 
		}
		
		
		include 'tpl.php'; echo $main_tpl;//вивід шаблона
	
?>