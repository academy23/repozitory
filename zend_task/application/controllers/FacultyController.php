<?
// application/controllers/FacultyController.php
 
class FacultyController extends Zend_Controller_Action{
 
    function indexAction(){
	
		$this->view->title = "Факультети";
        $faculties = new Application_Model_Faculty();
		
		$select = $faculties->select()
			->setIntegrityCheck(false)
			->from(
				array('faculties'), 
				array('faculties.id', 'faculties.id_address', 'faculties.title_faculty', 'faculties.year_foundation', 'faculties.id_decan'))
			->joinLeft(
				array('l'=>'lectors'),
				'l.id=faculties.id_decan',
				array('surname', 'firstname'))
			->joinLeft(
				array('a'=>'addresses'),
				'faculties.id_address=a.id',
				array('city', 'street', 'house', 'zip_code'))
			->joinLeft(
				array('c'=>'countries'),
				'a.country_id=c.id',
				array('country'));
	    $this->view->faculties = $faculties->fetchAll($select);
    }
	
	function addAction(){
	
         $this->view->title = "Додати факультет";

        $form = new Application_Form_Faculty_FacultyForm();
        $form->submit->setLabel('Add');
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $faculties = new Application_Model_Faculty();
                $row = $faculties->createRow();
                $row->title_faculty = $form->getValue('title_faculty');
                $row->id_address = $form->getValue('id_address');
                $row->year_foundation = $form->getValue('year_foundation');
                $row->id_decan = $form->getValue('id_decan');
                $row->save();

                $this->_redirect('/faculty');
            } else {
                $form->populate($formData);
            }
        }
    }
	
	
	function editAction(){
        
		$this->view->title = "Редагування факультету";

		$form = new Application_Form_Faculty_FacultyForm();
		$form->submit->setLabel('Save');
		$this->view->form = $form;

		if ($this->_request->isPost()) {
			$formData = $this->_request->getPost();
			if ($form->isValid($formData)) {
				$faculties = new Application_Model_Faculty();
				$id = (int)$form->getValue('id');
				$row = $faculties->fetchRow('id='.$id);
				$row->title_faculty = $form->getValue('title_faculty');
                $row->id_address = $form->getValue('id_address');
                $row->year_foundation = $form->getValue('year_foundation');
                $row->id_decan = $form->getValue('id_decan');
				$row->save();

				$this->_redirect('/faculty');
			} else {
				$form->populate($formData);
			}
		} else {
			$id = (int)$this->_request->getParam('id', 0);
			if ($id > 0) {
				$faculties = new Application_Model_Faculty();
				$faculty = $faculties->fetchRow('id='.$id);
				$form->populate($faculty->toArray());
			}
		}
    }
	
}
?>