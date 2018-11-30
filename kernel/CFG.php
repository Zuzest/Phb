<?php

class CFG {

  private static $instance = null;
  private static $cfg = null;

  public const DIR = ROOT.'config/';
  // public const WWW = ROOT.'public/';

  public function __construct($pathToConfig) {

    if(self::$instance) {
      return self::$cfg;
      // return self::$instance;
    }

    self::$cfg = new \Phalcon\Config();
    if (is_readable($pathToConfig)) {
      self::$cfg->merge(include_once $pathToConfig);
    }

    self::$instance = $this;
    return self::$cfg;
  }

  private function getSelf() {
    return self::$cfg;
    // return self::$instance;
  }
  private function getInstance() {
    return self::$cfg;
    // return self::$instance;
  }

  public static function __callStatic($name, $arg) {
    if(!$instance = self::$instance) {
      throw new Exception('Error: not initialized CFG', 1);
    }
    // сначала проверяем свойство в конфигурации
    // в формате CFG::Appliaction()
    if(self::$cfg->offsetExists(strtolower($name))) {
      return self::$cfg->get(strtolower($name));
    }
    // тут проверяем не был ли это вызов в формате Phalcon, через get
    // в формате CFG::getAppliaction()
    $getName = strtolower(substr_replace($name, '', 0, 3));
    if(substr($name, 0, 3)==='get' && self::$cfg->offsetExists($getName)) {
      if(empty($arg)) {
        return self::$cfg->get($getName);
      }
    }

    // далее проверка на метод в Phalcon\Config
    // например CFG::merge(Phalcon\Config)
    if(method_exists(self::$cfg, $name)) {
      return call_user_func_array([self::$cfg, $name], $arg);
    }

    // тут проверка на существование расширенных методов
    if(method_exists(self::$instance, $name)) {
      return call_user_func_array([self::$instance, $name], $arg);
    }

    // так наверно лучше не делать, но прям сейчас для меня это более удобное решение
    throw new Exception('Error: unknown method CFG::'.$name.'()', 1);
  }


}