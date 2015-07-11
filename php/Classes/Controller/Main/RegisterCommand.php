<?php

class Main_RegisterCommand extends Command
{
  public function run ( )
  {
    $this->handlePost();

    $code = "emailRepeat".rand(0,9999999999999);
    $_SESSION['code'] = $code;
    $GLOBALS['Smarty']->assign('repeat',$code);
  }

  private function handlePost ( )
  {
    if ( !isset($_POST['Auth']) )
      return;

    if ( $_POST['Auth']['emailRepeat'] != $_SESSION['code'] )
      return;

    Gateway_Base::factory('user')->create($_POST['Auth']['email'],hash('sha512',$_POST['Auth']['passwort']));

    $auth = new Authentication();
    $user = $auth->authenticate($_POST['Auth']['email'],hash('sha512',$_POST['Auth']['passwort']));
    if ( !isset($_SESSION['Authenticated']) )
      $_SESSION['Authentication'] = array();
    $_SESSION['Authentication']['User'] = $user;
    $_SESSION['Authentication']['LoggedIn'] = true;

    $this->redirect();
  }
  
}

?>
