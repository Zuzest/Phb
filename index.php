<?php

// блок констант
define('ROOT', dirname(__FILE__).'/');
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
  if(CLI) {
    throw new Exception('Error: this is not a CLI application', 1);
  }

  (new \Phalcon\Loader())
    ->registerDirs([ROOT.'kernel/'])
    ->register();

  new CFG(ROOT.'local.cfg.php');

  new DI(CFG::DIR.'web.service.php');
  DI::setShared('config', CFG::getSelf());

  $uri = explode('/', DI::Request()->getUrlPath());
  if(array_key_exists($uri[1], CFG::Application()->accessUri)) {
    CFG::Application()->name = CFG::Application()->accessUri[$uri[1]];
    unset($uri[1]);
    $uri = implode('/', $uri)
      .(empty(DI::Request()->getUrlQuery())? '': '?'.DI::Request()->getUrlQuery());
    DI::Request()->setURI($uri);
  }
  // утсанавливаем путь к приложению
  CFG::Application()->path = ROOT.CFG::Application()
    ->pathList[CFG::Application()->name];
  define('APP_DIR', CFG::Application()->path);

  // догружаем/перезаписываем сервисы приложения
  /*if (is_readable(APP_DIR.'config/web.service.php')) {
    DI::LoadFromPhp(APP_DIR.'config/web.service.php');
  }*/

  // догружаем базовый конфиг
  CFG::merge(include_once CFG::DIR.'cfg.php');

  // догружаем конфиг приложения
  if (is_readable(APP_DIR.'config/cfg.php')) {
    CFG::merge(include_once APP_DIR.'config/cfg.php');
  }

  // подготавливаем загрузчик
  if (is_readable(CFG::DIR.'loader.php')) {
    // throw new Exception('Error: configuration "five" not found', 1);
    DI::setShared('loader', include_once CFG::DIR.'loader.php');
  }

  if (!DI::Request()->getPost('_nosession', null, false)) {
    DI::Session()->start();
  }

  if (!is_readable(CFG::DIR.'router.php')) {
    throw new Exception('Error: configuration "three" not found', 1);
  }
  include_once CFG::DIR.'router.php';
  // DI::setShared('router', include_once CFG::DIR.'router.php');

  if (!is_readable(CFG::DIR.'service.php')) {
    throw new Exception('Error: configuration "six" not found', 1);
  }
  include_once CFG::DIR.'service.php';

  $app = new \Phalcon\Mvc\Application(DI::getSelf());
  $app->useImplicitView(false);
  $app->handle();
  $app->tpl->display();


} catch (Exception $e) {
  vdump($e->getMessage());
  vdump(debug_backtrace());
}

    /*// получаем пользователя
    $info = posix_getpwuid(posix_getuid());
    $login = $info['name'];
    vdump($login, $info);exit;*/



// описание конфиг ошибок
//
// "zero" - localconfig
// "two" - application config
// "three" - router
// "four" - application router
// "four" - application router
// "five" - loader
// "six" - service
