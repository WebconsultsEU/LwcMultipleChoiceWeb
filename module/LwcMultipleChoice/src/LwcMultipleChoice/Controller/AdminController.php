<?php

namespace LwcMultipleChoice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use LwcMultipleChoice\Form;
use Doctrine\ORM\EntityManager;

use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;



class AdminController  extends AbstractActionController
{
   
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
    
    public function getFormBuilder()
    {
        
    }
    
    
    public function indexAction()
    {
        $view = new ViewModel();
        
        $tests = $this->getEntityManager()->getRepository('LwcMultipleChoice\Entity\Test')->findAll();
        
        $view->tests = $tests;
        
        return $view;
        
    }
    
    /**
     *  Edit the basic test entity 
     */
    public function listquestionsAction()
    {
         $id = $this->params('id');
         if ($id) {
            $test = $this->getEntityManager()->find('LwcMultipleChoice\Entity\Test', $id);
         } else {
            throw new \Exceptioon('no id given');
         }
        
        $questions = $this->getEntityManager()->getRepository('LwcMultipleChoice\Entity\Question')
                ->findBy(array('test' => $test));
        $answers = array();
        foreach ($questions as $question) {
        //bad bad bad performance lack but welcome to doctrine no time to figure out that join yet
            $answers[$question->getId()] = $this->getEntityManager()->getRepository('LwcMultipleChoice\Entity\Answer')
                    ->findBy(array('question' => $question)); 
        }
                
        $view =  new ViewModel();
        $view->test = $test;
        $view->questions = $questions;
        $view->answers = $answers;
        
        
        return $view;

    }
    
    /**
     *  Edit the basic test entity 
     *  this could be done by the new editEntity Function but left for historical reasons;
     */
    public function edittestAction()
    {        
        $entityManager = $this->getEntityManager();        
        $testId = $this->params('id');
        $new = $this->getRequest()->getQuery()->get('new', null);
        
        if ($testId) {
            $test = $this->getEntityManager()->find('LwcMultipleChoice\Entity\Test', $testId);
        } elseif ($new) {
            $test = new \LwcMultipleChoice\Entity\Test();            
        } else {
            throw new Exception('no test given.');
        }
         
        //Doctrine form Builder supports building forms by annotations from doctrine entitys
        $builder = new \DoctrineORMModule\Form\Annotation\AnnotationBuilder($entityManager);        
        //Create a form for the Test-Annotation Object
        $form = $builder->createForm($test);
        //create a DoctrineEntity Hydrator for the Form Annotation
        $hydrator = new  \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity(
            $entityManager, 
            'LwcMultipleChoice\Entity\Test'
        );
        $form->setHydrator($hydrator);
        $form->bind($test);
        //prevent re-binding of data values before validate
        $form->setBindOnValidate(false);

        
        //Add submit form
        //if you have more default forms it might be useful to create a fieldset with default forms 
        $submit = new \Zend\Form\Element\Submit('submit');        
        $submit->setAttribute('class', 'btn btn-primary')
               ->setValue('Bearbeiten');                       
        $form->add($submit);
        
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                //bind post values to form
                $form->bindValues();                 
                //retrieve the test object with changed date from form using previously defined DoctrineEntity Hydrator
                $test = $form->getData();
                //persist test entity using doctrine
                $this->getEntityManager()->persist($test);
                //well i do not know what flush is doing yet
                $this->getEntityManager()->flush();
            } else {
                //an invalid form has been submitted
                throw new Exception('Invalid Form submitted');
            }
            
        }
        $view =  new ViewModel();
        $view->form = $form;
        $view->test = $test;
        
        return $view;
    }
    
    /**
     * Will process all things needed to edit an entity 
     * this is the first step of our evolution we will sort it out to a service later
     * 
     * @param String $entityClass the entity class as string
     * @return array form and entity
     * @throws Exception 
     */
    public function processEntityEdit($entityClass, $entity)
    {        
        $entityManager = $this->getEntityManager();
         
        //Doctrine form Builder supports building forms by annotations from doctrine entitys
        $builder = new \DoctrineORMModule\Form\Annotation\AnnotationBuilder($entityManager);
        
        //Create a form for the Test-Annotation Object
        $form = $builder->createForm($entity);
        //create a DoctrineEntity Hydrator for the Form Annotation
        $hydrator = new  \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($entityManager, $entityClass);
        $form->setHydrator($hydrator);
        $form->bind($entity);
        //prevent re-binding of data values before validate
        $form->setBindOnValidate(false);

        
        //Add submit form
        //if you have more default forms it might be useful to create a fieldset with default forms 
        $submit = new \Zend\Form\Element\Submit('submit');        
        $submit->setAttribute('class', 'btn btn-primary')
               ->setValue('Save');                       
        $form->add($submit);
        
        if ($this->getRequest()->isPost()) {
            
            $form->setData($this->getRequest()->getPost());
            
            if ($form->isValid()) {
                //bind post values to form
                $form->bindValues();                 
                //retrieve the test object with changed date from form using previously defined DoctrineEntity Hydrator
                $entity = $form->getData();
                //persist test entity using doctrine
                $this->getEntityManager()->persist($entity);
                //well i do not know what flush is doing yet
                $this->getEntityManager()->flush();
                
                return array('entity' => $entity,
                             'form' => $form,
                             'status' => 'saved') ;        
            } else {
                //an invalid form has been submitted
                throw new Exception('Invalid Form submitted');
            }            
        }
         // i am not satisfied with this yet maybe turn it to a result object later
         return array('entity' => $entity,
                      'form' => $form,                      
                      'status' => 'edit'
                     );
        
    }
    
    
    /**
     * Edit the basic answer entity 
     * 
     * Taking usage of the save Entity answer
     * 
     */
    public function editanswerAction()
    {
        
        $new = $this->getRequest()->getQuery()->get('new', null);
        $entity = null;
        //process new questions 
        if ($new) {
            $questionId = $this->getRequest()->getQuery()->get('questionId', null);
            if (!$questionId) {
                throw new \Exception('no questionId given');
            }            
            $entity = new \LwcMultipleChoice\Entity\Answer();
            $entity->setQuestion($this->getEntityManager()->find('LwcMultipleChoice\Entity\Question', $questionId));
        } else {
                $id = $this->params('id');                    
                $entity = $this->getEntityManager()->find('LwcMultipleChoice\Entity\Answer', $id);
            if (!$entity) {
                throw new \Exception('Answer not found');
            }
                
        }
        
        $result = $this->processEntityEdit('LwcMultipleChoice\Entity\Answer', $entity);
        $answer = $result['entity'];
        
        if ($result['status'] == 'saved') {                        
            return $this->redirect()->toRoute(
                null, 
                array('action' => 'listquestions', 'id'=> $answer->getQuestion()->getTest()->getId())
            );
            
        } 
        
        $view =  new ViewModel();
        $view->form = $result['form'];
        $view->answer = $answer;
        
        return $view;
    }
    
    
    
    /**
     * Edit the basic question entity 
     * 
     * @Todo make it follow DRY principle
     * comment: as we notice editquestion is almost the same code than edittest we need to avoid this double usage.
     * 
     */
    public function editquestionAction()
    {
        $entity = null;
        $new = $this->getRequest()->getQuery()->get('new', null);
        
        $id = $this->params('id');
        
        if ($id) {
            $entity = $this->getEntityManager()->find('LwcMultipleChoice\Entity\Question', $id);
        //process new questions     
        } elseif ($new) {
            $testId = $this->getRequest()->getQuery()->get('testId', null);
            if (!$testId) {
                throw new \Exception('no testid given');
            }            
            $entity = new \LwcMultipleChoice\Entity\Question();
            $entity->setTest($this->getEntityManager()->find('LwcMultipleChoice\Entity\Test', $testId));
        }
        
        
        $result = $this->processEntityEdit('LwcMultipleChoice\Entity\Question', $entity);
        $question = $result['entity'];
        
        if ($result['status'] == 'saved') {                        
            return $this->redirect()->toRoute(
                null, 
                array('action' => 'listquestions', 'id'=>$question->getTest()->getId())
            );
        } 
        
        $view =  new ViewModel();
        $view->form = $result['form'];
        $view->question = $question;
        
        return $view;
    }
    
    public function deleteanswerAction()
    {
        $id = $this->params('id');        
        if ($id) {
            $answer  = $this->getEntityManager()->find('LwcMultipleChoice\Entity\Answer', $id);
            $testId = $answer->getQuestion()->getTest()->getId();            
            $this->getEntityManager()->remove($answer);
        } else {
            throw new \Exception('Answer not Found');
        }
        $this->getEntityManager()->flush();
        return $this->redirect()->toRoute(null, array('action' => 'listquestions', 'id' => $testId));
    }
    
    
    public function deletequestionAction()
    {
        $id = $this->params('id');
        if ($id) {
            $question = $this->getEntityManager()->find('LwcMultipleChoice\Entity\Question', $id);
            $testId = $question->getTest()->getId();
            $answers = $this->getEntityManager()->getRepository('LwcMultipleChoice\Entity\Answer')
                    ->findBy(array("question" => $question));            
            //@TODO Performance: here we create another big performance issue, expect 1000 answers
            foreach ($answers as $answer) {
                $this->getEntityManager()->remove($answer);
            }            
            $this->getEntityManager()->remove($question);
        } else {
            throw new \Exception('Question not found');
        }
        $this->getEntityManager()->flush();
        return $this->redirect()->toRoute(null, array('action' => 'listquestions', 'id' => $testId));
    }
    
    public function deletetestAction()
    {        
        $id = $this->params('id');
        if ($id) {
            $test = $this->getEntityManager()->find('LwcMultipleChoice\Entity\Test', $id);
           
            //@TODO Performance worse performance here with recursive delete
            $questions = $this->getEntityManager()->getRepository('LwcMultipleChoice\Entity\Question')
                    ->findBy(array("test" => $test));            
            
            foreach ($questions as $question) {
                $answers = $this->getEntityManager()->getRepository('LwcMultipleChoice\Entity\Answer')
                        ->findBy(array("question" => $question));            
                foreach ($answers as $answer) {
                    $this->getEntityManager()->remove($answer);
                }            
            $this->getEntityManager()->remove($question);
            }
            
            $this->getEntityManager()->remove($test);
        }
        $this->getEntityManager()->flush();
        return $this->redirect()->toRoute(null, array('action' => 'index'));
    }
    
}
