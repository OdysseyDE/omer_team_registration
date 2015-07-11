<?php

require_once 'DatumException.php';
require_once 'Zeitpunkt.php';

class ZeitpunktTest extends PHPUnit_Framework_TestCase 
{
  private $myDateTime;

  public function setUp ( )
  {
    $this->myDateTime = new Zeitpunkt("2008-03-20 09:18:33");
  }

  public function testConstructor ( ) 
  {
    $this->SetExpectedException("DatumException");
    $myDateTime = new Zeitpunkt("");
  }

  public function testToString ( ) 
  {
    $this->assertEquals("2008-03-20 09:18:33",$this->myDateTime->__toString());
  }

  public function testIsValidDateTime ( )
  {
    $this->assertTrue(Zeitpunkt::IsValidDateTime("2008-03-20 09:18:33"));
    $this->assertTrue(Zeitpunkt::IsValidDateTime("2012-03-25 02:00:00"));
  }

  public function testIsValidDateTimeFail1 ( )
  {
    $this->assertFalse(Zeitpunkt::IsValidDateTime("2008-03-20 09:18:77"));
  }

  public function testIsValidDateTimeFail2 ( )
  {
    $this->assertFalse(Zeitpunkt::IsValidDateTime("2008-02-30 09:18:33"));
  }

  public function testNow ( )
  {
    $expected = new Zeitpunkt(date("Y-m-d H:i:s"));
    $this->assertEquals($expected,Zeitpunkt::Now());
  }

  public function testDate ( )
  {
    $expected = new Datum("2008-03-20");
    $this->assertEquals($expected,$this->myDateTime->Date());
  }

  public function testTime ( )
  {
    $expected = new Zeit("09:18:33");
    $this->assertEquals($expected,$this->myDateTime->Time());
  }

  public function testFormat ( )
  {
    $this->assertEquals("20.03.2008 09:18",$this->myDateTime->Format("d.m.Y","H:i"));
    $this->assertEquals("20.03.2008T09:18",$this->myDateTime->Format("d.m.Y","H:i","T"));
  }

  public function testInDateTime ( )
  {
    if ( date('I') == 1 )
      {
        $this->assertEquals(new DateTime('2008-03-20 07:18:33', new DateTimeZone('GMT')),$this->myDateTime->InDateTime());
        
        $this->myDateTime = new Zeitpunkt("2008-03-21 00:18:33");
        $this->assertEquals(new DateTime('2008-03-20 22:18:33', new DateTimeZone('GMT')),$this->myDateTime->InDateTime());
      }
    else
      {
        $this->assertEquals(new DateTime('2008-03-20 08:18:33', new DateTimeZone('GMT')),$this->myDateTime->InDateTime());
        
        $this->myDateTime = new Zeitpunkt("2008-03-21 00:18:33");
        $this->assertEquals(new DateTime('2008-03-20 23:18:33', new DateTimeZone('GMT')),$this->myDateTime->InDateTime());
      }
  }

  public function testAddSeconds ( )
  {
    $this->assertEquals(new Zeitpunkt('2008-03-20 10:18:38'),$this->myDateTime->AddSeconds(3605));
    $this->assertEquals(new Zeitpunkt('2008-03-21 10:18:38'),$this->myDateTime->AddSeconds(90005));
    $this->assertEquals(new Zeitpunkt('2008-03-19 10:18:38'),$this->myDateTime->AddSeconds(-82795));
    $this->assertEquals(new Zeitpunkt('2008-03-13 09:18:33'),$this->myDateTime->addSeconds(-7*24*3600));

    $this->myDateTime = new Zeitpunkt('2008-03-19 22:00:00');
    $this->assertEquals(new Zeitpunkt('2008-03-20 00:00:00'),$this->myDateTime->AddSeconds(7200));
  }

  public function testBefore ( )
  {
    $after = new Zeitpunkt("2008-03-20 09:18:34");
    $this->assertTrue($this->myDateTime->Before($after));
    $after = new Zeitpunkt("2008-03-21 09:18:32");
    $this->assertTrue($this->myDateTime->Before($after));
  }

  public function testBeforeFalseEquals ( )
  {
    $after = new Zeitpunkt("2008-03-20 09:18:33");
    $this->assertFalse($this->myDateTime->Before($after));
  }

  public function testBeforeFalse ( )
  {
    $before = new Zeitpunkt("2008-03-20 09:18:32");
    $this->assertFalse($this->myDateTime->Before($before));
    $before = new Zeitpunkt("2008-03-19 09:18:34");
    $this->assertFalse($this->myDateTime->Before($before));
  }

  public function testDiff ( )
  {
    $this->assertEquals(1,$this->myDateTime->Diff(new Zeitpunkt("2008-03-20 09:18:34")));
    $this->assertEquals(1,$this->myDateTime->Diff(new Zeitpunkt("2008-03-20 09:18:32")));
    $this->assertEquals(0,$this->myDateTime->Diff(new Zeitpunkt("2008-03-20 09:18:33")));
    $this->assertEquals(60,$this->myDateTime->Diff(new Zeitpunkt("2008-03-20 09:17:33")));
    $this->assertEquals(3600,$this->myDateTime->Diff(new Zeitpunkt("2008-03-20 10:18:33")));
    $this->assertEquals(3600*24,$this->myDateTime->Diff(new Zeitpunkt("2008-03-19 09:18:33")));
  }

  public function testFromSeconds ( )
  {
    $this->assertEquals(new Zeitpunkt('2012-04-04 14:26:39'),Zeitpunkt::fromSeconds(1333549599));
  }

  public function testSeconds ( )
  {
    $zeitpunkt = new Zeitpunkt('2013-03-05 00:19:53');
    $inSeconds = $zeitpunkt->inSeconds();
    $this->assertEquals(1362442793,$inSeconds);
    $this->assertEquals($zeitpunkt,Zeitpunkt::fromSeconds($inSeconds));
  }

}

?>
