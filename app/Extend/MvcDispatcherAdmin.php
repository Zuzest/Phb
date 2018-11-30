<?php

namespace Extend;

class MvcDispatcherAdmin extends \Phalcon\Mvc\Dispatcher {

  public function __construct(/*array $options = []*/) {
    // $this->setBaseUri(\CFG::Application()->baseUri);
    $eventsManager = new \Phalcon\Events\Manager();

    // $f = new \F;
    // vdump($f);
    // $eventsManager->attach('dispatch', $f);
    $eventsManager->attach('dispatch:beforeDispatchLoop', $this);
    $eventsManager->attach('dispatch:beforeDispatch', $this);
    $eventsManager->attach('dispatch:beforeExecuteRoute', $this);
    /*$eventsManager->attach('dispatch:beforeDispatchLoop',function (\Phalcon\Events\Event $event, $dispatcher) {
      $action = $dispatcher->getActionName();
      vdump($action);
      vdump('----09876----');
      // vdump($action);
      vdump(\CFG::Application()->name);
      $answ = $dispatcher->forward(['action' => 'construct']);
      vdump($action, $answ);
    });*/

      // vdump('----09876----');
    // событие по окончании цикла
    /*$eventsManager->attach('dispatch:afterDispatchLoop',function (\Phalcon\Events\Event $event, $dispatcher) {
    });*/

    // parent::__construct();
    // $dispatcher = new Phalcon\Mvc\Dispatcher();
    $this->setEventsManager($eventsManager);
    // return $dispatcher;

    return $this;
  }
  /*public function init(\Phalcon\Events\Event $event, \Extend\MvcDispatcher $dispatcher, $exception = null) {
    $action = $this->getActionName();
    vdump(__METHOD__, $action, \DI::Request()->getQuery());
  }*/

  public function beforeDispatchLoop(\Phalcon\Events\Event $event, \Extend\MvcDispatcherAdmin $dispatcher, $exception = null) {
    static $___count;
    // if(!$___count) {
      ++$___count;
      $action = $this->getActionName();
      vdump(__METHOD__, $action, $___count, \DI::Request()->getQuery());
      // vdump(__METHOD__, $action, \DI::Request()->getQuery());
    // }
      // vdump(__METHOD__);
  }


  public static $___count = 0;
  public function beforeExecuteRoute(\Phalcon\Events\Event $event, \Extend\MvcDispatcherAdmin $dispatcher, $exception = null) {
    ++self::$___count;
    vdump(self::$___count);
    $action = $this->getActionName();
    vdump(__METHOD__, $action, \DI::Request()->getQuery());
    // vdump($action);
    // vdump(\DI::Request()->getQuery());
  }
  public function beforeDispatch(\Phalcon\Events\Event $event, \Extend\MvcDispatcherAdmin $dispatcher, $exception = null) {
    vdump(__METHOD__);
    // vdump(__METHOD__, $event, $dispatcher, $exception, $this);
  }
}