<?php

namespace LwcMultipleChoice\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;


/**
 * Question
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity
 */
class Evaluation
{
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=4096, nullable=false)
     * @Annotation\Options({"label":"Text "})
     * @Annotation\Attributes({"type":"textarea"})
     */
    private $text;
    
    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=256, nullable=false)
     * @Annotation\Options({"label":"Subject "})
     */
    private $subject;

    /**
     * @var integer
     *
     * @ORM\Column(name="minpercent", type="integer")
     * @Annotation\Options({"label":"Minimum Percent "})
     */
    private $minpercent;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="maxpercent", type="integer")
     * @Annotation\Options({"label":"Max Percent; "})
     */
    private $maxpercent;
    
    
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
    
    public function getText() 
    {
        return $this->text;
    }

    public function setText($text) 
    {
        $this->text = $text;
    }

    public function getSubject() 
    {
        return $this->subject;
    }

    public function setSubject($subject) 
    {
        $this->subject = $subject;
    }

    public function getMinpercent()
    {
        return $this->minpercent;
    }

    public function setMinpercent($minpercent)
    {
        $this->minpercent = $minpercent;
    }

    public function getMaxpercent()
    {
        return $this->maxpercent;
    }

    public function setMaxpercent($maxpercent)
    {
        $this->maxpercent = $maxpercent;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTest()
    {
        return $this->test;
    }

    public function setTest($test)
    {
        $this->test = $test;
    }


}