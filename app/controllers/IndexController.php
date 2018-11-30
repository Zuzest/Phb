<?php

class IndexController extends PreController
{

  public function indexAction()
  {

    // $csql = 'CREATE DATABASE IF NOT EXISTS `prt_qwzy`';
    $csql = "CREATE TABLE IF NOT EXISTS `test` (
        event_date Date DEFAULT toDate(event_time),
        event_time DateTime,
        uuid String,
        ip String,
        link String,
        referer String
      ) ENGINE = MergeTree(event_date, (uuid, link, event_time, event_date), 8192)
    ";
      // MergeTree()
    // $csql = "SHOW TABLES";
    // $this->click->write($csql);

    // $click = $this->click->select('SELECT DATABASE()');
    // $click = $this->click->select('SHOW DATABASES');
    $click = $this->click->select('SHOW TABLES');
    /*while($row = $click->rows()) {
      vdump($row);
    }*/
    vdump($click->rows());
    vdump($this->click->showCreateTable('test'));
    // vdump($this->click);

    $this->smarty->assign('ttt','tttt');
  }

  public function errorAction()
  {

  }

}