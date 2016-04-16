<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;


class IndexController extends AbstractActionController {

    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function indexAction() {

        return array(
            'version' => $this->config['application']['version'],
            'applicationName' => $this->config['application']['name']
        );
    }

    public function aboutAction() {
        return array();
    }

}
