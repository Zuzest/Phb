<?php

return [
  // базовые сервисы для cli
  /*'router'             => 'Phalcon\Mvc\Router',
  'dispatcher'         => 'Phalcon\Mvc\Dispatcher',
  'modelsManager'      => 'Phalcon\Mvc\Model\Manager',
  'modelsMetadata'     => 'Phalcon\Mvc\Model\MetaData\Memory',
  'filter'             => 'Phalcon\Filter',
  'escaper'            => 'Phalcon\Escaper',
  'annotations'        => 'Phalcon\Annotations\Adapter\Memory',
  'security'           => 'Phalcon\Security',
  'eventsManager'      => 'Phalcon\Events\Manager',
  'transactionManager' => 'Phalcon\Mvc\Model\Transaction\Manager',*/
  'router'             => [
    'className' => 'Phalcon\Cli\Router',
    'shared'  => true,
  ],
  'dispatcher'         => [
    'className' => 'Phalcon\Cli\Dispatcher',
    'shared'  => true,
  ],
  'modelsManager'      => [
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

  'crypt'              => 'Extend\Crypt',

  'db'           => [
    'className' => 'Extend\DB',
    'shared'  => true,
  ],

  'cache'           => [
    'className' => 'Extend\Cache',
    'shared'  => true,
  ],
];
