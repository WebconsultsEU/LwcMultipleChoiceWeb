<?php

namespace LwcMultipleChoice\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity
 */
class Answer
{
    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="string", length=255, nullable=false)
     */
    private $answer;

    /**
     * @var integer
     *
     * @ORM\Column(name="points", type="integer", nullable=false)
     */
    private $points;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Attributes({"type":"hidden"})
     * 
     */
    private $id;

    /**
     * @var \LwcMultipleChoice\Entity\Question
     *
     * @ORM\ManyToOne(targetEntity="LwcMultipleChoice\Entity\Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     * })
     * @Annotation\Exclude()
     */
    private $question;

    
    /**
     * Set answer
     *
     * @param string $answer
     * @return Answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    
        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return Answer
     */
    public function setPoints($points)
    {
        $this->points = $points;
    
        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
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
     * Set question
     *
     * @param \LwcMultipleChoice\Entity\Question $question
     * @return Answer
     */
    public function setQuestion(\LwcMultipleChoice\Entity\Question $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \LwcMultipleChoice\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
