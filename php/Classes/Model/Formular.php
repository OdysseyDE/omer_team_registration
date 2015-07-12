<?php

class Formular extends BaseClassWithID
{
  protected $name;
  protected $elemente;
  
  public function __construct ( $id = null, $name = null )
  {
    parent::__construct($id);

    $this->addNoSet('elemente');
    
    $this->name = $name;
    $this->elemente = array();
  }

  public function addElement ( FormularElement $element )
  {
    $this->elemente[$element->id] = $element;
  }
  
  public function __toString ( )
  {
    return (string)$this->name;
  }
  
}

?>
