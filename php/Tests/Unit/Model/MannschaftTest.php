<?php

require_once __DIR__.'/../BaseTestCase.php';
require_once __DIR__.'/../../../Classes/Model/Mannschaft.php';

class MannschaftTest extends BaseTestCase
{
  public function testConstructor ( )
  {
    $mannschaft = new Mannschaft(1,'name','schule','problem','altersgruppe');
    $this->assertEquals(1,$mannschaft->id);
    $this->assertEquals('name',$mannschaft->name);
    $this->assertEquals('schule',$mannschaft->schule);
    $this->assertEquals('altersgruppe',$mannschaft->altersgruppe);
    $this->assertEquals('name - schule',$mannschaft->__toString());
  }

  public function testEmptyConstructor ( )
  {
    $mannschaft = new Mannschaft;
    $this->assertNull($mannschaft->id);
    $this->assertNull($mannschaft->name);
    $this->assertNull($mannschaft->schule);
    $this->assertNull($mannschaft->altersgruppe);
    $this->assertEquals('',$mannschaft->__toString());
  }

}

?>
