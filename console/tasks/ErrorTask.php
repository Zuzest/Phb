<?php

class ErrorTask extends TaskBase
{
  public function mainAction()
  {
    $this->write('#white:red:blinkКоманда не распознана!!!');
    // $this->write('#white:red:blinkНеизвестная команда!!!');
  }
}
