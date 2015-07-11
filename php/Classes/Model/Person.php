<?php

class Person extends BaseClassWithID
{
  protected $vorname;
  protected $name;
  protected $email;

  public function __construct ( $id = null, $vorname = null, $name = null, $email = null )
  {
    parent::__construct($id);
    $this->vorname = $vorname;
    $this->name = $name;
    $this->email = $email;
  }

  public function __toString ( )
  {
    $parts = array();
    if ( $this->vorname > '' )
      $parts[] = $this->vorname;
    if ( $this->name > '' )
      $parts[] = $this->name;
    return implode(' ',$parts);
  }
  
}

?>
