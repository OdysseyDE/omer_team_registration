<?php

class Mannschaften_EditCommand extends AuthenticatedCommand
{
  public function run ( )
  {
    if ( ($mannschaft = Gateway_Base::factory('mannschaft')->findOne($_REQUEST['Id'])) === false )
      $mannschaft = new Mannschaft;
    
    $GLOBALS['Smarty']->assign('Mannschaft',$mannschaft);
  }
  
}

?>
