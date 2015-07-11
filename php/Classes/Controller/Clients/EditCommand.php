<?php

class Clients_EditCommand extends AuthenticatedCommand
{
  public function run ( )
  {
    if ( ($client = Gateway_Base::factory('client')->findOne($_REQUEST['Id'])) === false )
      $client = new Client;

    if ( isset($_POST['Client']) )
      {
        $client->attributes = $_POST['Client'];
        Gateway_Base::factory('client')->update($client);
        $this->success();
        $this->redirect('Clients','List');
      }

    $GLOBALS['Smarty']->assign('Client',$client);
  }
  
}

?>
