<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\Address;
use Application\Entity\Project;
use Application\Entity\Student;
use Application\Entity\User;
use Debug\Service\Timer;
use Doctrine\ORM\EntityManager;
use Zend\Config\Config;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Log\Logger;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;


class IndexController extends AbstractActionController 
{
     
    /** @var Config */     
    private $config;
    
    /** @var Logger */
    private $logger;
    
    /** @var EntityManager */
    private $em;

    /** @var Timer */
    private $timer;

    public function notFoundAction()
    {
        
    }    
    /**
     * @param Config $config
     * @param Logger $logger
     * @param EntityManager $em
     * @param Timer $timer
     * @return IndexController */
    public function __construct($config, $logger, $em, $timer) {
        $this->config = $config;
        $this->logger = $logger;
        $this->em = $em;
        $this->timer = $timer;        
        $this->timer->start('test');

    }
    
    public function indexAction() {
        
        $user = new User();
        $user->setFullName('Stef');
        
        $this->em->persist($user);
        
        $address = new Address;
        $address->setCity('Lausanne');
        
        $this->em->persist($address);
        $user->setAddress($address);
        
        $project1 = new Project;
        $project1->setName('Project1');
        $this->em->persist($project1);
        
        $project2 = new Project;
        $project2->setName('Project2');
        $this->em->persist($project2);
        
        $user->getProjects()->add($project1);        
        $user->getProjects()->add($project2);
        
        
        
        $this->em->flush();
        
        


        return array(
            'version' => $this->config['application']['version'],
            'applicationName' => $this->config['application']['name']
        );
    }

    public function studentAction()
    {
        $student    = new Student();
        $builder    = new AnnotationBuilder();
        
        /* var $form \Zend\Form\Form */
        $form       = $builder->createForm($student);

         
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->bind($student);
            $form->setData($request->getPost());
            if ($form->isValid()){
                print_r($form->getData());
            }
        }
        return array('form'=>$form);        
    }
    
    public function aboutAction() {
        $this->logger->info('test');
        return array();
    }
    
    public function infoAction() {
        $array = [];
        for($i=0;$i<20;$i++){
            $array[]=[$i,20-$i];
        }
        $result = new JsonModel([
            'todos' =>$array,
            'success'=>true]
        );
 
        return $result;        
    }

}
