<?php

namespace Extend;

class AssetsManager extends \Phalcon\Assets\Manager {
  public function __construct($options = null) {
    parent::__construct($options);
    $this->useImplicitOutput(false);

    $this->config = \CFG::Assets();
  }

  public function initBase()
  {

    if ($this->resource->css->base) {
      $collection = $this->collection('baseCss');
      foreach ($this->resource->css->base as $res) {
        $pathFile = $this->sourcePath.'css/'.$res.'.css';
        $collection->addCss($pathFile);
      }
      $collection->join(true);
      $collection->addFilter(new \Phalcon\Assets\Filters\Cssmin());
    }

    if ($this->resource->js->base) {
      $collection = $this->collection('baseJs');
      foreach ($this->resource->js->base as $res) {
        $pathFile = APP_DIR.'js/'.$res.'.js';
        $collection->addJs($pathFile);

      }
      $collection->join(true);
      $collection->addFilter(new \Phalcon\Assets\Filters\Jsmin());
    }
  }

  public function resetCssList()
  {
    $this->config->resource->css = (object) [];

    return $this;
  }

  public function getCssList()
  {
    return $this->config->resource->css;
  }

  public function setCssList(array $list = [])
  {
    $this->config->resource->css = (object) $list;

    return $this;
  }

  public function css($css) {
    $_css = (array) $this->config->resource->css;
    // vdump($_css);
    $css = is_array($css)? $css: (array) $css;
    foreach ($css as $css_) {
      array_push($_css, $css_);
    }
    // $_css[] = $css;
    // vdump($_css);
    $this->config->resource->css = (object) $_css;
    return $this;
  }

  public function resetJsList()
  {
    $this->config->resource->js = (object) [];

    return $this;
  }

  public function getJsList()
  {
    return $this->config->resource->js;
  }

  public function setJsList(array $list = [])
  {
    $this->config->resource->js = (object) $list;

    return $this;
  }

  public function js($js) {
    $_js = (array) $this->config->resource->js;
    // vdump($_css);
    $js = is_array($js)? $js: (array) $js;
    foreach ($js as $js_) {
      array_push($_js, $js_);
    }
    // $_css[] = $css;
    // vdump($_css);
    $this->config->resource->js = (object) $_js;
    return $this;
  }

  /**
   * [setSourcePath description]
   * @param [type] $path [description]
   */
  public function setSourcePath($path = null)
  {
    if (is_null($path)) {
      return false;
    }
    $this->config->sourcePath = $path;

    return true;
  }

  public function getSourcePath()
  {

    return $this->config->sourcePath;
  }

  public function getCss($collection = 'base')
  {
    // vdump($collection);
    // $collection = $this->collection(/*$collection.*/'baseCSS');
    $collection = $this->collection($collection.'CSS');
    // vdump($collection);
    // vdump($this->config->resource->css);
    foreach($this->config->resource->css as $name) {
      $pathFile = $this->config->sourcePath.'css/'.$name.'.css';
      $collection->addCss($pathFile);
    }
    $collection->join(true)->addFilter(new \Phalcon\Assets\Filters\Cssmin());

    $resources = $collection->getResources();
    if (empty($resources)) {
      return '';
    }

    // получаем имя коллекции
    $secretPath = '';
    foreach ($resources as $resource) {
      $secretPath .= $resource->getResourceKey();
    // vdump($secretPath);
    }
    // vdump($resources, $secretPath);
    $fileName = md5($secretPath).'.css'; // название обобщенного файла

    $pathToFile = $this->config->targetPath.$fileName; // полный путь к файлу

    // vdump($pathToFile);
    // vdump(defined('DEV'));exit;
    if (is_readable($pathToFile)) {
      if (!defined('DEV') || !DEV) {
        $link = '<link rel="stylesheet" type="text/css" href="'.$this->targetUri.$fileName.'" />';

        return $link;
      }

    }

    // Получаем фильтры применяемые к коллекции
    $filters = $collection->getFilters();

    $contents = [];
    foreach ($resources as $key => $resource) {
      try {
        $contents[$resource->getPath()] = $resource->getContent();
      } catch (Exception $e) {
        // TODO: логировать ошибку
        continue;
      }
    }
    // vdump($contents);exit;
    // на текущий момент считаем что стили должны быть слиты в один файл
    // без исключений
    // vdump($filters, $contents);exit;

    if (defined('DEV') || DEV) {
      $content = '';
      foreach ($contents as $k => $v) {
        $content .= '/*  '. $k . '  */' . PHP_EOL;
        // $content .= $this->getFiltered($v, $filters);
        $content .= $v;
        $content .= '/*  end '. $k . '  */' . PHP_EOL;
      }
    } else {
      $content = implode('', $contents);
      // и отфильрованы
      $content = $this->getFiltered($content, $filters);
    }


    file_put_contents($pathToFile, $content);
    chmod($pathToFile, 0664);
    if (!is_readable($pathToFile)) {
      // TODO: добавить логирование
      return '';
    }

    $link = '<link rel="stylesheet" type="text/css" href="'.$this->config->targetUri.$fileName.'" />';

    return $link;

  }

  public function getJs($collection = 'base')
  {
    $collection = $this->collection($collection.'JS');
    foreach($this->config->resource->js as $name) {
      $pathFile = $this->config->sourcePath.'js/'.$name.'.js';
      $collection->addJs($pathFile);
    }
    $collection->join(true)->addFilter(new \Phalcon\Assets\Filters\Jsmin());

    $resources = $collection->getResources();
    if (empty($resources)) {
      return '';
    }

    // получаем имя коллекции
    $secretPath = '';
    foreach ($resources as $resource) {
      $secretPath .= $resource->getResourceKey();
    }
    $fileName = md5($secretPath).'.js'; // название обобщенного файла

    $pathToFile = $this->config->targetPath.$fileName; // полный путь к файлу

    // vdump(defined('DEV'));exit;
    if (is_readable($pathToFile)) {
      if (!defined('DEV') || !DEV) {
        // $link = '<link rel="stylesheet" type="text/css" href="'.$this->targetUri.$fileName.'" />';
        $link = '<script src="'.$this->config->targetUri.$fileName.'"></script>';

        return $link;
        // vdump(defined('DEV'));exit;
      }

    }

    // Получаем фильтры применяемые к коллекции
    $filters = $collection->getFilters();

    $contents = [];
    foreach ($resources as $key => $resource) {
      try {
        $contents[] = $resource->getContent();
      } catch (Exception $e) {
        // TODO: логировать ошибку
        continue;
      }
    }
    // vdump($contents);exit;
    // на текущий момент считаем что стили должны быть слиты в один файл
    // без исключений
    $content = implode('', $contents);
    // и отфильрованы
    $content = $this->getFiltered($content, $filters);

    file_put_contents($pathToFile, $content);
    chmod($pathToFile, 0664);
    if (!is_readable($pathToFile)) {
      // TODO: добавить лигирование
      return '';
    }

    $link = '<script src="'.$this->config->targetUri.$fileName.'"></script>';

    return $link;

  }

  public function getFiltered(
    $content,
    $filters
  ) {
    foreach ($filters as $filter) {
      $content = $filter->filter($content);
    }

    return $content;
  }

  public $collectionCss = 'base';
  public $collectionJs  = 'base';

  /**
   * [$typeCollection список допустимых типов коллекций]
   * @var [string]
   */
  public $typeCollection = [
    'css', 'js',
  ];

  public function setCollection(
    $collection = 'baseCss',
    $type = 'css'
  ) {
    if (!in_array($type, $this->typeCollection)) {
      return false;
    }

    $varCollection        = 'collection'.ucfirst($type);
    $this->$varCollection = $collection;

    return $this;

  }

  public function getCollection(
    $type = 'css'
  ) {
    if (!in_array($type, $this->typeCollection)) {
      return false;
    }

    $varCollection = 'collection'.ucfirst($type);

    return $this->$varCollection;
  }

  /**
   * [setCssCollection установить название коллекции]
   * @param [type] $collection [description]
   */
  public function setCssCollection($collection = null)
  {
    return $this->setCollection($collection, 'css');
  }

  /**
   * [setJsCollection установить название коллекции]
   * @param [type] $collection [description]
   */
  public function setJsCollection($collection = null)
  {
    return $this->setCollection($collection, 'js');
  }

  /**
   * [getCssCollection получить текущю коллекцию]
   * @return [type] [названию коллекцию]
   */
  public function getCssCollection()
  {
    return $this->getCollection('css');
  }

  /**
   * [getJsCollection получить текущю коллекцию]
   * @return [type] [названию коллекцию]
   */
  public function getJsCollection()
  {
    return $this->getCollection('js');
  }

  /**
   * [cssAdd добавить css-файл в коллекцию]
   * @param  [type] $fileName [название файла, без расширения]
   * @return [type]           [description]
   */
  public function cssAdd_($fileName = null)
  {
    if (!is_null($fileName) || (is_array($fileName) || is_string($fileName))) {
      $fileName = is_string($fileName) ? (array) $fileName : $fileName;

      foreach ($fileName as $name) {
        $pathFile   = $this->sourcePath.'css/'.$name.'.css';
        $collection = $this->collection($this->collectionCss);
        $collection->addCss($pathFile);
      }

      return $this;
    }

    return false;

  }

  /**
   * [jsAdd добавить js-файл в коллекцию]
   * @param  [type] $fileName [название файла, без расширения]
   * @return [type]           [description]
   */
  public function jsAdd_($fileName = null)
  {
    if (!is_null($fileName) || (is_array($fileName) || is_string($fileName))) {
      $fileName = is_string($fileName) ? (array) $fileName : $fileName;

      foreach ($fileName as $name) {
        $pathFile   = $this->sourcePath.'js/'.$name.'.js';
        $collection = $this->collection($this->collectionJs);
        $collection->addCss($pathFile);
      }

      return $this;

    }

    return false;
  }
}