<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity */
class Product
{
    /**
     * @var int
    ** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue 
     */
    protected $id;
    /**
     * @var string
     ** @ORM\Column(type="string") 
     */
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}

