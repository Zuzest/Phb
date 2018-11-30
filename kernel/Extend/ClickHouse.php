<?php

namespace Extend;

class ClickHouse extends \ClickHouseDB\Client {

  public function __construct() {
    $config = \CFG::Plugins()->clickhouse->database_connect;

    parent::__construct($config->toArray());

    $this->database($config->database);

    return $this;
  }
}