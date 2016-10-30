<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity */
class Address {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $city;
    function getId() {
        return $this->id;
    }

    function getCity() {
        return $this->city;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCity($city) {
        $this->city = $city;
    }
}
