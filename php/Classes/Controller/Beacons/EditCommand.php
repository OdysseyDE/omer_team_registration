<?php

class Beacons_EditCommand extends AuthenticatedCommand
{
  public function run ( )
  {
    if ( ($beacon = Gateway_Base::factory('beacon')->findOne($_REQUEST['Id'])) === false )
      $beacon = new Beacon;

    if ( isset($_POST['Beacon']) )
      {
        $beacon->attributes = $_POST['Beacon'];
        Gateway_Base::factory('beacon')->update($beacon);
        $this->success();
        $this->redirect('Beacons','List');
      }

    $GLOBALS['Smarty']->assign('Beacon',$beacon);
  }
  
}

?>
