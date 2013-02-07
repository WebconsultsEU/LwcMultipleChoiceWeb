<?php

namespace LwcMultipleChoice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use LwcMultipleChoice\Form;
use Doctrine\ORM\EntityManager;

use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;



class AdminController  extends AbstractActionController {
   
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
        throw new \Exception('This has no function yet');
        return new ViewModel();
        
    }
    /**
     *  Edit the basic test entity 
     */
    public function edittestAction()
    {
        
         $entityManager = $this->getEntityManager();
        
         $id = $this->params('id');
         if($id) {
            $test = $this->getEntityManager()->find('LwcMultipleChoice\Entity\Test', $id);
         } else {
             //there should be a better way to get a form annotation
             $test = new Entity\Test();
         }
         
        
         
        //Doctrine form Builder supports building forms by annotations from doctrine entitys
        $builder = new \DoctrineORMModule\Form\Annotation\AnnotationBuilder( $entityManager);
        
        //Create a form for the Test-Annotation Object
        $form = $builder->createForm( $test );
        //create a DoctrineEntity Hydrator for the Form Annotation
        $hydrator = new  \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($entityManager, 'LwcMultipleChoice\Entity\Test');
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
        
        if($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if($form->isValid()) {
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
        
        return $view;

    }
    
}
