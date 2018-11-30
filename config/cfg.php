<?php

return new \Phalcon\Config([
  'application' => [
    'controllersDir' => APP_DIR.'controllers/',
    'viewsDir'       => APP_DIR.'resources/desktop/tpl/',
    'modelsDir'      => ROOT.'models/',
    'componentsDir'  => ROOT.'components/',
    // 'assetsDir'      => 'assets/',
    // 'cacheDir'       => ROOT.'/../../app/cache/',//???
    // 'filesDir'       => ROOT.'/../../app/mod_files/',//???
    // 'baseUri'        => '/',
  ],
  /*'interfaces' => [
    ROOT.'components/interface/',
  ],*/
  'assets'      => [
    'targetPath' => ROOT.'public/assets/',
    'targetUri'  => '/assets/',
    'sourcePath' => APP_DIR.'resources/desktop/',
    'mail'       => [
      'tpl' => ROOT.'assets/email/tpl/',
    ],
  ],
  'plugins' => [
    'smarty' => [
      'registerClass' => [
        'tpl' => '\DI::Tpl()',
      ]
    ],
  ],
]);