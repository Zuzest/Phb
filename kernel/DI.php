<?php

class DI {
  private static $instance = null;
  private static $di = null;

  public function __construct($pathToLoad = false) {
    if(self::$instance) {
      return self::$di;
      // return self::$instance;
    }
    self::$di = new \Phalcon\Di();
    if(is_readable($pathToLoad)) {
      self::$di->loadFromPhp($pathToLoad);
    }

    self::$instance = $this;
    return self::$di;
  }

  private static function getSelf() {
    return self::$di;
    // return self::$instance;
  }

  private function getInstance() {
    return self::$di;
    // return self::$instance;
  }

  public static function __callStatic($name, $arg) {
    if(!$instance = self::$instance) {
      throw new Exception('Error: not initialized DI', 1);
    }
    // сначала проверяем вызов объекта из контейнера
    // DI::Request()
    $getName = 'get'.$name;
    if(self::$di->has(strtolower($name))) {
      return call_user_func_array([self::$di, $getName], $arg);
    }

    // тут проверяем вызов объекта классическим способом
    // DI::getRequest()
    // либо вызов метода из Phalcon\Di
    $getName = strtolower(substr_replace($name, '', 0, 3));
    if(method_exists(self::$di, $name) || self::$di->has($getName)) {
      return call_user_func_array([self::$di, $name], $arg);
    }

    // и тут проверка на существование расширенных методов
    if(method_exists(self::$instance, $name)) {
      return call_user_func_array([self::$instance, $name], $arg);
    }

    // так наверно лучше не делать, но прям сейчас для меня это более удобное решение
    throw new Exception('Error: unknown method DI::'.$name.'()', 1);
  }
}