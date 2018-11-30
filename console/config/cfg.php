<?php

return new \Phalcon\Config([
  'tasks' => [
    'alias'  => [
      'm'   => 'migrate',
      'mod' => 'model',
    ],
    'access' => [
      'migrate',
      'model',
    ],
  ],
  'path'  => [
    'tasks'   => APP_DIR.'tasks',
    'migrate' => ROOT.'migrations/',
    'models'  => ROOT.'models/',
    'components'  => ROOT.'components/',
  ],
]);
