<?php

namespace Extend;

class Cache {

  private static $cache = null;

  public function __construct() {

    $frontCache = new \Phalcon\Cache\Frontend\Data([
      'lifetime' => \CFG::Cache()->memcache->lifetime,
    ]);

    //Memcached connection settings
    self::$cache = new \Phalcon\Cache\Backend\Libmemcached($frontCache, [
      'servers'       => \CFG::Cache()->memcache->servers->toArray(),
      'client'        =>  \CFG::Cache()->memcache->client->toArray(),
      'persistent_id' => 'app',
    ]);
    return self::$cache;
  }
  public function __call($name, $arg) {
    if(!self::$cache) {
      new self();
    }
     if(method_exists(self::$cache, $name)) {
      return call_user_func_array([self::$cache, $name], $arg);
    }

    throw new Exception('Error: unknown method Cache->'.$name.'()', 1);
  }
}