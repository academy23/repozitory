<?
// application/controllers/LectorController.php
 
class LectorController extends Zend_Controller_Action
{
 
    function indexAction()
    {
		$this->view->title = "Лектори";
        $lectors = new Application_Model_Lector();
		
		$select = $lectors->select()
			->setIntegrityCheck(false)
			->from(
				array('lectors'), 
				array('lectors.id', 'lectors.surname', 'lectors.firstname', 'lectors.date_of_birth', 'lectors.degree', 'lectors.post', 'lectors.id_faculty_work'))
			->joinLeft(
				array('f'=>'faculties'),
				'f.id=lectors.id_faculty_work',
				array('title_faculty'));
	    $this->view->lectors = $lectors->fetchAll($select);
    }
	
	function addAction()
    {
         $this->view->title = "Додати лектора";

        $form = new Application_Form_Lector_LectorForm();
        $form->submit->setLabel('Add');
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $lectors = new Application_Model_Lector();
                $row = $lectors->createRow();
                $row->surname = $form->getValue('surname');
                $row->firstname = $form->getValue('firstname');
                $row->date_of_birth = $form->getValue('date_of_birth');
                $row->degree = $form->getValue('degree');
                $row->post = $form->getValue('post');
                $row->id_faculty_work = $form->getValue('id_faculty_work');
                $row->save();

                $this->_redirect('/lector');
            } else {
                $form->populate($formData);
            }
        }
    }
	/*
	function editAction()
    {
        $this->view->title = "Редагування країн";

    $form = new Application_Form_Country_CountryForm();
    $form->submit->setLabel('Save');
    $this->view->form = $form;

    if ($this->_request->isPost()) {
        $formData = $this->_request->getPost();
        if ($form->isValid($formData)) {
            $countries = new Application_Model_Country();
            $id = (int)$form->getValue('id');
            $row = $countries->fetchRow('id='.$id);
            $row->country = $form->getValue('country');
            $row->save();

            $this->_redirect('/country');
        } else {
            $form->populate($formData);
        }
    } else {
        $id = (int)$this->_request->getParam('id', 0);
        if ($id > 0) {
            $countries = new Application_Model_Country();
            $country = $countries->fetchRow('id='.$id);
            $form->populate($country->toArray());
        }
    }
    }
	*/
	function deleteAction()
    {
        $this->view->title = "Видалення лектора";

    if ($this->_request->isPost()) {
        $id = (int)$this->_request->getPost('id');
        $del = $this->_request->getPost('del');
        if ($del == 'Yes' && $id > 0) {
            $lectors = new Application_Model_Lector();
            $where = 'id = ' . $id;
            $lectors->delete($where);
        }
        $this->_redirect('/lector');
    } else {
        $id = (int)$this->_request->getParam('id');
        if ($id > 0) {
            $lectors = new Application_Model_Lector();
            $this->view->lector = $lectors->fetchRow('id='.$id);
        }
    }
  
  }
    
}
?>