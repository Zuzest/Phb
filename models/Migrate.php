<?php
namespace Models;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Migrate
 *
 * Created 2018-11-27 10:34:29
 * @name "Руслан Хорошкевич"
 * @email "russocomp.zezst@gmail.com"
 *
 * @author HRN
 */
class Migrate extends \ModelBase {

  /**
   * @var string
   */
  public $version;

  /**
   * @default current_timestamp()
   * @var string
   */
  public $applyTime;

  public function columnMap() {
    return [
      'version' => 'version',
      'apply_time' => 'applyTime',
    ];
  }

  public function getSource()
  {
    return 'tbl_migrate';
  }

}