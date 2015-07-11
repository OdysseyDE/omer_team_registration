<?php

class Positions_EditCommand extends AuthenticatedCommand
{
  public function run ( )
  {
    $beacons = Gateway_Base::factory('beacon')->findAll();
    $clients = Gateway_Base::factory('client')->findAll();

    if ( isset($_POST['Position']) )
      {
        $position = new Position(null,
                                 $_POST['Position']['beacon'],
                                 $_POST['Position']['client'],
                                 $_POST['Position']['distance'],
                                 (float)str_replace(",",".",str_replace(".","",$_POST['Position']['battery'])),
                                 Zeitpunkt::now());
        Gateway_Base::factory('position')->update($position);
        $this->success();
        $this->redirect();
      }
    
    $GLOBALS['Smarty']->assign('Beacons',$beacons);
    $GLOBALS['Smarty']->assign('Clients',$clients);
  }

}

?>
