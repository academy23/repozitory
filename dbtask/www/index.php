<?php
	include 'mysql.php';
	
	$content = '';
	$title = 'University';
	$h1 = '';
	$mesg = '';
	$chat = '';
	$admin_menu = '';
	$user_name = '';
	
	include 'fnc_system.php';
	include 'fnc_country.php';
	include 'fnc_lector.php';
	include 'fnc_faculty.php';
	include 'fnc_subject.php';
	
				
		
		if(isset($_GET['action'])){
			switch ($_GET['action']){
				//функції доступні всім працівникам 
				
				//case 'list_orders': list_orders(); break;//+
				//case 'list_form_control': list_form_control(); break;//+
				case 'listCountries': listCountries(); break;//+
				case 'addCountry': addCountry(); break;//+
				case 'addCountryDo': addCountryDo(); break;//+
				
				case 'addFaculty': addFaculty(); break;//+
				case 'addFacultyDo': addFacultyDo(); break;//+
				case 'editFaculty': editFaculty(); break;//+
				case 'editFacultyDo': editFacultyDo(); break;//+
				case 'listFaculty': listFaculty(); break;//+
				case 'subjectOfFaculty': subjectOfFaculty(); break;//+
				case 'lectorOfFaculty': lectorOfFaculty(); break;//+
				
				case 'listSubject': listSubject(); break;//+
				case 'addSubject': addSubject(); break;//+
				case 'addSubjectDo': addSubjectDo(); break;//+
				case 'deleteSubjectDo': deleteSubjectDo(); break;//+
				case 'editSubject': editSubject(); break;//+
				case 'editSubjectDo': editSubjectDo(); break;//+
				
				case 'listLector': listLector(); break;//+
				//case 'add_subject': add_subject(); break;//+
				//case 'add_subject_do': add_subject_do(); break;//+
				case 'addLector': addLector(); break;//+
				case 'addLectorDo': addLectorDo(); break;//+
				case 'editLector': editLector(); break;//+
				case 'editLectorDo': editLectorDo(); break;//+
				case 'deleteLectorDo': deleteLectorDo(); break;//+
				case 'subjectOfLector': subjectOfLector(); break;//+
				//case 'delete_subject_do': delete_subject_do(); break;//+
				//case 'edit_faculty': edit_faculty(); break;//+
				//case 'edit_faculty_do': edit_faculty_do(); break;//+
				
				default: listLector(); break;
			}
		}else{
			listLector();
		}
		
		
		include 'tpl.php'; echo $main_tpl;//вивід шаблона
	
?>