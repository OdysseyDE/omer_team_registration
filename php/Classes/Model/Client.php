<?php

class Client extends BaseClassWithID
{
  protected $clientId;
  protected $name;

  public function __construct ( $id = null, $clientId = null, $name = null )
  {
    parent::__construct($id);
    $this->clientId = $clientId;
    $this->name = $name;
  }
  
  public function __toString ( )
  {
    $parts = array();
    if ( $this->clientId > '' )
      $parts[] = $this->clientId;
    if ( $this->name > '' )
      $parts[] = $this->name;
    return implode(' / ',$parts);
  }
  
}

?>
