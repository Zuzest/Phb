<?php

namespace Extend;

class Loader extends \Phalcon\Loader {

  public function addDirs(array $dirs = []) {
    $newDirs = array_merge($this->getDirs(), $dirs);
    $this->registerDirs($newDirs);
    return $this;//->register();
  }

}