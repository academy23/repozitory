<?
// application/controllers/AddressController.php
 
class AddressController extends Zend_Controller_Action
{
 
    function indexAction()
    {
		$this->view->title = "Адреси";
        $addresses = new Application_Model_Address();
		
		$select = $addresses->select()
			->setIntegrityCheck(false)
			->from(
				array('a'=>'addresses'), 
				array('a.country_id', 'a.city', 'a.street', 'a.house', 'a.zip_code'))
			->joinLeft(
				array('c'=>'countries'),
				'a.country_id=c.id',
				array('country'));
	   
		$this->view->addresses = $addresses->fetchAll($select);
    }
	/*
	function addAction()
    {
         $this->view->title = "Додати країну";

        $form = new Application_Form_Country_CountryForm();
        $form->submit->setLabel('Add');
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $countries = new Application_Model_Country();
                $row = $countries->createRow();
                $row->country = $form->getValue('country');
                $row->save();

                $this->_redirect('/country');
            } else {
                $form->populate($formData);
            }
        }
    }
	
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
	
	function deleteAction()
    {
        $this->view->title = "Видалення країни";

    if ($this->_request->isPost()) {
        $id = (int)$this->_request->getPost('id');
        $del = $this->_request->getPost('del');
        if ($del == 'Yes' && $id > 0) {
            $countries = new Application_Model_Country();
            $where = 'id = ' . $id;
            $countries->delete($where);
        }
        $this->_redirect('/country');
    } else {
        $id = (int)$this->_request->getParam('id');
        if ($id > 0) {
            $countries = new Application_Model_Country();
            $this->view->country = $countries->fetchRow('id='.$id);
        }
    }
    }
*/
    
}
?>