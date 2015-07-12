<?php

class Formular extends BaseClassWithID
{
  protected $name;
  
  public function __construct ( $id = null, $name = null )
  {
    parent::__construct($id);

    $this->name = $name;
  }

  public function __toString ( )
  {
    return (string)$this->name;
  }
  
}

?>
