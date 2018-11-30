<?php
// use Phalcon\Cli\Task;

class ModelTask extends TaskBase
{

  public function mainAction(array $params)
  {
    $com               = 'create';
    $tableName = array_shift($params);
    $modelName = array_shift($params);
    if(is_null($tableName)) {
      $this->write('#redНеобходимо указать название таблицы');
      return;
    }
    if(!$this->db->tableExists($tableName)) {
      $this->write('#green'.$tableName.' #redне найдена');
      return;
    }

    if(is_null($modelName)) {
      $check = $this->checkModel($tableName);
      $name = $tableName;
    } else {
      $check = $this->checkModel($modelName);
      $name = $modelName;
    }

    if($check) {
      $this->write('#redМодель #green'.$name.' #red уже существует');
      return;
    }

    $result = $this->createModel($tableName, $modelName);
    if(!$result) {
      $this->write('#redНе получилось создать модель #green'.$name);
      return;
    }

    $this->write('#:greenМодель#green:default '.$name.' #default:greenуспешно создана');

  }
}
