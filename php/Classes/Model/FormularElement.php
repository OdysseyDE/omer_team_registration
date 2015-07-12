<?php

class FormularElement extends BaseClassWithID
{
  protected $label;
  protected $typ;
  protected $required;

  public function __construct ( $id = null, $label = null, $typ = null, $required = false )
  {
    parent::__construct($id);

    $this->addConversion('required','bool');

    $this->label = $label;
    $this->typ = $typ;
    $this->required = (bool)$required;
  }
  
}

?>
