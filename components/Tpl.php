<?php

class Tpl extends ComponentBase
{
  private static $instance;

  public function __construct()
  {
    // $this->tpl      = (object) $this->tpl;
    $this->tpl      = new \Phalcon\Config($this->tpl);
    self::$instance = $this;
  }

  public function __clone() {}

  public function __wakeup() {}

  public static function __callStatic(
    $name,
    $arg
  ) {
    if (is_null(self::$instance)) {
      new self();
    }
    // vdump($name, $arg);exit;
    if (method_exists(__CLASS__, $name)) {
      return call_user_func_array([self::$instance, $name], $arg);
      // return call_user_func_array([__CLASS__, $name], $arg);
    }
    throw new Exception('Unknow Method TPL::"'.$name, 1);

  }

  public function setDisplay(string $tpl = '') {
    if(!empty($tpl)) {
      $this->display = $tpl.'.tpl';
    }

  }
  public $display = 'index.tpl';
  /**
   * [display description]
   * @return [type] [description]
   */
  public function display()
  {
    // vdump($this->request->isAjax());

    // $this->sm->assign('assets', $this->assets);
    $this->smarty->registerObject('assets', $this->assets, null, false);
    // $this->smarty->registerClass('assets', '\Extend\AssetsManager');
    $this->smarty->assign('_meta', $this->tpl->meta);
    $this->smarty->assign('_breadcrumbs', F::getBreadcrumbs());
    $this->smarty->assign('_content', $this->getContent());
    $this->smarty->assign('_info', $this->info);
    // $this->smarty->registerObject('Tpl', DI::Tpl());
    // vdump($this->display);
    // vdump($this->config->application->toArray());
    $this->smarty->display($this->display);
  }

  private $tpl = [
    'meta' => [
      'title'       => 'Какойто сайт',
      'keywords'    => 'осторожно, админят, админ',
      'description' => 'Осторожно! Тут админят!!!',
      'h1'          => 'Главнючая страница админки',
    ],
  ];

  public $info = false;
  public function info($message = '') {
    $this->info = [
      'type' => 'primary',
      'message' => $message,
    ];
  }
  public function error($message = '') {
    $this->info = [
      'type' => 'error',
      'message' => $message,
    ];
  }
  public function success($message = '') {
    $this->info = [
      'type' => 'success',
      'message' => $message,
    ];
  }

  public function setContent($path = null)
  {
    if (is_null($path)) {
      $path = $this->router->getControllerName().'/'.$this->router->getActionName();
    }
    $this->tpl->content = $path.'.tpl';

    return true;
  }

  public function getContent()
  {
    if (!isset($this->tpl->content)) {
      return $this->router->getControllerName().'/'.$this->router->getActionName().'.tpl';
    }

    return $this->tpl->content;
  }

  public function setMeta($meta = []) {
    $this->tpl->meta = $meta;
  }

  public function setTitle($value = '') {
    $this->tpl->meta['title'] = $value;
  }

  public function getTitle() {
    // return self::$instance->tpl->meta['title'];
    return $this->tpl->meta['title'];
  }

  public function setKeywords($value = '') {
    $this->tpl->meta['keywords'] = $value;
  }

  public function getKeywords() {
    return $this->tpl->meta['keywords'];
  }

  public function setDescription($value = '') {
    $this->tpl->meta['description'] = $value;
  }

  public function getDescription() {
    return $this->tpl->meta['description'];
  }

  public function setH1($value = '') {
    $this->tpl->meta['h1'] = $value;
  }

  public function getH1($value = '') {
    return $this->tpl->meta['h1'];
  }

  /*public static function __callStatic($name, $arg) {
    vdump($name, $arg);
  }*/
  // public $breadcrumbs = false;
}
