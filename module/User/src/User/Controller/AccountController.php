<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\UserForm as UserForm;
use User\Model\User as UserModel;

class AccountController extends AbstractActionController {

    public function indexAction() {
        return array();
    }

    public function addAction() {

        $form = new UserForm();
        if ($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(),
                    // Notice: make certain to merge the Files also to the post data
                    $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if ($form->isValid()) {
                $model = new UserModel();
                $id = $model->insert($form->getData());
            }
        }

        // pass the data to the view for visualization
        return array('form1' => $form);
    }

    public function deleteAction() {
        $id = $this->getRequest()->getQuery()->get('id');
        if ($id) {
            $userModel = new UserModel();
            $userModel->delete(array('id' => $id));
        }

        return array();
    }

    /*
     * Anonymous users can use this action to register new accounts
     */

    public function registerAction() {
        return array();
    }

    public function viewAction() {
        return array();
    }

    public function editAction() {
        return array();
    }



}
