<?php

class Positions_ListCommand extends AuthenticatedCommand
{
  public function run ( )
  {
    $beacons = Gateway_Base::factory('beacon')->findAll();
    $clients = Gateway_Base::factory('client')->findAll();
    $positions = Gateway_Base::factory('position')->findNewest();
    $GLOBALS['Smarty']->assign('Beacons',$beacons);
    $GLOBALS['Smarty']->assign('Clients',$clients);
    $GLOBALS['Smarty']->assign('Positions',$positions);
  }

}

?>
