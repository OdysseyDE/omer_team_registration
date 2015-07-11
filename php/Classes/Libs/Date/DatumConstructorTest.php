<?php

require_once 'Datum.php';

class DatumConstructorTest extends PHPUnit_Framework_TestCase 
{
  public function testDeutsch2 ( ) 
  {
    $datum = new Datum('14.07.09');
    $this->assertEquals("2009-07-14",$datum->__toString());
  }

  public function testEinTagInDerZunkunft ( )
  {
    $morgenOhneJahr = date('d.m',time() + 24 * 3600);
    $morgenMitJahr = date('d.m.Y',time() + 24 * 3600);
    $datum = new Datum($morgenOhneJahr);
    $this->assertEquals($morgenMitJahr,$datum->format('d.m.Y'));
  }

  public function testEinTagInDerVergangenheit ( )
  {
    $gesternOhneJahr = date('d.m',time() - 24 * 3600);
    $gesternMitJahr = date('d.m.Y',time() - 24 * 3600);
    $datum = new Datum($gesternOhneJahr);
    $this->assertEquals($gesternMitJahr,$datum->format('d.m.Y'));
  }

  public function test180TageInDerZunkunft ( )
  {
    $ohneJahr = date('d.m',time() + 181 * 24 * 3600);
    $richtigesJahr = date('Y');
    if ( Datum::toDay()->month() < 7 )
      $richtigesJahr -= 1;
    $datum = new Datum($ohneJahr);
    $this->assertEquals($ohneJahr.'.'.$richtigesJahr,$datum->format('d.m.Y'));
  }

}

?>
