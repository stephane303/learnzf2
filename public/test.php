<?php
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\InputFilter\Factory;

chdir(dirname(__DIR__));

// Setup autoloading
require 'init_autoloader.php';


// This is how we create the element and add filtering rules to it
$phone = new Input();
$phone->getFilterChain()->attachByName('digits')
                        ->attachByName('stringtrim');


// This is how we create the input filter and add the phone element to it
$filter = new InputFilter();
$filter->add($phone ,'phone');

$data = array (
 'phone' => '00123/4567-89',
);


// This is how we pass the raw data for filtering
$filter->setData($data);


// And this is how we get the filtered data
$phoneFilteredValue = $filter->getValue('phone');
echo $phoneFilteredValue;

