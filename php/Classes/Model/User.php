<?php

class User extends BaseClassWithID
{
  protected $email;

  public function __construct ( $id = null, $email = null )
  {
    parent::__construct($id);
    $this->email = $email;
  }

  public function __toString ( )
  {
    return $this->email;
  }

}

?>
