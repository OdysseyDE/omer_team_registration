<?php

class Main_NotFoundCommand extends Command
{
  private $class;

  public function __construct ( $class )
  {
    $this->class = $class;
  }

  public function run ( )
  {
    throw new Exception("Die Klasse ".$this->class." kann nicht geladen werden.");
  }

}

?>
