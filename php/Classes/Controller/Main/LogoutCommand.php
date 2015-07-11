<?php

class Main_LogoutCommand extends Command
{
  public function Run ( )
  {
    $_SESSION['Authentication']['LoggedIn'] = false;
    $this->redirect();
  }


}

?>
