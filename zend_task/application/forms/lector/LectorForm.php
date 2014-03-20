<?php

class Application_Form_Lector_LectorForm extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('lectors');

        $id = new Zend_Form_Element_Hidden('id');

        $surname = new Zend_Form_Element_Text('surname');
        $surname->setLabel('Surname')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $firstname = new Zend_Form_Element_Text('firstname');
        $firstname->setLabel('Firstname')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
		
		$date_of_birth = new Zend_Form_Element_Text('date_of_birth');
        $date_of_birth->setLabel('Date')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
		
		$degree = new Zend_Form_Element_Select('degree');
        $degree->setLabel('Degree');
		$degree->addMultiOptions(array(
				'0'=>'Please select...',
				'Кандидат наук'=>'Кандидат наук',
				'Доктор наук'=>'Доктор наук'));

		$post = new Zend_Form_Element_Select('post');
        $post->setLabel('Post');
		$post->addMultiOptions(array(
				'0'=>'Please select...',
				'Асистент'=>'Асистент',
				'Викладач'=>'Викладач',
				'Доцент'=>'Доцент',
				'Професор'=>'Професор'));
		
				
		$faculty = new Application_Model_Faculty();
		$cat_faculty = $faculty->fetchAll();
		$id_faculty = new Zend_Form_Element_Select('id_faculty_work');
        $id_faculty->setLabel('Faculty');
        $id_faculty->addMultiOption(0, 'Please select...');
		foreach($cat_faculty as $cat1_faculty){
			$id_faculty->addMultiOption($cat1_faculty->id, $cat1_faculty->title_faculty);
        }
   			
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $surname, $firstname, $date_of_birth, $degree, $post, $id_faculty, $submit));
    }
}