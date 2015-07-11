<?php

require_once 'DatumException.php';
require_once 'Datum.php';

date_default_timezone_set('Europe/Berlin');

class DatumTest extends PHPUnit_Framework_TestCase 
{
  private $datum;

  public function setUp ( )
  {
    $this->datum = new Datum("2008-09-18");
  }

  public function testConstructor ( ) 
  {
    $this->SetExpectedException("DatumException");
    $datum = new Datum("");
  }

  public function testToString ( ) 
  {
    $this->assertEquals("2008-09-18",$this->datum->__toString());
  }

  public function testYear ( )
  {
    $this->assertSame(2008,$this->datum->Year());
  }

  public function testMonth ( )
  {
    $this->assertSame(9,$this->datum->Month());
  }

  public function testDay ( )
  {
    $this->assertSame(18,$this->datum->Day());
  }

  public function testInSeconds ( )
  {
    $this->assertEquals(1221696000,$this->datum->InSeconds());
  }

  public function testFirstOfYear ( )
  {
    $expected = new Datum("2008-01-01");
    $this->assertEquals($expected,$this->datum->FirstOfYear());
  }

  public function testFirstOfMonth ( )
  {
    $expected = new Datum("2008-09-01");
    $this->assertEquals($expected,$this->datum->FirstOfMonth());
  }

  public function testLastOfMonth ( )
  {
    $expected = new Datum("2008-09-30");
    $this->assertEquals($expected,$this->datum->LastOfMonth());
  }

  public function testLastOfMonth2 ( )
  {
    $datum = new Datum("2008-02-18");
    $expected = new Datum("2008-02-29");
    $this->assertEquals($expected,$datum->LastOfMonth());
  }

  public function testLastOfMonth3 ( )
  {
    $datum = new Datum("2008-12-01");
    $expected = new Datum("2008-12-31");
    $this->assertEquals($expected,$datum->LastOfMonth());
  }

  public function testLastOfMonth4 ( )
  {
    $datum = new Datum("2008-12-31");
    $expected = new Datum("2008-12-31");
    $this->assertEquals($expected,$datum->LastOfMonth());
  }

  public function testLastOfMonth5 ( )
  {
    $datum = new Datum("2013-03-01");
    $expected = new Datum("2013-03-31");
    $this->assertEquals($expected,$datum->LastOfMonth());
  }

  public function testFirstOfWeek ( )
  {
    $expected = new Datum("2008-09-15");
    $this->assertEquals($expected,$this->datum->FirstOfWeek());
  }

  public function testFirstOfWeek2 ( )
  {
    $expected = new Datum("2008-09-29");
    $date = new Datum('2008-10-04');
    $this->assertEquals($expected,$date->FirstOfWeek());
  }

  public function testFirstOfWeek3 ( )
  {
    $expected = new Datum("2008-09-29");
    $this->assertEquals($expected,$expected->FirstOfWeek());
  }

  public function testLastOfWeek ( )
  {
    $expected = new Datum("2008-09-21");
    $this->assertEquals($expected,$this->datum->LastOfWeek());
  }

  public function testLastOfWeek2 ( )
  {
    $expected = new Datum("2008-10-05");
    $date = new Datum('2008-09-30');
    $this->assertEquals($expected,$date->LastOfWeek());
  }

  public function testLastOfWeek3 ( )
  {
    $expected = new Datum("2008-10-05");
    $this->assertEquals($expected,$expected->LastOfWeek());
  }

  public function testLastOfYear ( )
  {
    $expected = new Datum("2008-12-31");
    $this->assertEquals($expected,$this->datum->LastOfYear());
  }

  public function testLastOfHalfYear ( )
  {
    $expected = new Datum("2008-12-31");
    $this->assertEquals($expected,$this->datum->LastOfHalfYear());

    $this->datum = new Datum('2012-03-15');
    $expected = new Datum("2012-06-30");
    $this->assertEquals($expected,$this->datum->LastOfHalfYear());
  }

  public function testLastOfQuarterYear ( )
  {
    $expected = new Datum("2008-09-30");
    $this->assertEquals($expected,$this->datum->LastOfQuarterYear());

    $this->datum = new Datum('2012-03-15');
    $expected = new Datum("2012-03-31");
    $this->assertEquals($expected,$this->datum->LastOfQuarterYear());

    $this->datum = new Datum('2012-10-01');
    $expected = new Datum("2012-12-31");
    $this->assertEquals($expected,$this->datum->LastOfQuarterYear());

    $this->datum = new Datum('2012-06-30');
    $expected = new Datum("2012-06-30");
    $this->assertEquals($expected,$this->datum->LastOfQuarterYear());
  }

  public function testPreviousLast ( )
  {
    $expected = new Datum("2008-08-31");
    $this->assertEquals($expected,$this->datum->PreviousLast());
  }

  public function testPreviousLastShortMonth ( )
  {
    $datum = new Datum("2008-07-31");
    $expected = new Datum("2008-06-30");
    $this->assertEquals($expected,$datum->PreviousLast());
  }

  public function testPreviousLastFeb ( )
  {
    $datum = new Datum("2008-03-01");
    $expected = new Datum("2008-02-29");
    $this->assertEquals($expected,$datum->PreviousLast());
  }

  public function testPreviousLastYear ( )
  {
    $datum = new Datum("2008-01-01");
    $expected = new Datum("2007-12-31");
    $this->assertEquals($expected,$datum->PreviousLast());
  }

  public function testIsValidDate1 ( )
  {
    $this->assertTrue(Datum::IsValidDate("2008-01-01"));
  }

  public function testIsValidDate2 ( )
  {
    $this->assertTrue(Datum::IsValidDate("2008-02-29"));
  }

  public function testIsValidDateFail1 ( )
  {
    $this->assertFalse(Datum::IsValidDate("2007-02-29"),"Der 29.2.07 ist kein gültiges Datum.");
  }

  public function testIsValidDateFail2 ( )
  {
    $this->assertFalse(Datum::IsValidDate("xxx"));
  }

  public function testIsValidDateFail3 ( )
  {
    $this->assertFalse(Datum::IsValidDate("28.02.2008"));
  }

  public function testStrToDate1 ( )
  {
    $this->assertEquals("2005-02-05",Datum::StrToDate("05.2.05"));
  }

  public function testStrToDate2 ( )
  {
    $this->assertEquals("2005-02-05",Datum::StrToDate("05.2.2005"));
  }

  public function testStrToDate3 ( )
  {
    $this->assertEquals("2005-02-05",Datum::StrToDate("05.02.2005"));
  }

  public function testStrToDate4 ( )
  {
    $currentYear = date("Y");
    $this->assertEquals("$currentYear-02-05",Datum::StrToDate("05.02."));
  }

  public function testStrToDate5 ( )
  {
    $currentYear = date("Y");
    $this->assertEquals("$currentYear-02-05",Datum::StrToDate("5.2"));
  }

  public function testStrToDate6 ( )
  {
    $this->assertEquals("2005-02-05",Datum::StrToDate("05/02/05"));
  }

  public function testStrToDate7 ( )
  {
    $this->assertEquals("2005-02-05",Datum::StrToDate("05/02/2005"));
  }

  public function testStrToDate8 ( )
  {
    $currentYear = date("Y");
    $this->assertEquals("$currentYear-02-05",Datum::StrToDate("05/02/"));
  }

  public function testStrToDate9 ( )
  {
    $currentYear = date("Y");
    $this->assertEquals("$currentYear-02-05",Datum::StrToDate("5/2"));
  }

  public function testStrToDate10 ( )
  {
    $this->assertEquals("2012-01-01",Datum::StrToDate("01012012"));
  }

  public function testStrToDateFail1 ( )
  {
    $this->assertEquals("xxx",Datum::StrToDate("xxx"));
  }

  public function testStrToDateFail2 ( )
  {
    $this->assertEquals("22-11-08",Datum::StrToDate("22-11-08"));
  }

  public function testBefore ( )
  {
    $after = new Datum("2008-09-19");
    $this->assertTrue($this->datum->Before($after));
  }

  public function testBeforeFalseEquals ( )
  {
    $after = new Datum("2008-09-18");
    $this->assertFalse($this->datum->Before($after));
  }

  public function testBeforeFalse ( )
  {
    $before = new Datum("2008-09-17");
    $this->assertFalse($this->datum->Before($before));
  }

  public function testFormat ( )
  {
    $this->assertEquals("18.09.2008",$this->datum->Format());
  }

  public function testFormat2 ( )
  {
    $this->assertEquals("09/18/2008",$this->datum->Format("m/d/Y"));
  }

  public function testPreviousDay( )
  {
    $expected = new Datum("2008-09-17");
    $this->assertEquals($expected,$this->datum->PreviousDay());
  }

  public function testToDay ( )
  {
    $expected = new Datum(date("Y-m-d"));
    $this->assertEquals($expected,Datum::ToDay());
  }

  public function testDateAdd ( )
  {
    $this->assertEquals(new Datum('2008-09-19'),$this->datum->DateAdd(1));
    $this->assertEquals(new Datum('2008-09-17'),$this->datum->DateAdd(-1));
    $this->assertEquals(new Datum('2008-11-17'),$this->datum->DateAdd(60));
    $datum = new Datum('2009-10-01');
    $this->assertEquals(new Datum('2009-11-01'),$datum->DateAdd(31));
  }

  public function testWochentag ( )
  {
    $this->assertEquals('Montag',$this->datum->wochentag(1));
    $this->assertEquals('Dienstag',$this->datum->wochentag(2));
    $this->assertEquals('Mittwoch',$this->datum->wochentag(3));
    $this->assertEquals('Donnerstag',$this->datum->wochentag(4));
    $this->assertEquals('Freitag',$this->datum->wochentag(5));
    $this->assertEquals('Samstag',$this->datum->wochentag(6));
    $this->assertEquals('Sonntag',$this->datum->wochentag(0));

    $this->assertEquals('Donnerstag',$this->datum->wochentag());
  }

  public function testMonatsname ( )
  {
    $this->assertEquals('Januar',$this->datum->monatsname(1));
    $this->assertEquals('Februar',$this->datum->monatsname(2));
    $this->assertEquals('März',$this->datum->monatsname(3));
    $this->assertEquals('April',$this->datum->monatsname(4));
    $this->assertEquals('Mai',$this->datum->monatsname(5));
    $this->assertEquals('Juni',$this->datum->monatsname(6));
    $this->assertEquals('Juli',$this->datum->monatsname(7));
    $this->assertEquals('August',$this->datum->monatsname(8));
    $this->assertEquals('September',$this->datum->monatsname(9));
    $this->assertEquals('Oktober',$this->datum->monatsname(10));
    $this->assertEquals('November',$this->datum->monatsname(11));
    $this->assertEquals('Dezember',$this->datum->monatsname(12));

    $this->assertEquals('September',$this->datum->monatsname());
  }

  public function testDateDiff ( )
  {
    $this->assertEquals(1,$this->datum->DateDiff(new Datum('2008-09-17')));
    $this->assertEquals(1,$this->datum->DateDiff(new Datum('2008-09-19')));
    $this->assertEquals(30,$this->datum->DateDiff(new Datum('2008-10-18')));
    $this->assertEquals(30,$this->datum->DateDiff(new Datum('2008-08-19')));
  }

  public function testJahrestag ( )
  {
    $datum = Datum::Today()->DateAdd(-1);
    $this->assertFalse($datum->Jahrestag());
    $this->assertTrue($datum->Jahrestag(Datum::Today()->DateAdd(-1)));

    $datum = new Datum('1977-09-18');
    $this->assertTrue($datum->Jahrestag(new Datum('2011-09-18')));
  }

  public function testAlter ( )
  {
    $datum = new Datum('1977-09-18');
    $this->assertEquals(34,$datum->Alter(new Datum('2011-01-01')));
    $this->assertEquals(34,$datum->Alter(new Datum('2011-12-31')));

    $this->assertEquals(1,Datum::Today()->Alter(Datum::Today()->DateAdd(365)));
  }

  public function testWeekStartsOnMonday ( )
  {
    $datum = new Datum('2012-04-15');
    $this->assertEquals(new Datum('2012-04-09'),$datum->firstOfWeek());
    $this->assertEquals(new Datum('2012-04-15'),$datum->lastOfWeek());
  }
    
  public function testAddYear ( )
  {
    $this->assertEquals(new Datum('2009-09-18'),$this->datum->addYear(1));
    $this->assertEquals(new Datum('2007-09-18'),$this->datum->addYear(-1));
    
    $datum = new Datum('2012-02-29');
    $this->assertEquals(new Datum('2013-02-28'),$datum->addYear(1));
    $this->assertEquals(new Datum('2016-02-29'),$datum->addYear(4));
    $this->assertEquals(new Datum('2011-02-28'),$datum->addYear(-1));
  }

  public function testAddMonth ( )
  {
    $this->assertEquals(new Datum('2008-10-18'),$this->datum->addMonth(1));
    $this->assertEquals(new Datum('2008-08-18'),$this->datum->addMonth(-1));
    $this->assertEquals(new Datum('2009-01-18'),$this->datum->addMonth(4));
    $this->assertEquals(new Datum('2007-12-18'),$this->datum->addMonth(-10));
    $this->assertEquals(new Datum('2010-01-18'),$this->datum->addMonth(16));

    $datum = new Datum('2012-01-31');
    $this->assertEquals(new Datum('2012-02-29'),$datum->addMonth(1));
    $this->assertEquals(new Datum('2012-04-30'),$datum->addMonth(3));

    $datum = new Datum('2011-01-31');
    $this->assertEquals(new Datum('2011-02-28'),$datum->addMonth(1));

    $datum = new Datum('2014-12-31');
    $this->assertEquals(new Datum('2013-12-31'),$datum->addMonth(-12));
  }

  public function testBoese13 ( )
  {
    $datum = new Datum('2013-11-01');
    $this->assertEquals(new Datum('2014-12-01'),$datum->addMonth(13));
  }

  public function testFromSeconds ( )
  {
    $datum = new Datum('2013-03-05');
    $inSeconds = $datum->inSeconds();
    $this->assertEquals(1362441600,$inSeconds);
    $this->assertEquals($datum,Datum::fromSeconds($inSeconds));
  }

  public function testLastWeekNumberOfYear ( )
  {
    $this->assertEquals(53,Datum::lastWeekNumberOfYear(2009));
    $this->assertEquals(52,Datum::lastWeekNumberOfYear(2013));
  }

  public function testErstesDatumEinerWoche ( )
  {
    $ersterWochentag = Datum::firstDateFromWeekNumberOfCurrentYear(50);
    $this->assertEquals($ersterWochentag->firstOfWeek(),$ersterWochentag);
    $this->assertEquals(50,$ersterWochentag->format('W'));
  }

  public function testErstesDatumEinerWocheMitZuGrosserWoche ( )
  {
    $this->setExpectedException('DatumException');
    Datum::firstDateFromWeekNumberOfCurrentYear(54);
  }

  public function testErstesDatumEinerWocheMitZuKleinerWoche ( )
  {
    $this->setExpectedException('DatumException');
    Datum::firstDateFromWeekNumberOfCurrentYear(0);
  }

  public function testLetztesDatumEinerWoche ( )
  {
    $letzterWochentag = Datum::lastDateFromWeekNumberOfCurrentYear(50);
    $this->assertEquals($letzterWochentag->lastOfWeek(),$letzterWochentag);
    $this->assertEquals(50,$letzterWochentag->format('W'));
  }

  public function testLetztesDatumEinerWocheMitZuGrosserWoche ( )
  {
    $this->setExpectedException('DatumException');
    Datum::lastDateFromWeekNumberOfCurrentYear(54);
  }

  public function testLetztesDatumEinerWocheMitZuKleinerWoche ( )
  {
    $this->setExpectedException('DatumException');
    Datum::lastDateFromWeekNumberOfCurrentYear(0);
  }

  public function testPreviousLastOfQuarter ( )
  {
    foreach ( array('2014-01-01' => '2013-12-31',
                    '2014-01-02' => '2013-12-31',
                    '2014-03-31' => '2014-03-31',
                    '2014-04-01' => '2014-03-31',
                    '2014-06-30' => '2014-06-30',
                    '2014-07-01' => '2014-06-30',
                    '2014-09-30' => '2014-09-30',
                    '2014-10-01' => '2014-09-30',
                    '2014-12-31' => '2014-12-31') as $datum => $expected )
      {
        $datum = new Datum($datum);
        $this->assertEquals(new Datum($expected),$datum->previousLastOfQuarter());
      }
  }

}

?>
