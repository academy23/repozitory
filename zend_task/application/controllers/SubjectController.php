<?
// application/controllers/SubjectController.php
 
class SubjectController extends Zend_Controller_Action
{
 
    function indexAction()
    {	
		$this->view->title = "Предмети";
        $subjects = new Application_Model_Subject();
		$select = $subjects->select()
			->setIntegrityCheck(false)
			->from(
				array('subjects'), 
				array('subjects.title_subject', 'subjects.form_control', 'subjects.id_lector', 'subjects.number_of_semestr', 'subjects.id as id_subject'))
			->joinLeft(
				array('f'=>'faculties'),
				'f.id=subjects.id_faculty',
				array('title_faculty'))
			->joinLeft(
				array('l'=>'lectors'),
				'l.id=subjects.id_lector',
				array('surname', 'firstname'));
	    $this->view->subjects = $subjects->fetchAll($select);
    }
	
	function addAction()
    {
         $this->view->title = "Додати предмет";

        $form = new Application_Form_Subject_SubjectForm();
        $form->submit->setLabel('Додати');
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $subjects = new Application_Model_Subject();
                $row = $subjects->createRow();
                $row->title_subject = $form->getValue('title_subject');
                $row->id_faculty = $form->getValue('id_faculty');
                $row->number_of_semestr = $form->getValue('number_of_semestr');
                $row->form_control = $form->getValue('form_control');
                $row->id_lector = $form->getValue('id_lector');
                $row->save();

                $this->_redirect('/subject');
            } else {
                $form->populate($formData);
            }
        }
    }
	
	function editAction(){
	
		$this->view->title = "Редагування предметів";

		$form = new Application_Form_Subject_SubjectForm();
        $form->submit->setLabel('редагувати');
        $this->view->form = $form;

        if ($this->_request->isPost()) {
		
 $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $subjects = new Application_Model_Subject();
				$id = (int)$form->getValue('id');
				$row = $subjects->fetchRow('id='.$id);
                $row->title_subject = $form->getValue('title_subject');
                $row->id_faculty = $form->getValue('id_faculty');
                $row->number_of_semestr = $form->getValue('number_of_semestr');
                $row->form_control = $form->getValue('form_control');
                $row->id_lector = $form->getValue('id_lector');
                $row->save();

				$this->_redirect('/subject');
			} else {
				$form->populate($formData);
			}
		} else {
			$id = (int)$this->_request->getParam('id', 0);
			if ($id > 0) {
				$subjects = new Application_Model_Subject();
				$subject = $subjects->fetchRow('id='.$id);
				$form->populate($subject->toArray());
			}
		}
	}
	
	function deleteAction()
    {
        $this->view->title = "Видалення предмету";

    if ($this->_request->isPost()) {
        $id = (int)$this->_request->getPost('id');
        $del = $this->_request->getPost('del');
        if ($del == 'Yes' && $id > 0) {
            $subjects = new Application_Model_Subject();
            $where = 'id = ' . $id;
            $subjects->delete($where);
        }
        $this->_redirect('/subject');
    } else {
        $id = (int)$this->_request->getParam('id');
        if ($id > 0) {
            $subjects = new Application_Model_Subject();
            $this->view->subject = $subjects->fetchRow('id='.$id);
        }
    }
    }

    
}
?>