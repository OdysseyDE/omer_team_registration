<?php

require_once __DIR__.'/../BaseTestCase.php';
require_once __DIR__.'/../../../Classes/Model/Position.php';

class PositionTest extends BaseTestCase
{
  public function testConstructor ( )
  {
    $position = new Position(1,2,3,'Far',100,new Zeitpunkt('2015-07-07 16:49:33'));
    $this->assertEquals(1,$position->id);
    $this->assertEquals(2,$position->beaconId);
    $this->assertEquals(3,$position->clientId);
    $this->assertEquals('Far',$position->distance);
    $this->assertEquals(100,$position->battery);
    $this->assertEquals(new Zeitpunkt('2015-07-07 16:49:33'),$position->timestamp);
  }

  public function testEmptyConstructor ( )
  {
    $position = new Position;
    $this->assertNull($position->id);
    $this->assertNull($position->beaconId);
    $this->assertNull($position->clientId);
    $this->assertNull($position->distance);
    $this->assertNull($position->battery);
    $this->assertNull($position->timestamp);
  }

}

?>
