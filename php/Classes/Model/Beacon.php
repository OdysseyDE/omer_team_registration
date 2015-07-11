<?php

class Beacon extends BaseClassWithID
{
  protected $kennung;
  protected $name;

  public function __construct ( $id = null, $kennung = null, $name = null )
  {
    parent::__construct($id);
    $this->kennung = $kennung;
    $this->name = $name;
  }

  public function __toString ( )
  {
    $parts = array();
    if ( $this->kennung > '' )
      $parts[] = $this->kennung;
    if ( $this->name > '' )
      $parts[] = $this->name;
    return implode(' / ',$parts);
  }
  
}

?>
