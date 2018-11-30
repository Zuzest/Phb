<?php
// use Phalcon\Cli\Task;

class MigrateTask extends TaskBase
{
  private $methods = [
    'create' => [
    ],
    'up'     => [
    ],
    'down'   => [
    ],
    'list'   => [
    ],
  ];
  private $migratePath = null;
  public function mainAction(array $params)
  {
    $this->chekTableMigrate();
    $com               = 'list';
    $migrateName       = null;
    // vdump($this->config->path);
    $this->migratePath = $this->config->path->migrate;
    if (!empty($params)) {
      // пробуем вычленить команду
      $c = array_shift($params);
      if (array_key_exists($c, $this->methods)) {
        // команду распознали
        $com         = $c;
        $migrateName = array_shift($params);
      } else {
        // если не определили команду
        $com         = false;
        $migrateName = $c;
      }

      // $migratePath = $this->searchMigrate($migrateName);
      if (!$com) {
        // нет команды
        // пока по default
        $com = 'create';

        // проверяем наличие файла $migrateName;
        // vdump($this->checkFileMigrate($migrateName));exit;
        if ($this->checkFileMigrate($migrateName)) {
          // $this->write('#yellowМиграция #green'.$migrateName.'#yellow может быть установлена');
          $com = 'up';
        }
        if ($this->checkUpMigrate($migrateName)) {
          $com = 'down';
        }

      }

    }


    $method   = $com.'Method';
    $response = $this->{$method}($migrateName);

  }

  private function checkUpMigrate($migrateName)
  {
    $like       = 'm%_%_'.$migrateName;
    $conditions = 'version LIKE ?1';
    $bind       = [1 => $like];
    $Migrate    = \Models\Migrate::find([$conditions, 'bind' => $bind])->count();
    if ($Migrate) {
      return true;
    }

    return false;
  }

  private function getFileMigrate($migrateName = null)
  {
    if (is_null($migrateName)) {
      return false;
    }
    $migrateFiles = glob($this->migratePath.'m*_*_'.$migrateName.'.php');
    if (!$migrateFiles) {
      return false;
    }

    $file                  = (object) [];
    $file->fullPathName    = reset($migrateFiles);
    $file->fullFileName    = explode('/', $file->fullPathName);
    $file->fullFileName    = end($file->fullFileName);
    $file->migrateFullName = substr($file->fullFileName, 0, -strlen('.php'));
    $file->migrateName     = $migrateName;

    return $file;
  }

  private function checkFileMigrate($migrateName = null)
  {
    $migrateFile = $this->getFileMigrate($migrateName);
    if ($migrateFile) {
      return true;
    }

    return false;
  }

  private function getMigrateFullName($migrateFullName)
  {
    $conditions = 'version LIKE ?1';
    $bind       = [1 => $migrateFullName];
    $Migrate    = \Models\Migrate::find([$conditions, 'bind' => $bind])->getFirst();

    return $Migrate;
  }

  private function checkMigrate($migrateFileName) {}

  private function downMethod($migrateName = null)
  {
    $check = false;
    if (!is_null($migrateName)) {
      $check = $this->checkUpMigrate($migrateName);
    }

    if (!$check) {
      if ($this->checkFileMigrate($migrateName)) {

        $this->write('#red:yellowМиграция #green'.$migrateName.'#red еще не установлена');
        $this->write('#greenУстановить?:(y/n)');
        $key = false;
        while (true) {
          if ($key) {
            if ('y' === $key || 'yes' === $key) {
              return $this->upMethod($migrateName);
            }
            break;
          }
          $key = readline();
        }
      }

      return false;
    }

    $list = false;
    while (true) {
      if (!empty($migrateName)) {
        $migrateFile = $this->getFileMigrate($migrateName);
        if (!$migrateFile && !$list) {
          $this->write('#red:yellowМиграция #green'.$migrateName.'#red не найдена');
          $list = false;
        } else {
          break;
        }
      }
      $this->write('#greenУкажите название миграции:(#magentalist#default - вывести список)');
      $migrateName = readline();
      if ('exit' === $migrateName || 'q' === $migrateName) {
        exit($this->write('#yellow::negativeМиграция прервана'));
      }if ('list' === $migrateName) {
        $this->listMethod();
        $list        = true;
        $migrateName = null;
      }
    }
    $migrateObject = new $migrateFile->migrateFullName();

    if ($migrateObject->down()) {
      // все отлично
      $Migrate          = $this->getMigrateFullName($migrateFile->migrateFullName);
      $Migrate->version = $migrateFile->migrateFullName;
      if (!$Migrate->delete()) {
        $this->write();
        $msg = '#green:yellowМиграция#green '.$migrateName.' #green:yellowуотменена';
        $this->write($msg);
        $this->write('#green:yellowНо не удалось удалить запись.');
      }
    } else {
      $msg = '#white:red:blinkОткат миграции#green:default:noblink '.$migrateFile->migrateFullName.' #white:red:blinkне удался';
      $this->write($msg);
      return false;
    }
    return true;
  }

  private function upMethod($migrateName = null)
  {
    $check = false;
    if (!is_null($migrateName)) {
      $check = $this->checkUpMigrate($migrateName);
    }

    if ($check) {
      $this->write('#red:yellowМиграция #green'.$migrateName.'#red уже установлена');
      $this->write('#greenОтменить?:(y/n)');
      $key = false;
      while (true) {
        if ($key) {
          if ('y' === $key || 'yes' === $key) {
            return $this->downMethod($migrateName);
          }
          break;
        }
        $key = readline();
      }

      return false;
    }
    $list = false;
    while (true) {
      if (!empty($migrateName)) {
        $migrateFile = $this->getFileMigrate($migrateName);
        if (!$migrateFile && !$list) {
          $this->write('#red:yellowМиграция #green'.$migrateName.'#red не найдена');
          $list = false;
        } else {
          break;
        }
      }
      $this->write('#greenУкажите название миграции:(#magentalist#default - вывести список)');
      $migrateName = readline();
      if ('exit' === $migrateName || 'q' === $migrateName) {
        exit($this->write('#yellow::negativeМиграция прервана'));
      }if ('list' === $migrateName) {
        $this->listMethod();
        $list        = true;
        $migrateName = null;
      }
    }
    $migrateObject = new $migrateFile->migrateFullName();

    if ($migrateObject->up()) {
      // все отлично
      $Migrate          = new \Models\Migrate();
      $Migrate->version = $migrateFile->migrateFullName;
      if (!$Migrate->save()) {
        $this->write();
        $msg = '#green:yellowМиграция#green '.$migrateName.' #green:yellowустановлена';
        $this->write($msg);
        $this->write('#green:yellowНо не записанна.');
      }
    } else {
      $msg = '#white:red:blinkМиграция#green:default:noblink '.$migrateFile->migrateFullName.' #white:red:blinkне установлена';
      $this->write($msg);
      return false;
    }
    return true;
  }

  private function createMethod($migrateName)
  {
    while (true) {
      if (!empty($migrateName)) {
        $migrateFile = $this->checkFileMigrate($migrateName);
        if (!empty($migrateFile)) {
          $this->write('#red:yellowМиграция #green'.$migrateName.'#red уже существует');
        } else {
          // такой миграции еще нет
          break;
        }
      }

      $this->write('#yellow(CREATE)#greenУкажите название миграции:');
      $migrateName = readline();
      if ('exit' === $migrateName || 'q' === $migrateName) {
        exit($this->write('#yellow::negativeМиграция прервана'));
      }
    }

    $format   = 'm%y%m%d_%H%M%S_';
    $fileName = strftime($format).$migrateName;
    // $fileName = 'm'.date('ymd_His').'_'.$migrateName;

    $migrateClass = '<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of '.$fileName.'
 *
 * @author HRN
 */
class '.$fileName.' extends TaskBase {

  public function up() {
    return false;
  }


  public function down() {
    return false;
  }

}';
    file_put_contents($this->migratePath.$fileName.'.php', $migrateClass);
    $this->write('#greenМиграция #green:yellow'.$fileName.'.php#green:default успешно создана!');
    return true;
  }

  private function listMethod()
  {
    $migrateFiles = glob($this->migratePath.'m*_*_*.php');
    // $this->write('#greenТут надо показать список');
    $list = [];
    foreach ($migrateFiles as $file) {
      $file            = explode('/', $file);
      $fileName        = end($file);
      $migrateFullName = substr($fileName, 0, strlen($fileName) - strlen('.php'));

      if ($this->getMigrateFullName($migrateFullName)) {
        // эта миграция установлена, переходим к следующей
        continue;
      }
      $file = explode('_', $migrateFullName);


      $stringFormat = sscanf($file[0], 'm%2s%2s%2s');
      $date         = implode('-', $stringFormat);
      $stringFormat = sscanf($file[1], '%2s%2s%2s');
      $date .= ' '.implode(':', $stringFormat);

      unset($file[0]);
      unset($file[1]);
      $migrateName = implode('_',$file);
      // $migrateName = end($file);

      $list[] = $date."#green\t".$migrateName;
    }

    if ($list) {
      $this->write('#greenМиграции доступные для установки');
      foreach ($list as $row) {
        $this->write($row);
      }

      return true;
    }
    $this->write('#green:yellowКаталог миграций пуст');

    return false;
  }

  private function searchMigrate($migrateName)
  {
    if (is_null($migrateName)) {
      return false;
    }
    $migrateFiles = glob($this->migratePath.'m*_*_'.$migrateName.'.php');
    if (!$migrateFiles) {
      return false;
    }
    // vdump($this->migratePath, $migrateFiles);

    $f           = (object) [];
    $f->fullName = reset($migrateFiles);
    $fname       = explode('/', $f->fullName);
    $f->fileName = end($fname);
    $f->name     = substr($f->fileName, 0, -strlen('.php'));

    return $f;

  }

  public function chekTableMigrate()
  {
    // vdump($this->db);
    $result = $this->db->tableExists('tbl_migrate');
    if (!$result) {
      // иначе надо создать
      $sql = 'CREATE TABLE `tbl_migrate` (
          `version` VARCHAR(255) NOT NULL COMMENT "номер версии миграции",
          `apply_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "время активации миграции",
          PRIMARY KEY (`version`),
          UNIQUE INDEX `version` (`version`)
        )
        ENGINE=InnoDB
      ;';
      $result = $this->db->query($sql);
      if (!$result) {
        $this->write('#white:red:blinkЧто то пошло не так');
        $this->write('#white:red:blink'.__METHOD__);
        exit;
      }

      $this->createModel('tbl_migrate', 'migrate');
      // TODO: создать модель
    }

    // таблица есть

    return true;
  }
}
