<?php

class Authentication
{
  public function Authenticate ( $username, $password )
  {
    // Default: Authentication through DB
    // implement other methods here
    return Gateway_Base::factory('user')->authenticate($username,$password);
  }


}

?>
