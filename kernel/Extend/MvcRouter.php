<?php

namespace Extend;

class MvcRouter extends \Phalcon\Mvc\Router {

  public function __construct(bool $defaultRoutes = true) {

    parent::__construct(false);

    $this->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);
    return $this;
  }
}