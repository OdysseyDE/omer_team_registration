<?php

require_once __DIR__.'/../BaseTestCase.php';
require_once __DIR__.'/../../../Classes/Model/Beacon.php';

class BeaconTest extends BaseTestCase
{
  public function testConstructor ( )
  {
    $beacon = new Beacon(1,'kennung','name');
    $this->assertEquals(1,$beacon->id);
    $this->assertEquals('kennung',$beacon->kennung);
    $this->assertEquals('name',$beacon->name);
    $this->assertEquals('kennung / name',$beacon->__toString());
  }
  
  public function testEmptyConstructor ( )
  {
    $beacon = new Beacon;
    $this->assertNull($beacon->id);
    $this->assertNull($beacon->kennung);
    $this->assertNull($beacon->name);
    $this->assertEquals('',$beacon->__toString());
  }

  public function testHalberToString ( )
  {
    $beacon = new Beacon(null,'kennung');
    $this->assertEquals('kennung',$beacon->__toString());

    $beacon = new Beacon(null,null,'name');
    $this->assertEquals('name',$beacon->__toString());
  }
  
}

?>
