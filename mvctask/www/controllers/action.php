
<?php
if(isset($_GET['action'])){
			switch ($_GET['action']){
				//Крани
				case 'listCountries':{
					include ("models/country_class.php");
					$country = new Country();
					$country->listCountries($order); 
					break;
				}
				
				case 'addCountry':{
					include ("views/country.php");
					break;
				}
				
				case 'addCountryDo':{ 
					include ("models/country_class.php");
					$obj = new Country();
					$obj->addCountryDo();
					echo ("<script>location.href='/?action=listCountries'</script>");
					break;
				}
				
				case 'deleteCountry':{
					include ("models/country_class.php");
					$id = $_GET['id'];
					$obj = new Country();
					$obj->deleteById($id);
					echo ("<script>location.href='/?action=listCountries'</script>");
					break;
				}
				
				case 'addLector':{ 
					include ("views/lector.php");
					addLector();
					break;
				}
				
				case 'addLectorDo':{ 
					include ("models/lector_class.php");
					$obj = new Lector();
					$obj->addLectorDo();
					echo ("<script>location.href='/?action=listLectors'</script>");
					break;
				}
				
				case 'editLector':{
					include ("views/lector.php");
					editLector();
					break;
				}//+
					
				case 'editLectorDo':{
					include ("models/lector_class.php");
					$obj = new Lector();
					$obj->editLectorDo();
					echo ("<script>location.href='/?action=listLectors'</script>");
					break;
				}					
					
				
				case 'listLectors':{
					include ("models/lector_class.php");
					$lector = new Lector();
					$lector->listLectors($order);
					break;
				}
				
				case 'deleteLector':{
					include ("models/lector_class.php");
					$id = $_GET['id'];
					$obj = new Lector();
					$obj->deleteById($id);
					echo ("<script>location.href='/?action=listLectors'</script>");
					break;
				}
				
				case 'listFaculties':{
					include ("models/faculty_class.php");
					$faculty = new Faculty();
					$faculty->listFaculties($order); 
					break;
				}//+
				
				case 'addFaculty':{
					include ("views/faculty.php");
					addFaculty();
					break;
				}
				
				case 'addFacultyDo':{
					include ("models/faculty_class.php");
					$obj = new Faculty();
					$obj->addFacultyDo();
					echo ("<script>location.href='/?action=listFaculties'</script>");
					break;
				}
				
				case 'editFaculty':{
					include ("views/faculty.php");
					editFaculty();
					break;
				}
				
				case 'editFacultyDo':{
					include ("models/faculty_class.php");
					$obj = new Faculty();
					$obj->editFacultyDo();
					echo ("<script>location.href='/?action=listFaculties'</script>");
					break;
				}
				
				
				case 'addSubject':{ 
					include ("views/subject.php");
					addSubject();
					break;
				}
				
				case 'addSubjectDo':{ 
					include ("models/subject_class.php");
					$obj = new Subject();
					$obj->addSubjectDo();
					echo ("<script>location.href='/?action=listSubjects'</script>");
					break;
				}
				
				case 'editSubject':{
					include ("views/subject.php");
					editSubject();
					break;
				}//+
					
				case 'editSubjectDo':{
					include ("models/subject_class.php");
					$obj = new Subject();
					$obj->editSubjectDo();
					echo ("<script>location.href='/?action=listSubjects'</script>");
					break;
				}					
					
				
				case 'listSubjects':{
					include ("models/subject_class.php");
					$lector = new Subject();
					$lector->listSubjects($order);
					break;
				}
				
				case 'deleteSubject':{
					include ("models/subject_class.php");
					$id = $_GET['id'];
					$obj = new Subject();
					$obj->deleteById($id);
					echo ("<script>location.href='/?action=listSubjects'</script>");
					break;
				}
				
				case 'search':{
					include ("views/faculty.php");
					$obj = new Faculty();
					$obj->search();
					break;
				}
				
				case 'searchDo':{
					include ("models/faculty_class.php");
					$obj = new Faculty();
					$obj->searchDo();
					break;
				}
				
				case 'subjectOfLector':{
					include ("models/lector_class.php");
					$lector = new Lector;
					$lector->subjectOfLector();
					break;
				}
				
				case 'subjectOfFaculty':{
					include ("models/faculty_class.php");
					$faculty = new Faculty;
					$faculty->subjectOfFaculty();
					break;
				}
				
				case 'lectorOfFaculty':{
					include ("models/faculty_class.php");
					$faculty = new Faculty;
					$faculty->lectorOfFaculty();
					break;
				}
				
				default: 
					include ("models/country_class.php");
					$country = new Country();
					$country->listCountries($order); 
					break; 
			}
		}else{
			include ("models/country_class.php");
			$country = new Country();
			$country->listCountries($order); 
		}
?>