<?php

abstract class AuthenticatedCommand extends Command
{
  public function __construct ( )
  {
    if ( isset($_POST['Login']) )
      $this->authenticate();
    
    if ( !isset($_SESSION['Authentication']) || !$_SESSION['Authentication']['LoggedIn'] )
      $this->showLoginScreen();

    $GLOBALS['Smarty']->assign('LoggedIn',$_SESSION['Authentication']['LoggedIn']);
    $GLOBALS['Smarty']->assign('User',$_SESSION['Authentication']['User']);
  }

  protected function authenticate ( )
  {
    $auth = new Authentication();
    if ( ($user = $auth->authenticate($_POST['Login']['Username'],hash('sha512',$_POST['Login']['Password']))) !== false )
      {
        if ( !isset($_SESSION['Authenticated']) )
          $_SESSION['Authentication'] = array();
        $_SESSION['Authentication']['User'] = $user;
        $_SESSION['Authentication']['LoggedIn'] = true;
      }
    else
      $GLOBALS['Smarty']->assign('errormessage','Login fehlgeschlagen');
  }

  protected function showLoginScreen ( )
  {
    $GLOBALS['Smarty']->assign('return',"page=".$GLOBALS['Where']['Page']."&amp;action=".$GLOBALS['Where']['Action']);
    $this->display('Authentication','Login');
    die();
  }

}

?>
