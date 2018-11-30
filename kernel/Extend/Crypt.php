<?php

namespace Extend;

class Crypt extends \Phalcon\Crypt {

  public function __construct(/*string $cipher = "aes-256-cfb", bool $useSigning = false*/) {
    // parent::__construct($cipher, $useSigning);
    $this->setKey(\CFG::Crypt()->key);
    return $this;
  }
}