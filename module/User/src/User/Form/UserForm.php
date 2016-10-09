<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilterInterface;

class UserForm extends Form {

    //protected $filter;

    public function __construct($name = 'user') {
        parent::__construct($name);

        $this->setAttribute('method', 'post');
        // This is how we define the "email" element
        $this->add(array(
            'name' => 'email', // the unique name of the element in the form.
            //Ex: <input name="..."
            'type' => 'Zend\Form\Element\Email',
            // The above must be valid Zend Form element.
            // You can also use short names as “email” instead of “Zend\Form\Element\Email
            'options' => array(
                // This is list of options that we can add to the element.
                'label' => 'Email:'
            // Label is the text that should who before the form field
            ),
            'attributes' => array(
                // These are the attributes that are passed directly to the HTML element
                'type' => 'email', // Ex: <input type="email"
                'required' => true, // Ex: <input required="true"
                'placeholder' => 'Email Address...', // HTM5 placeholder attribute
            )
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'placeholder' => 'Password Here...',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        $this->add(array(
            'name' => 'password_verify',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'placeholder' => 'Verify Password Here...',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Verify Password',
            ),
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Type name...',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));

        $this->add(array(
            'name' => 'phone',
            'options' => array(
                'label' => 'Phone number'
            ),
            'attributes' => array(
                // Below: HTML5 way to specify that the input will be phone number
                'type' => 'tel',
                'required' => 'required',
                // Below: HTML5 way to specify the allowed characters
                'pattern' => '^\d+$'
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'photo',
            'options' => array(
                'label' => 'Your photo'
            ),
            'attributes' => array(
                'required' => 'required',
                'id' => 'photo'
            ),
        ));
        // This is the special code that protects our form beign submitted from automated scripts
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));

        // This is the submit button
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Submit',
                'required' => 'false',
            ),
        ));
    }

    public function setInputFilter(InputFilterInterface $inputFilter){
        throw new \Exception('It is not allowed to set the input filter');
    }

    public function getInputFilter() {
        if (!$this->filter) {
            $inputFilter = new InputFilter ();
            $factory = new Factory ();

            //Is the email address valid?
            $inputFilter->add($factory->createInput(array(
                        'name' => 'email',
                        'filters' => array(
                            array(
                                'name' => 'StripTags'
                            ),
                            array(
                                'name' => 'StringTrim'
                            )
                        ),
                        'validators' => array(
                            array(
                                'name' => 'EmailAddress',
                                'options' => array(
                                    'messages' => array(
                                        'emailAddressInvalidFormat' => 'Email address format is not invalid'
                                    )
                                )
                            ),
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Email address is required'
                                    )
                                )
                            )
                        )
            )));

            //Verify the name and password are not empty
            $inputFilter->add($factory->createInput(array(
                        'name' => 'name',
                        'filters' => array(
                            array(
                                'name' => 'StripTags'
                            ),
                            array(
                                'name' => 'StringTrim'
                            )
                        ),
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Name is required'
                                    )
                                )
                            )
                        )
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'password',
                        'filters' => array(
                            array(
                                'name' => 'StripTags'
                            ),
                            array(
                                'name' => 'StringTrim'
                            )
                        ),
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Password is required'
                                    )
                                )
                            )
                        )
            )));            

            //Verify the password is confirmed correctly
            //You might also want to add another password field in which the user is asked to repeat the
            //password, in order to verify that the password is correct.
            $inputFilter->add($factory->createInput(array(
                        'name' => 'password_verify',
                        'filters' => array(
                            array(
                                'name' => 'StripTags'
                            ),
                            array(
                                'name' => 'StringTrim'
                            )
                        ),
                        'validators' => array(
                            array(
                                'name' => 'identical',
                                'options' => array(
                                    'token' => 'password'
                                )
                            )
                        )
            )));

            //If the uploaded file is an image, we allow only png, gif and jpeg format.
            //Additionally we can specify file size limitation and image size limitation. The code below describes
            //these requirements:
            $inputFilter->add($factory->createInput(array(
                        'name' => 'photo',
                        'validators' => array(
                            array(
                                'name' => 'filesize',
                                'options' => array(
                                    'max' => 2097152, // 2 MB
                                ),
                            ),
                            array(
                                'name' => 'filemimetype',
                                'options' => array(
                                    'mimeType' =>
                                    'image/png,image/x-png,image/jpg,image/jpeg,image/gif',
                                )
                            ),
                            array(
                                'name' => 'fileimagesize',
                                'options' => array(
                                    'maxWidth' => 20000,
                                    'maxHeight' => 20000
                                )
                            ),
                        ),
                        'filters' => array(
                            // the filter below will save the uploaded file under
                            // <app-path>/data/image/photos/<tmp_name>_<random-data>
                            array(
                                'name' => 'filerenameupload',
                                'options' => array(
                                    // Notice: Make sure that the folder below is existing on your system
                                    // otherwise this filter will not pass and you will get strange
                                    // error message reporting that the required field is empty
                                    'target' => getcwd().'/data/image/photos/',
                                    'randomize' => true,
                                ),
                            ),
                        ),
            )));

            //Does the phone number match the requirements?
            //For the phone validators and filter let us revisit the example used when we first started discussing
            //InputFilter.
            $inputFilter->add($factory->createInput(array(
                        'name' => 'phone',
                        'filters' => array(
                            array('name' => 'digits'),
                            array('name' => 'stringtrim'),
                        ),
//                        'validators' => array(
//                            array(
//                                'name' => 'regex',
//                                'options' => array(
//                                    'pattern' => '/^[\d-\/]+$/',
//                                )
//                            ),
//                        )
            )));
            //...
            $this->filter = $inputFilter;
        }
        return $this->filter;
    }

}
