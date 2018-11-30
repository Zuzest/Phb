<?php

return [
  // базовые сервисы для web
  /*'router'             => 'Phalcon\Mvc\Router',
  'dispatcher'         => 'Phalcon\Mvc\Dispatcher',
  'modelsManager'      => 'Phalcon\Mvc\Model\Manager',
  'modelsMetadata'     => 'Phalcon\Mvc\Model\MetaData\Memory',
  'filter'             => 'Phalcon\Filter',
  'escaper'            => 'Phalcon\Escaper',
  'annotations'        => 'Phalcon\Annotations\Adapter\Memory',
  'security'           => 'Phalcon\Security',
  'eventsManager'      => 'Phalcon\Events\Manager',
  'transactionManager' => 'Phalcon\Mvc\Model\Transaction\Manager',

  'url'                => 'Phalcon\Mvc\Url',
  'response'           => 'Phalcon\Http\Response',
  'cookies'            => 'Phalcon\Http\Response\Cookies',
  'request'            => 'Phalcon\Http\Request',
  'crypt'              => 'Phalcon\Crypt',
  'flash'              => 'Phalcon\Flash\Direct',
  'flashSession'       => 'Phalcon\Flash\Session',
  'tag'                => 'Phalcon\Tag',
  'session'            => 'Phalcon\Flash\Session',
  'sessionBag'         => 'Phalcon\Session\Bag',
  'assets'             => 'Phalcon\Assets\Manager',*/

  'dispatcher'         => [
    'className' => 'Extend\MvcDispatcher',
    // 'className' => 'Phalcon\Mvc\Dispatcher',
    'shared'  => true,
  ],

];
