<?php

class Main_IndexCommand extends AuthenticatedCommand
{
  public function run ( )
  {
    $this->redirect('Mannschaften','List');
  }

}

?>
