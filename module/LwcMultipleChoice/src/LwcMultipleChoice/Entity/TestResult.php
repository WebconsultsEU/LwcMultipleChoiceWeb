<?php

namespace LwcMultipleChoice\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;


/**
 * Test Result Table 
 *
 * @ORM\Table(name="results")
 * @ORM\Entity
 */
class TestResult
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Attributes({"type":"hidden"})
     */
    private $id;
    
   /**
    * @var int
    *
    * @ORM\Column(name="user_id", type="integer")
    * @Annotation\Options({"label":"Text "})
    */
    private $userId;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     * @Annotation\Exclude()
     */
    private $created;
    
    /**
    * @var int
    *
    * @ORM\Column(name="points_missed", type="integer")
    * @Annotation\Options({"label":"Points Missed"})
    */
    private $pointsMissed;
    
    /**
    * @var int
    *
    * @ORM\Column(name="points_scored", type="integer")
    * @Annotation\Options({"label":"Points Scored "})
    */
    private $pointsScored;    
    
     /**
    * @var int
    *
    * @ORM\Column(name="questions_total", type="integer")
    * @Annotation\Options({"label":"Questions Total"})
    */
    private $questionsTotal;
    
     /**
     * @var \LwcMultipleChoice\Entity\Test
     *
     * @ORM\ManyToOne(targetEntity="LwcMultipleChoice\Entity\Test")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     * })
     * @Annotation\Exclude()
     */
    private $test; 
    
    public function __construct()
    {
        $this->created = new \DateTime("now");
    }
    
    public function getPointsMissed() 
    {
        return $this->pointsMissed;
    }

    public function setPointsMissed($pointsMissed) 
    {
        $this->pointsMissed = $pointsMissed;
    }

    public function getPointsScored() 
    {   
        return $this->pointsScored;
    }

    public function setPointsScored($pointsScored) 
    {
        $this->pointsScored = $pointsScored;
    }

    public function getQuestionsTotal()
    {
        return $this->questionsTotal;
    }

    public function setQuestionsTotal($questionsTotal) 
    {
        $this->questionsTotal = $questionsTotal;
    }
    
    public function addPointsScored($points) 
    {
        $this->setPointsScored($this->getPointsScored() + $points);
    }
    public function addPointsMissed($points) 
    {
        $this->setPointsMissed($this->getPointsMissed() + $points);
    }

    public function getId() 
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCreated() 
    {
        return $this->created;
    }

    public function setCreated($created) 
    {
        $this->created = $created;
    }

    public function getTest() 
    {
        return $this->test;
    }

    public function setTest($test) 
    {
        $this->test = $test;
    }
    
    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }




}