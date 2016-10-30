<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity */
class User {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /** @ORM\Column(type="string") */
    protected $fullName;
    
    /** @ORM\ManyToOne(targetEntity="Address") */    
    protected $address;
    
    /** @ORM\ManyToMany(targetEntity="Project") */
    protected $projects;

    function getAddress() {
        return $this->address;
    }

    function getProjects() {
        return $this->projects;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setProjects($projects) {
        $this->projects = $projects;
    }

    
    public function __construct() {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection;
    }
    function getId() {
        return $this->id;
    }

    function getFullName() {
        return $this->fullName;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFullName($fullName) {
        $this->fullName = $fullName;
    }




}

