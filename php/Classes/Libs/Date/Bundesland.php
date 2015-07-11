<?php

class Bundesland
{
  protected $abbrev;
  protected $name;


  public function __construct ( $abbrev, $name )
  {
    $this->abbrev = $abbrev;
    $this->name = $name;
  }


  public function __toString ( )
  {
    return sprintf('%s (%s)',$this->name,$this->abbrev);
  }


  public function Abbreviation ( )
  {
    return $this->abbrev;
  }


  public function Name ( )
  {
    return $this->name;
  }


}

?>
