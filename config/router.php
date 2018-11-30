<?php

DI::Router()->add("/", [
  'controller' => 'index',
  'action' => 'index',
]);

DI::Router()->add("/user/", [
  'controller' => 'user',
  'action' => 'index',
]);

// если есть специфические правила для приложения то подключаем их
if(is_readable(APP_DIR.'config/router.php')) {
  // throw new Exception('Error: configuration "four" not found', 1);
  include_once APP_DIR.'config/router.php';
}

DI::Router()->setDefaults([
  'controller' => 'index',
  'action' => 'error'
]);
