<?php

require_once 'Zeit.php';
require_once 'DatumException.php';

class ZeitTest extends PHPUnit_Framework_TestCase 
{
  private $time;

  public function setUp ( )
  {
    $this->time = new Zeit("09:18:33");
  }

  public function testConstructor ( ) 
  {
    $this->SetExpectedException("DatumException");
    $time = new Zeit("");
  }

  public function testConstructor2 ( ) 
  {
    $this->assertEquals(new Zeit('00:00:00'),new Zeit('24:00:00'));
  }

  public function testConstructor3 ( ) 
  {
    $this->assertEquals(new Zeit(33513),$this->time);
  }

  public function testToString ( ) 
  {
    $this->assertEquals("09:18:33",$this->time->__toString());
  }

  public function testHour ( )
  {
    $this->assertEquals(9,$this->time->Hour());
  }

  public function testMinute ( )
  {
    $this->assertEquals(18,$this->time->Minute());
  }

  public function testSecond ( )
  {
    $this->assertEquals(33,$this->time->Second());
  }

  public function testInSeconds ( )
  {
    $this->assertEquals(33513,$this->time->InSeconds());
  }

  public function testIsValidTime ( )
  {
    $this->assertTrue(Zeit::IsValidTime("09:18:33"));
  }

  public function testIsValidTimeFail ( )
  {
    $this->assertFalse(Zeit::IsValidTime("09:18:77"));
  }

  public function testNow ( )
  {
    $expected = new Zeit(date("H:i:s"));
    $this->assertEquals($expected,Zeit::Now());
  }

  public function testFormat ( )
  {
    $this->assertEquals("09:18:33",$this->time->Format());
  }

  public function testFormat2 ( )
  {
    $this->assertEquals("09:18",$this->time->Format("H:i"));
  }

  public function testStrToTime ( )
  {
    $this->assertEquals("07:00:00",Zeit::StrToTime("7:00:00"));
    $this->assertEquals("08:00:00",Zeit::StrToTime("8:00"));
    $this->assertEquals("09:00:00",Zeit::StrToTime("9.00"));
    $this->assertEquals("05:00:00",Zeit::StrToTime("05.0"));
    $this->assertEquals("06:00:00",Zeit::StrToTime("6:0"));
    $this->assertEquals("04:00:35",Zeit::StrToTime("4:00,35"));
    $this->assertEquals("08:00:00",Zeit::StrToTime("8.00"));
    $this->assertEquals("08:00:00",Zeit::StrToTime("8"));
    $this->assertEquals("08:00:00",Zeit::StrToTime("800"));
    $this->assertEquals("11:30:00",Zeit::StrToTime("1130"));
  }

  public function testBefore ( )
  {
    $after = new Zeit("09:18:34");
    $this->assertTrue($this->time->Before($after));
    $this->assertTrue($this->time->BeforeOrSame($after));
  }

  public function testBeforeFalseEquals ( )
  {
    $after = new Zeit("09:18:33");
    $this->assertFalse($this->time->Before($after));
    $this->assertTrue($this->time->BeforeOrSame($after));
  }

  public function testBeforeFalse ( )
  {
    $before = new Zeit("09:18:32");
    $this->assertFalse($this->time->Before($before));
    $this->assertFalse($this->time->BeforeOrSame($before));
  }

  public function testFromSeconds ( )
  {
    $this->assertEquals(new Zeit('08:18:33'),Zeit::fromSeconds(29913));
  }

  public function testNegativeZeit ( )
  {
    $this->setExpectedException('DatumException');
    Zeit::fromSeconds(-1);
  }

  public function testAddSeconds ( )
  {
    $this->time = new Zeit("09:18:33");
    $this->assertEquals(new Zeit('09:18:34'),$this->time->addSeconds(1));
    $this->assertEquals(new Zeit('09:18:32'),$this->time->addSeconds(-1));

    $this->assertEquals(new Zeit('00:00:01'),$this->time->addSeconds(-33512));
    $this->assertEquals(new Zeit('00:00:00'),$this->time->addSeconds(-33513));
    $this->assertEquals(new Zeit('00:00:00'),$this->time->addSeconds(-33514));
    $this->assertEquals(new Zeit('00:00:00'),$this->time->addSeconds(-10000000));

    $this->assertEquals(new Zeit('23:59:59'),$this->time->addSeconds(52886));
    $this->assertEquals(new Zeit('23:59:59'),$this->time->addSeconds(52887));
  }

}

?>
