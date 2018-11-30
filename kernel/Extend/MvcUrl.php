<?php

namespace Extend;

class MvcUrl extends \Phalcon\Mvc\Url  {

  public function __construct(/*array $options = []*/) {
    $this->setBaseUri(\CFG::Application()->baseUri);

    return $this;
  }
}