<?php

class IndexController extends PreController
{
  /*public function constructAction() {
    // vdump(__METHOD__);
    // parent::constructAction();
    // vdump($this->dispatcher->getActionName());
  }*/

  public function indexAction()
  {
    // vdump($this);
    // vdump(__METHOD__);
    // $obj = $this->db->query('SHOW GLOBAL VARIABLES;');
    // $this->cache->save('zyi','zzzzui', 344444);
    // vdump($this->cache->get('zyi'));
    // vdump($this->elements->getSiteVersion());
    // vdump(\CFG::Cache()->memcache->lifetime);
    // vdump($obj->fetchOne());
    // vdump($this->db->query('SHOW GLOBAL VARIABLES;'));
    // vdump($this->cookies);
    // vdump($this->smarty->getTemplateDir());
    $this->dispatcher->forward(['action' => 'construct']);
    //
    vdump('----12345----');
    $this->smarty->assign('ttt','tttt');
  }

  public function errorAction()
  {
    vdump(__METHOD__);
    // vdump($this->crypt);
    // vdump($this->cookies);
    // vdump($this->smarty->getTemplateDir());
    $this->smarty->assign('ttt','tttt');
  }

}