<?php

class ModelBase extends \Phalcon\Mvc\Model
{
  public function initialize()
  {
    $this->setSource($this->getSource());

    if(isset($this->relation)) {
      foreach($this->relation as $relation) {
        $key = key($relation);
        call_user_func_array([$this, $key], $relation[$key]);
      }
    }
  }

  public static $skipFields = [];

  public function beforeSave() {
    $this->skipAttributes(static::$skipFields);
  }

  private $_error;
  public function save($data = NULL, $whiteList = NULL) {
    try {
      parent::save($data, $whiteList);
      return true;
    } catch (Exception $e) {
      $this->_error = $e;
            // vdump($e->getMessage());
            // vdump($e->getCode());
      return false;
    }
  }
  public function getError($type = null):?string {
    if(is_object($this->_error)) {
      $e = $this->_error;
    } else {
      $e = new Exception();
    }
    switch ($type) {
      case 'code':
        return $e->getCode();
        break;
      case 'message':
        return $e->getMessage();
        break;

    }
    return $e;
  }

}
