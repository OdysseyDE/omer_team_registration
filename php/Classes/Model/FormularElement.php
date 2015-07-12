<?php

class FormularElement extends BaseClassWithID
{
  protected $label;
  protected $typ;
  protected $required;
  protected $placeholder;
  
  public function __construct ( $id = null, $label = null, $typ = null, $required = false, $placeholder = null )
  {
    parent::__construct($id);

    $this->addConversion('required','bool');

    $this->label = $label;
    $this->typ = $typ;
    $this->required = (bool)$required;
    $this->placeholder = $placeholder;
  }
  
}

?>
