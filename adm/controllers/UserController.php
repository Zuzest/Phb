<?php

class UserController extends PreController
{
  /*public function constructAction() {
    // vdump(__METHOD__);
    // parent::constructAction();
    // vdump($this->dispatcher->getActionName());
  }*/

  public function indexAction()
  {
    vdump(__METHOD__);
    // vdump($this->crypt);
    // vdump($this->cookies);
    vdump($this->smarty->getTemplateDir());
    $this->smarty->assign('ttt','tttdsfsdfddssd');
  }


}