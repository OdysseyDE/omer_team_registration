<?php

require_once 'Bundesland.php';

class BundeslandTest extends PHPUnit_Framework_TestCase 
{
  private $bundesland;

  protected function setUp ( )
  {
    $this->bundesland = new Bundesland('BB','Brandenburg');
  }

  public function testName ( )
  {
    $this->assertEquals('Brandenburg',$this->bundesland->Name());
  }

  public function testAbbreviation ( )
  {
    $this->assertEquals('BB',$this->bundesland->Abbreviation());
  }

  public function testToString ( )
  {
    $this->assertEquals("Brandenburg (BB)",(string)$this->bundesland);
  }

}

?>
