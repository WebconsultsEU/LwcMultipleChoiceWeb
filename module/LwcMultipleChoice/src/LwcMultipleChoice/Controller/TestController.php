<?php

namespace LwcMultipleChoice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use LwcMultipleChoice\Form;
use LwcMultipleChoice\Entity;


class TestController  extends AbstractActionController {
   
    /**            
    * @var Doctrine\ORM\EntityManager
    */                
    protected $em;

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
    
    
    public function indexAction()
    {
        throw new \Exception('This has no function yet');
        return new ViewModel();
        
    }
    /**
     * Test Action Displays the test and handles it´s results
     * 
     * @return \Zend\View\Model\ViewModel
     * @throws \Exception 
     */
    public function testAction()
    {
        $id = $this->params('id');
        $view = new ViewModel();
        
         if (!$id) {
           throw new \Exception('Test Not Found');
         }
        /**
         * @var LwcMultipleChoice\Entity\Test 
         */
         
        // This is not the optimal way for performance reasons yet there should be something like a join possible 
        $test = $this->getEntityManager()->find('LwcMultipleChoice\Entity\Test', $id);
        $formBuilder = new Form\TestFormBuilder();
        $questions = $this->getEntityManager()->getRepository('LwcMultipleChoice\Entity\Question')->findBy(array('test' => $test));        
        foreach($questions as $question) {
            //One SQL statement per request
            $answers = $this->getEntityManager()->getRepository('LwcMultipleChoice\Entity\Answer')->findBy(array('question' => $question));
            $formBuilder->addQuestion($question, $answers);
        }
        $form = $formBuilder->getBuildedForm();
        
        //process submitted form
        if($this->getRequest()->isPost()) {
        //bing post data to form 
        $form->setData($this->getRequest()->getPost());
            if($form->isValid()) {                
                $testResult = $this->processTestResult($form, $test);
                return $this->testResult($testResult);
                
            }
        }
        
        //@TODO Test Validation        
        
        $view->form = $form;        
        $view->name = $test->getName();
        $view->id = $id;
        
        return $view;
    }
    
    public function testResult($testResult)
    {
        $view = new ViewModel();
        $view->testResult = $testResult;
        $view->setTemplate('lwc-multiple-choice/test/testresult.phtml');
        return $view;
    }
    
    
    
    /**
     * This function is calculating the test result 
     */
    public function processTestResult(\Zend\Form\Form $form, $test)
    {
        $testData = $form->getData();
        $testResult = new Entity\TestResult();
        
        //this method to calculate the test results does not seem to be the best but it is working for the first try we will do performance testing later on
        $questions = $this->getEntityManager()->getRepository('LwcMultipleChoice\Entity\Question')->findBy(array('test' => $test));        
        
        $rightQuestions = array();
        foreach($questions as $question) {            
            //performance issiue as any result is fetched via question causing new sql request
            $answers = $this->getEntityManager()->getRepository('LwcMultipleChoice\Entity\Answer')->findBy(array('question' => $question));
            foreach($answers as $answer) {
            //this is the most stupid way to implement the calculation  we will learn mysql way later
                if( $testData['answers_'.$question->getId()] == $answer->getId() ) {
                    $testResult->addPointsScored($answer->getPoints());                    
                    $rightQuestions[] = $question->getId();
                } else {
                    $testResult->addPointsMissed($answer->getPoints());
                    
                }
            }
        }
        
        return $testResult;
        
        
        
    }
}
