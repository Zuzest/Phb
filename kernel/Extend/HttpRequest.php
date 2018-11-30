<?php

namespace Extend;

class HttpRequest extends \Phalcon\Http\Request {

  public function getUrlPath() {
    return parse_url($this->getUri(), PHP_URL_PATH);
  }

  public function getUrlQuery() {
    return parse_url($this->getUri(), PHP_URL_QUERY);
  }

  /*public function getUrlFragment() {
    return parse_url($this->getUri(), PHP_URL_FRAGMENT);
  }*/

  public function setURI(string $uri = '') {
    $_SERVER['REQUEST_URI'] = $uri;
  }
}