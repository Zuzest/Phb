<?php

if (is_readable(APP_DIR.'config/service.php')) {
  // throw new Exception('Error: configuration "six" not found', 1);
  include_once CFG::DIR.'service.php';
}