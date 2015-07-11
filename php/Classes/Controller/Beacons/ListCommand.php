<?php

class Beacons_ListCommand extends AuthenticatedCommand
{
  public function run ( )
  {
    $beacons = Gateway_Base::factory('beacon')->findAll();
    $GLOBALS['Smarty']->assign('Beacons',$beacons);
  }

}

?>
