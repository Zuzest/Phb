<?php

if(\CFG::Plugins()->clickhouse->autoloadPath) {
  include_once \CFG::Plugins()->clickhouse->autoloadPath;
}

$loader = new \Extend\Loader();
$loader->registerDirs([
  CFG::application()->controllersDir,
  CFG::application()->componentsDir,
  CFG::application()->modelsDir,
  APP_DIR,
  // $cfg->path->toArray(),
]);

$loader->registerNamespaces(CFG::namespaces()->toArray());

$loader->registerClasses([
  'Smarty' => CFG::plugins()->smarty->class,
]);

// если есть специфические правила приложения то подключаем их
if(is_readable(APP_DIR.'config/loader.php')) {
  include_once APP_DIR.'config/loader.php';
}

$loader->register();

return $loader;