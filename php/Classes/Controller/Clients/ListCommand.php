<?php

class Clients_ListCommand extends AuthenticatedCommand
{
  public function run ( )
  {
    $clients = Gateway_Base::factory('client')->findAll();
    $GLOBALS['Smarty']->assign('Clients',$clients);
  }

}

?>
