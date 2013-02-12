<?php

namespace LwcMultipleChoice\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;


/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity
 */
class Question
{
    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255, nullable=false)
     */
    private $question;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     * @Annotation\Exclude()
     */
    private $created;

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

    /**
     * Set question
     *
     * @param string $question
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Question
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set test
     *
     * @param \LwcMultipleChoice\Entity\Test $test
     * @return Question
     */
    public function setTest(\LwcMultipleChoice\Entity\Test $test = null)
    {
        $this->test = $test;
    
        return $this;
    }

    /**
     * Get test
     *
     * @return \LwcMultipleChoice\Entity\Test 
     */
    public function getTest()
    {
        return $this->test;
    }
}
