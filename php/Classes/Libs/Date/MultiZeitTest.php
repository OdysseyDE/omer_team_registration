<?php

require_once 'DatumException.php';
require_once 'Zeit.php';
require_once 'MultiZeit.php';

class MultiZeitTest extends PHPUnit_Framework_TestCase 
{
  public function testEmptyConstructor ( ) 
  {
    $this->setExpectedException("DatumException");
    $time = new MultiZeit("");
  }

  public function testConstructor ( ) 
  {
    $time = new MultiZeit("129:18:33");

    $this->assertEquals("129:18:33",$time->__toString());
    $this->assertEquals("129:18:33",$time->format());
    $this->assertEquals("129:18",$time->format("H:i"));

    $this->assertEquals(129,$time->hour());
    $this->assertEquals(18,$time->minute());
    $this->assertEquals(33,$time->second());
    $this->assertEquals(465513,$time->inSeconds());
  }

  public function testConstructorWithSeconds ( ) 
  {
    $this->assertEquals(new MultiZeit(465513),new MultiZeit("129:18:33"));
  }

  public function testFromSeconds ( )
  {
    $this->assertEquals(new MultiZeit('29:18:33'),MultiZeit::fromSeconds(29*3600+18*60+33));
  }

  public function testIsValidTime ( )
  {
    $this->assertTrue(MultiZeit::isValidTime("09:18:33"));
    $this->assertFalse(MultiZeit::isValidTime("09:18:77"));
  }

  public function testNow ( )
  {
    $expected = new MultiZeit(date("H:i:s"));
    $this->assertEquals($expected,MultiZeit::now());
  }

  public function testStrToTime ( )
  {
    $this->assertEquals("07:00:00",MultiZeit::strToTime("7:00:00"));
    $this->assertEquals("08:00:00",MultiZeit::strToTime("8:00"));
    $this->assertEquals("09:00:00",MultiZeit::strToTime("9.00"));
    $this->assertEquals("05:00:00",MultiZeit::strToTime("05.0"));
    $this->assertEquals("06:00:00",MultiZeit::strToTime("6:0"));
    $this->assertEquals("04:00:35",MultiZeit::strToTime("4:00,35"));
    $this->assertEquals("08:00:00",MultiZeit::strToTime("8.00"));
    $this->assertEquals("08:00:00",MultiZeit::strToTime("8"));
    $this->assertEquals("29:00:00",MultiZeit::strToTime("29:00:00"));
  }

  public function testBefore ( )
  {
    $time = new MultiZeit("129:18:33");
    $after = new MultiZeit("129:18:34");

    $this->assertTrue($time->before($after));
    $this->assertTrue($time->beforeOrSame($after));

    $after = new MultiZeit("129:18:33");
    $this->assertFalse($time->before($after));
    $this->assertTrue($time->beforeOrSame($after));

    $before = new MultiZeit("129:18:32");
    $this->assertFalse($time->before($before));
    $this->assertFalse($time->beforeOrSame($before));
  }

  public function testfromZeit ( )
  {
    $this->assertEquals(new MultiZeit("01:01:02"),MultiZeit::fromZeit(new Zeit("01:01:02")));
  }

  public function testAdd ( )
  {
    $time = new MultiZeit("129:18:33");
    $this->assertEquals(new MultiZeit("131:18:32"),$time->add(new MultiZeit("01:59:59")));
    $this->assertEquals(new MultiZeit("127:18:34"),$time->subtract(new MultiZeit("01:59:59")));
  }

  public function testRunden ( )
  {
    $time = 2 + 10 / 60;
    $time = MultiZeit::fromSeconds($time*3600);
    $this->assertEquals(7800,$time->inSeconds());
  }

  public function testConstructorMitNegativerZeit ( ) 
  {
    $time = new MultiZeit("-10:00:00");

    $this->assertEquals("-10:00:00",$time->__toString());
    $this->assertEquals("-10:00:00",$time->format());
    $this->assertEquals("-10:00",$time->format("H:i"));

    $this->assertEquals(-10,$time->hour());
    $this->assertEquals(0,$time->minute());
    $this->assertEquals(0,$time->second());
    $this->assertEquals(-36000,$time->inSeconds());
  }

}

?>
