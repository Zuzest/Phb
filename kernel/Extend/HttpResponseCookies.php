<?php

namespace Extend;

class HttpResponseCookies extends \Phalcon\Http\Response\Cookies {

  public function __construct() {
    parent::__construct();
    $this->useEncryption(\CFG::cookies()->encryption);
  }
}