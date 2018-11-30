<?php

namespace Extend;

class DB {

  private static $db = null;

  public function __construct() {
    $config = \CFG::Database()->toArray();
    $config['options'] = [
      \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$config['set_names'],//'UTF8MB4'",
      // PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
      \PDO::ATTR_PERSISTENT         => true,
      \PDO::MYSQL_ATTR_COMPRESS     => true,
    ];

    $adapter = '\Phalcon\Db\Adapter\Pdo\\'.$config['adapter'];
    self::$db = new $adapter($config);
    return self::$db;
  }
  public function __call($name, $arg) {
    if(!self::$db) {
      new self();
    }
    // перенправляем вызовы в \Phalcon\Db\Adapter
    if(method_exists(self::$db, $name)) {
      return call_user_func_array([self::$db, $name], $arg);
    }

    throw new Exception('Error: unknown method Db->'.$name.'()', 1);
  }
}