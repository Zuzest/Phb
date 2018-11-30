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
  /*'router'             => [
    // 'className' => 'Phalcon\Mvc\Router',
    'className' => 'Extend\MvcRouter',
    'shared'  => true,
  ],*/
  'dispatcher'         => [
    'className' => 'Extend\MvcDispatcherAdmin',
    // 'className' => 'Phalcon\Mvc\Dispatcher',
    'shared'  => true,
  ],
  /*'modelsManager'      => [
    'className' => 'Phalcon\Mvc\Model\Manager',
    'shared'  => true,
  ],
  'modelsMetadata'     => [
    'className' => 'Phalcon\Mvc\Model\MetaData\Memory',
    'shared'  => true,
  ],
  'filter'             => [
    'className' => 'Phalcon\Filter',
    'shared'  => true,
  ],
  'escaper'            => [
    'className' => 'Phalcon\Escaper',
    'shared'  => true,
  ],
  'annotations'        => [
    'className' => 'Phalcon\Annotations\Adapter\Memory',
    'shared'  => true,
  ],
  'security'           => [
    'className' => 'Phalcon\Security',
    'shared'  => true,
  ],
  'eventsManager'      => [
    'className' => 'Phalcon\Events\Manager',
    'shared'  => true,
  ],
  'transactionManager' => [
    'className' => 'Phalcon\Mvc\Model\Transaction\Manager',
    'shared'  => true,
  ],

  'url'                => [
    // 'className' => 'Phalcon\Mvc\Url',
    'className' => 'Extend\Mvc\Url',
    'shared'  => true,
  ],
  'response'           => [
    'className' => 'Phalcon\Http\Response',
    'shared'  => true,
  ],
  'cookies'            => [
    // 'className' => 'Phalcon\Http\Response\Cookies',
    'className' => 'Extend\HttpResponseCookies',
    'shared'  => true,
  ],
  'request'            => [
    // 'className' => 'Phalcon\Http\Request',
    'className' => 'Extend\HttpRequest',
    'shared'  => true,
  ],
  'crypt'              => 'Extend\Crypt',*/
  /*[
    // 'className' => 'Phalcon\Crypt',
    'className' => 'Extend\Crypt',
    'shared'  => true,
  ],*/
  /*'flash'              => [
    'className' => 'Phalcon\Flash\Direct',
    'shared'  => true,
  ],
  'flashSession'       => [
    'className' => 'Phalcon\Flash\Session',
    'shared'  => true,
  ],
  'tag'                => [
    'className' => 'Phalcon\Tag',
    'shared'  => true,
  ],
  'session'            => [
    // 'className' => 'Phalcon\Session\Adapter\Files',
    // 'className' => 'Phalcon\Session\Adapter\Redis',
    'className' => 'Extend\SessionAdapterRedis',
    'shared'  => true,
  ],
  'sessionBag'         => 'Phalcon\Session\Bag',
  'assets'             => [
    // 'className' => 'Phalcon\Assets\Manager',
    'className' => 'Extend\AssetsManager',
    'shared'  => true,
  ],


  'elements'           => [
    'className' => '\Elements',
    'shared'  => true,
  ],
  'tpl'           => [
    'className' => '\Tpl',
    'shared'  => true,
  ],
  'smarty'           => [
    'className' => 'Extend\Smarty',
    'shared'  => true,
  ],
  'db'           => [
    'className' => 'Extend\Db',
    'shared'  => true,
  ],

  'cache'           => [
    'className' => 'Extend\Cache',
    'shared'  => true,
  ],*/
];
