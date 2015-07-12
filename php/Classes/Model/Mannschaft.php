<?php

class Mannschaft extends BaseClassWithID
{
  protected $name;
  protected $schule;
  protected $altersgruppe;

  public function __construct ( $id = null, $name = null, $schule = null, $altersgruppe = null )
  {
    parent::__construct($id);

    $this->name = $name;
    $this->schule = $schule;
    $this->altersgruppe = $altersgruppe;
  }

  public function __toString ( )
  {
    $parts = array();
    if ( $this->name > '' )
      $parts[] = $this->name;
    if ( $this->schule > '' )
      $parts[] = $this->schule;
    return implode(' - ',$parts);
  }
  
  
}

?>
