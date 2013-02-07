<?php


namespace LwcMultipleChoice\Form;


use Zend\Form\Element;

use Zend\Form\Form;
use LwcMultipleChoice\Entity\Question;
use LwcMultipleChoice\Entity\Answer;

/**
 * Building the form,
 * not fully satisfied with it yet.  
 */

class TestFormBuilder {
    /**
     *
     * @var Zend\Form\Form
     */
    private $form;
    
    
    
    public function __construct() {
        $this->form = new Form();
    }
    /**
     *
     * @return Zend\Form\Form
     */
    private function getForm(){
        return $this->form; 
    }
    
    /**
     * Add question and possible answers to a form
     * Currently all Questions are displayed as Radio Buttons and there is only one choice possible per Question
     * 
     * @param Question $question
     * @param Answer[] $answers 
     */
    public function addQuestion(Question $question, $answers) {
        
        $radio = new Element\Radio('answers_'.$question->getId());
        $radio->setLabel($question->getQuestion());        
        $valueOptions = array();
        foreach($answers as $answer) {
            
            $valueOptions[$answer->getId()] = $answer->getAnswer();
        }        
        $radio->setValueOptions($valueOptions);        
        $this->getForm()->add($radio);
    }
    /**
     * Returning the Builded Form 
     * 
     * @return type 
     */
    public function getBuildedForm()
    {
        $submit = new Element\Submit('submit');        
        $submit->setAttribute('class', 'btn btn-primary')
               ->setValue('Test Abschicken');
        
        $this->getForm()->add($submit);
        return $this->getForm();
    }
    
    
}
