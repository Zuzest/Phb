<?php
use Phalcon\Text;

class TaskBase extends \Phalcon\Cli\Task
{
  /**
   * [Создает модель из существующей таблицы]
   * @param  [string] $tableName [название таблицы]
   * @param  [string] $alias     [если название модели должно отличатся от названия таблицы]
   * @return [string]            [путь к файлу модели]
   */
  protected function createModel($tableName = null, $alias = null) {
    if(is_null($tableName) || !$this->db->tableExists($tableName)) {
      return false;
    }

    $file = $this->config->path->models;

    if($alias) {
      $modelName = ucfirst($alias);
    } else {
      $modelName = ucfirst($tableName);
    }

    $file .= $modelName.'.php';

    if($this->checkModel($modelName)) {
      return $file;
    }

    $authorName = exec('git config --get user.name');
    $authorEmail = exec('git config --get user.email');
    $createData = date('Y-m-d H:i:s');


    $modelClass = '<?php
namespace Models;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of '.$modelName.'
 *
 * Created '.$createData.'
 * @name "'.$authorName.'"
 * @email "'.$authorEmail.'"
 *
 * @author HRN
 */
class '.$modelName.' extends \ModelBase {
';

    $column = $this->db->describeColumns($tableName);
    $fields = [];
    $map = [];
    foreach($column as $col) {

      /*$type = $col->isNumeric()? 'numeric': 'string';
      $default = $col->getDefault();
      $hasDefault = $col->hasDefault();*/
      $name = $col->getName();

      $fields[] = (object)[
        'type' => $col->isNumeric()? 'numeric': 'string',
        'default' => $col->getDefault(),
        'hasDefault' => $col->hasDefault(),
        'name' => $name,
      ];

      $map[$name] = lcfirst(Text::camelize($name,'-_'));
    }

    foreach($fields as $field) {
      $field->name = $map[$field->name];
      $modelClass .= '
  /**';
      if($field->hasDefault) {
        $modelClass .= '
   * @default '.$field->default;
      }
      $modelClass .= '
   * @var '.$field->type.'
   */
  public $'.$field->name.';
';
    }

    $modelClass .= '
  public function columnMap() {
    return [';
    foreach($map as $field => $a) {
      $modelClass .= '
      \''.$field.'\' => \''.$a.'\',';
    }
    $modelClass .= '
    ];
  }
';
    if(array_key_exists('dt_create',$map) || array_key_exists('dt_update',$map)) {
      $modelClass .= '
  public static $skipFields = [';
      if(array_key_exists('dt_create',$map)) {
        $modelClass .= '
    \'dt_create\',';
      }
      if(array_key_exists('dt_update',$map)) {
        $modelClass .= '
    \'dt_update\',';
      }
      $modelClass .= '
  ];
';
    }

    if($alias) {
      $modelClass .= '
  public function getSource()
  {
    return \''.$tableName.'\';
  }
';
    }
    $modelClass .= '
}';
    file_put_contents($file, $modelClass);
    return $file;
  }

  /**
   * [проверяет существование модели по имени]
   * @param  [string] $modelName [имя модели]
   * @return [boolean]
   */
  protected function checkModel($modelName = null) {
    if(is_null($modelName)) {
      return false;
    }

    $file = $this->config->path->models;
    $file .= ucfirst($modelName).'.php';
    if(is_readable($file)) {
      return true;
    }
    return false;
  }

  /**
   * [проверяем существование поля в таблице]
   * @param  [string] $table [description]
   * @param  [string] $field [description]
   * @return [type]        [description]
   */
  protected function checkField($table = null, $field = null) {
    if(is_null($table) || is_null($field)) {
      return false;
    }
    if($this->db->tableExists($table)) {
      $column = $this->db->describeColumns($table);
      foreach($column as $col) {
        $name = $col->getName();
        if($field===$name) {
          return true;
        }
      }

    }
    return false;

  }

  /**
   * [_write description]
   * принимаем строку которую выводим в консоль с расцветкой
   * последовательность #цвет:цвет_фона:стиль$ заменяется на цветовые коды
   * #цвет$
   * #:цвет_фона$
   * #::стиль$
   * #:цвет_фона:стиль$
   * #цвет:цвет_фона$
   * #цвет::стиль$
   * #цвет:цвет_фона:стиль$
   * @param  [type] $msg [description]
   * @return [type]      [description]
   */
  protected function write(
    $msg = '',
    $br = PHP_EOL
  ) {
    $esc = "\033[";
    preg_match_all("~(#[\w,\w:\w]+)~", $msg, $out/*, PREG_SET_ORDER*/);
    // preg_match_all("~(#[\w,\w:\w]+\\$)~", $msg, $out/*, PREG_SET_ORDER*/);
    // vdump($msg, $out);

    $colors = [];
    foreach ($out[1] as $c) {
      $c = self::normalizeColors($c);
      $o = $c;

      $c = trim($c, '#');

      $c = explode(':', $c);

      $colors[$o] = $esc;
      $color      = $bgcolor      = $style      = '';
      $color      = isset(self::$fcolor[$c[0]]) ? self::$fcolor[$c[0]] : '';
      if (isset($c[1])) {
        $bgcolor = isset(self::$fbgcolor[$c[1]]) ? self::$fbgcolor[$c[1]] : '';
      }
      if (isset($c[2])) {
        $style = isset(self::$fstyle[$c[2]]) ? self::$fstyle[$c[2]] : '';
      }
      $c = [$bgcolor, $color, $style];
      foreach ($c as $k => $v) {
        if (empty($v)) {
          unset($c[$k]);
        }
      }
      $c = implode(';', $c);
      $colors[$o] .= $c.'m';

    }

    $txt = strtr($msg, $colors).$esc.'0m'.$br;
    echo $txt;
  }

  protected static function normalizeColors($color = false)
  {
    $color = ltrim($color, '#');
    $color = explode(':', $color);
    $end = array_pop($color);
    $cf = array_key_exists($end, self::$fcolor);
    $sf = array_key_exists($end, self::$fstyle);

    if ($cf || $sf) {
      // есть такой цвет или стиль
      // собираем строку для замены и возвращаем
      array_push($color, $end);
      return '#'.implode(':', $color);
    } else {
      // совпадений не найденно
      // надо определить
      foreach (self::$fcolor as $key => $value) {
        if (substr($end, 0, strlen($key)) == $key) {
          // нашли совападение
          // надо вернуть строку
          array_push($color, $key);

          return '#'.implode(':', $color);
        }
      }
      foreach (self::$fstyle as $key => $value) {
        if (substr($end, 0, strlen($key)) == $key) {
          // нашли совападение
          // надо вернуть строку
          array_push($color, $key);

          return '#'.implode(':', $color);
        }
      }
    }

    return '#'.implode(':', $color);
  }

  protected static $fcolor = [
    'gray'    => 30,
    'black'   => 30,
    'red'     => 31,
    'green'   => 32,
    'yellow'  => 33,
    'blue'    => 34,
    'magenta' => 35,
    'cyan'    => 36,
    'white'   => 37,
    'default' => 39,
  ];
  protected static $fbgcolor = [
    'gray'    => 40,
    'black'   => 40,
    'red'     => 41,
    'green'   => 42,
    'yellow'  => 43,
    'blue'    => 44,
    'magenta' => 45,
    'cyan'    => 46,
    'white'   => 47,
    'default' => 49,
  ];
  protected static $fstyle = [
    'default'          => '0',
    'bold'             => 1,
    'faint'            => 2,
    'normal'           => 22,
    'italic'           => 3,
    'notitalic'        => 23,
    'underlined'       => 4,
    'doubleunderlined' => 21,
    'notunderlined'    => 24,
    'blink'            => 5,
    'blinkfast'        => 6,
    'noblink'          => 25,
    'negative'         => 7,
    'positive'         => 27,
  ];
}
