<?php

class Application_Form_Faculty_FacultyForm extends Zend_Form{

    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('faculties');

        $id = new Zend_Form_Element_Hidden('id');

        $title_faculty = new Zend_Form_Element_Text('title_faculty');
        $title_faculty->setLabel('Title faculty')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $id_address = new Zend_Form_Element_Text('id_address');
        $id_address->setLabel('Address')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
		
		$year_foundation = new Zend_Form_Element_Text('year_foundation');
        $year_foundation->setLabel('Year')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
		
		$decan = new Application_Model_Lector();
		$cat_decan = $decan->fetchAll();
		$id_decan = new Zend_Form_Element_Select('id_decan');
        $id_decan->setLabel('Decan');
        $id_decan->addMultiOption(0, 'Please select...');
		foreach($cat_decan as $cat1_decan){
			$id_decan->addMultiOption($cat1_decan->id, ($cat1_decan->surname).' '.($cat1_decan->firstname));
        }
   			
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $title_faculty, $id_address, $year_foundation, $id_decan, $submit));
    }
}