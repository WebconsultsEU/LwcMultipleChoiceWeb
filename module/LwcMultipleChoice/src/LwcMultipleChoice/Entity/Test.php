<?php

namespace LwcMultipleChoice\Entity;


use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;


/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity
 * @Annotation\Name("Test")
 */
class Test
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60, nullable=false)
     * @Annotation\Options({"label":"Name:"})
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=2048, nullable=false)
     * @Annotation\Options({"label":"Description:"})
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="teaser", type="string", length=256, nullable=false)
     * @Annotation\Options({"label":"Short Description:"})
     */
    private $teaser;
        

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @Annotation\Attributes({"type":"hidden"})
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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Attributes({"type":"hidden"})
     */
    private $id;

    
    public function __construct()
    {
        $this->created = new \DateTime("now");
    }
    
    
    /**
     * Set name
     *
     * @param string $name
     * @return Test
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Test
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Test
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
     *
     * @return string
     */
    public function getDescription() 
    {
        return $this->description;
    }
    
    /**
     *
     * @param string $description 
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    public function getTeaser() 
    {
        return $this->teaser;
    }

    public function setTeaser($teaser) 
    {
        $this->teaser = $teaser;
    }


    
}
