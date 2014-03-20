<?php

class Application_Form_Subject_SubjectForm extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('subject');

        $id = new Zend_Form_Element_Hidden('id');

        $title_subject = new Zend_Form_Element_Text('title_subject');
        $title_subject->setLabel('Назва предмету')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
		
		$faculty = new Application_Model_Faculty();
		$cat_faculty = $faculty->fetchAll();
		$id_faculty = new Zend_Form_Element_Select('id_faculty');
        $id_faculty->setLabel('Faculty');
        $id_faculty->addMultiOption(0, 'Please select...');
		foreach($cat_faculty as $cat1_faculty){
			$id_faculty->addMultiOption($cat1_faculty->id, $cat1_faculty->title_faculty);
        }
		
		$number_of_semestr = new Zend_Form_Element_Text('number_of_semestr');
        $number_of_semestr->setLabel('Number')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
		
	    $form_control = new Zend_Form_Element_Select('form_control');
        $form_control->setLabel('Control');
		$form_control->addMultiOptions(array(
				'0'=>'Please select...',
				'Залік'=>'Залік',
				'Екзамен'=>'Екзамен'));
		
		$lector = new Application_Model_Lector();
		$cat = $lector->fetchAll();
        $id_lector = new Zend_Form_Element_Select('id_lector');
        $id_lector->setLabel('Lector');
		$id_lector->addMultiOption(0, 'Please select...');
		foreach($cat as $cat1){
			$id_lector->addMultiOption($cat1->id, ($cat1->surname).' '.($cat1->firstname));
        }
   			
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $title_subject, $id_faculty, $number_of_semestr, $form_control, $id_lector, $submit));
    }
}