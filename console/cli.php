<?php

// блок констант
define('ROOT', dirname(__DIR__).'/');
define('CLI', php_sapi_name() === 'cli');
define('WWW', ROOT.'public/');

if(is_readable(ROOT.'vdump.php')) {
  include_once ROOT.'vdump.php';
}

if(!function_exists('vdump')) {
  function vdump() {
  }
}

try {
  if(!CLI) {
    throw new Exception('Error: this is not a WEB application', 1);
  }
  (new \Phalcon\Loader())
    ->registerDirs([ROOT.'kernel/'])
    ->register();

  new CFG(ROOT.'local.cfg.php');

  new DI(CFG::DIR.'cli.service.php');

  DI::setShared('config', CFG::getSelf());

  CFG::Application()->name = 'cli';

  CFG::Application()->path = ROOT.CFG::Application()
    ->pathList[CFG::Application()->name];
  define('APP_DIR', CFG::Application()->path);

  // догружаем базовый конфиг
  CFG::merge(include_once CFG::DIR.'cfg.php');

  // догружаем конфиг приложения
  if (is_readable(APP_DIR.'config/cfg.php')) {
    CFG::merge(include_once APP_DIR.'config/cfg.php');
  }

  /**
   * ============================================================================
   * ============================================================================
   * ============================================================================
   */

  if (is_readable(CFG::DIR.'loader.php')) {
    // throw new Exception('Error: configuration "five" not found', 1);
    DI::setShared('loader', include_once CFG::DIR.'loader.php');
  }

  DI::Loader()->addDirs([
    CFG::getPath()->tasks,
    CFG::getPath()->migrate,
  ]);

  if (!is_readable(CFG::DIR.'service.php')) {
    throw new Exception('Error: configuration "six" not found', 1);
  }
  include_once CFG::DIR.'service.php';



  $arguments = [
    'task'   => 'error',
    'action' => 'main',
    'params' => [],
  ];

  foreach ($argv as $k => $arg) {
    if (1 === $k) {
      if (array_key_exists($arg, CFG::Tasks()->alias)) {
        $arg = CFG::Tasks()->alias[$arg];
      }
      if (in_array($arg, CFG::Tasks()->access->toArray())) {
        $arguments['task'] = $arg;
      }
    } else if ($k >= 2) {
      $arguments['params'][] = $arg;
    }
  }
  // vdump(DI::Loader()->getDirs());

    /*$loader = new \Phalcon\Loader();
    // vdump(CFG::getPath());
    $loader->registerDirs([
      CFG::getPath()->tasks,
      CFG::getPath()->migrate,
    ]);
    vdump($loader->getDirs());
    // $loader->registerNamespaces($this->config->namespaces->toArray());
    $loader->register();*/
    // $this->getDI()->setShared('loader', $loader);

    // CFG::setRouter();
    // CFG::setService();

    // vdump(DI::getCache());
    // vdump(DI::getCrypt());
// vdump(CFG::getUri());
// Phalcon\Cli\Console
    $app = new \Phalcon\Cli\Console(DI::getSelf());
    // $app->setDI(DI::getSelf());
    // vdump(APP_DIR);
    // vdump(CFG::getApplication());
    // $app->useImplicitView(false);
    $app->handle($arguments);

    // $app->tpl->display();
    // CFG::offsetUnset('application');
    // vdump(CFG::count());
    // vdump(CFG::toArray());
    // vdump(CFG::getUri());
    // vdump(CFG::getApplication());
    // vdump(DI::getSelf());
    exit;
    // vdump(DI::getDI());

    // new CFG();

    // CFG::setLoader();

    // CFG::setRouter();

    // CFG::setService();

    $app = new Phalcon\Mvc\Application($di);
    $app->useImplicitView(false);

    $app->handle($di->getConfig()->uri);

    vdump($di);
    exit;

    vdump(CFG::getInstance());
    // vdump(CFG::APPS());
    // vdump(CFG::$APP);
    vdump(CFG::TEST);
    // vdump(CFG::TEX);
    vdump(CFG::WWW);
    vdump($cfg);


    exit;

    // $di = new \Phalcon\Di();
    $di = new \Phalcon\Di\FactoryDefault();
    // vdump($di);exit;
    /*if (!$di['request']->getPost('_nosession', null, false)) {
      $di['session']->start();
    }*/
    if (!is_readable(CFG.'cfg.php')) {
      throw new Exception('Error: configuration "zero Z" not found', 1);
    }
    $cfg = include_once CFG.'cfg.php';
    $di->setShared('config', $cfg);

    if (!is_readable(CFG.'loader.php')) {
      throw new Exception('Error: configuration "five" not found', 1);
    }
    $loader = include_once CFG.'loader.php';
    $di->setShared('loader', $loader);

    if (!is_readable(CFG.'router.php')) {
      throw new Exception('Error: configuration "three" not found', 1);
    }
    $router = include_once CFG.'router.php';
    $di->setShared('router', $router);

    if (!is_readable(CFG.'service.php')) {
      throw new Exception('Error: configuration "six" not found', 1);
    }
    include_once CFG.'service.php';

    // $client = new \ClickHouse\Client('http://10.156.230.185', 9000, null, 'scfbz');
    $Ycfg = [
        'host' => '10.156.230.185',
        'port' => 8123,
        // 'protocol' => 'http',
        'username' => 'default',
        'password' => 'scfbz',
      ];
      /*[],
      [
      ]
    );*/
    /*$client = new \ClickHouseDB\Client($Ycfg);

    vdump($client->select('SELECT 1')->rows());
    vdump($client->select('SHOW DATABASES')->rows());
    exit;*/
    $app = new Phalcon\Mvc\Application($di);
    $app->useImplicitView(false);

    $app->handle($cfg->uri);
    $app->response->send();
    // $app->tpl->display();

    // vdump($cfg->uri);
    /*

    new \Data\Service();
    \Data\User::init();

    $this->handle($this->config->uri);
    $this->tpl->display();*/

    // vdump(ini_get('session.save_path'));

    // vdump($di);

} catch (Exception $e) {
  vdump($e->getMessage());
}




// описание конфиг ошибок
//
// "zero" - localconfig
// "two" - application config
// "three" - router
// "four" - application router
// "four" - application router
// "five" - loader
// "six" - service
