<?php

namespace Extend;

class SessionAdapterRedis extends \Phalcon\Session\Adapter\Redis  {

  public function __construct(/*array $options = []*/) {
    $options = \CFG::cache()->redis->toArray();
    $options['lifetime'] = \CFG::session()->lifetime;
    parent::__construct($options);
    return $this;
  }
}