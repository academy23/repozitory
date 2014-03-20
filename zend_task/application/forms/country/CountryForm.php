<?php

class Application_Form_Country_CountryForm extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('country');

        $id = new Zend_Form_Element_Hidden('id');

        $country = new Zend_Form_Element_Text('country');
        $country->setLabel('Country')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $country, $submit));
    }
}