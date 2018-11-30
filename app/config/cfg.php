<?php

return new \Phalcon\Config([
  'application' => [
    'baseUri' => '/',
    // 'profile'   => false,
  ],
  'assets'      => [
    /*'targetPath' => ROOT.'public/assets/',
    'targetUri'  => '/assets/',
    'sourcePath' => APP_DIR.'resource/desktop/',*/
    'resource' => [
      'css' => [
        // 'base' => [
          'normalize',
          // 'reset',
          'index',
        // ],
      ],
      'js'  => [
        // 'base' => false,
      ],
    ],
  ],
]);
