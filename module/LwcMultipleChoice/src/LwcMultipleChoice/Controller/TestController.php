<?php

namespace LwcMultipleChoice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use LwcMultipleChoice\Form;


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
        
        //@TODO Test Validation        
        
        $view->form = $form;        
        $view->name = $test->getName();
        $view->id = $id;
        
        return $view;
    }
}
