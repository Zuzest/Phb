<?php

namespace Extend;

class Smarty extends \Smarty  {

  public function __construct() {
    parent::__construct();
    $template = \CFG::Application()->viewsDir;
    if (isset(\CFG::Application()->viewsDirMobile) && \DI::Elements()->isMobile()) {
      $template = \CFG::Application()->viewsDirMobile;
    }

    $this->setTemplateDir($template);
    $this->setCompileDir(\CFG::Plugins()->smarty->compileDir);

    return $this;
  }
}