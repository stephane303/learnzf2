<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity */
class Project {
    /** @ORM\Id @ORM\Column(type="integer")
     *  @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
    
    /** @ORM\Column(type="string") */
    protected $name;
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }


    
}
