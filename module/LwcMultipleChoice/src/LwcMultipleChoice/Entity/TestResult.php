<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace LwcMultipleChoice\Entity;

/**
 * Description of TestResult
 *
 * @author John Behrens <John.behrens@WebConsults.eu>
 */
class TestResult
{
    
    
    private $pointsMissed;
    private $pointsScored;
    
    private $questionsTotal;
   
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
        $this->setPointsScored($this->getPointsScored() + $points);
    }


}