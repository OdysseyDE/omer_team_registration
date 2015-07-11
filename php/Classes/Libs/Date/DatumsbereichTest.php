<?php

require_once 'Datum.php';
require_once 'Datumsbereich.php';

class DatumsbereichTest extends PHPUnit_Framework_TestCase 
{
  public function testGetters ( )
  {
    $datumsbereich = new Datumsbereich(new Datum('2008-10-01'),new Datum('2009-04-30'));
    $this->assertEquals(new Datum('2008-10-01'),$datumsbereich->Start());
    $this->assertEquals(new Datum('2008-10-02'),$datumsbereich->Start(new Datum('2008-10-02')));
    $this->assertEquals(new Datum('2009-04-30'),$datumsbereich->End());
    $this->assertEquals(new Datum('2009-04-29'),$datumsbereich->End(new Datum('2009-04-29')));
  }

  public function testDateWithinCompleteRange ( )
  {
    $datumsbereich = new Datumsbereich(new Datum('2008-10-01'),new Datum('2009-04-30'));
    $this->assertTrue($datumsbereich->DateWithin(new Datum('2008-10-01')));
    $this->assertFalse($datumsbereich->DateWithin(new Datum('2008-09-30')));
    $this->assertTrue($datumsbereich->DateWithin(new Datum('2009-04-30')));
    $this->assertFalse($datumsbereich->DateWithin(new Datum('2009-05-01')));
    $this->assertTrue($datumsbereich->DateWithin(new Datum('2008-12-31')));
  }

  public function testDateWithinOpenEnd ( )
  {
    $datumsbereich = new Datumsbereich(new Datum('2008-10-01'));
    $this->assertTrue($datumsbereich->DateWithin(new Datum('2008-10-01')));
    $this->assertFalse($datumsbereich->DateWithin(new Datum('2008-09-30')));
    $this->assertTrue($datumsbereich->DateWithin(new Datum('2009-04-30')));
    $this->assertTrue($datumsbereich->DateWithin(new Datum('2009-05-01')));
    $this->assertTrue($datumsbereich->DateWithin(new Datum('2008-12-31')));
  }

  public function testLength ( )
  {
    $datumsbereich = new Datumsbereich(new Datum('2008-04-01'),new Datum('2009-04-30'));
    $this->assertEquals(395,$datumsbereich->Length());

    $datumsbereich = new Datumsbereich(new Datum('2008-04-01'),new Datum('2008-04-01'));
    $this->assertEquals(1,$datumsbereich->Length());

    $datumsbereich = new Datumsbereich(new Datum('2008-04-01'));
    $this->assertEquals(-1,$datumsbereich->Length());

    $datumsbereich = new Datumsbereich(new Datum('2008-04-01'),new Datum('2008-03-01'));
    $this->assertEquals(-1,$datumsbereich->Length());

    $datumsbereich = new Datumsbereich(new Datum('2011-01-01'),new Datum('2011-09-30'));
    $this->assertEquals(273,$datumsbereich->Length());

    $datumsbereich = new Datumsbereich(new Datum('2013-03-29'),new Datum('2013-04-01'));
    $this->assertEquals(4,$datumsbereich->Length());

    $datumsbereich = new Datumsbereich(new Datum('2015-04-01'),new Datum('2016-03-31'));
    $this->assertEquals(366,$datumsbereich->Length());
  }

  public function testMonths ( )
  {
    $datumsbereich = new Datumsbereich(new Datum('2008-11-16'),new Datum('2008-11-30'));
    $this->assertEquals(0.5,$datumsbereich->Months());

    $datumsbereich = new Datumsbereich(new Datum('2008-11-01'),new Datum('2008-11-15'));
    $this->assertEquals(0.5,$datumsbereich->Months());

    $datumsbereich = new Datumsbereich(new Datum('2008-11-16'),new Datum('2008-12-31'));
    $this->assertEquals(1.5,$datumsbereich->Months());

    $datumsbereich = new Datumsbereich(new Datum('2008-11-16'),new Datum('2009-01-31'));
    $this->assertEquals(2.5,$datumsbereich->Months());

    $datumsbereich = new Datumsbereich(new Datum('2008-12-01'),new Datum('2008-12-02'));
    $this->assertEquals(0.065,$datumsbereich->Months(),'',0.0005);

    $datumsbereich = new Datumsbereich(new Datum('2008-11-16'),new Datum('2008-12-02'));
    $this->assertEquals(0.565,$datumsbereich->Months(),'',0.0005);

    $datumsbereich = new Datumsbereich(new Datum('2008-11-16'),new Datum('2008-12-15'));
    $this->assertEquals(0.984,$datumsbereich->Months(),'',0.0005);

    $datumsbereich = new Datumsbereich(new Datum('2012-01-15'),new Datum('2012-04-15'));
    $this->assertEquals(3,$datumsbereich->Months(),'',0.0005);

    $datumsbereich = new Datumsbereich(new Datum('2015-01-30'),new Datum('2015-02-28'));
    $this->assertEquals(1,$datumsbereich->Months(),'',0.0005);
  }

  public function testMonate ( )
  {
    $bereich = new Datumsbereich(new Datum('2008-10-16'),new Datum('2008-12-15'));
    $monate = $bereich->Monate();
    $this->assertEquals(3,count($monate));
    $first = reset($monate);
    $this->assertEquals(new Datumsbereich(new Datum('2008-10-16'),new Datum('2008-10-31')),$first);
    $next = next($monate);
    $this->assertEquals(new Datumsbereich(new Datum('2008-11-01'),new Datum('2008-11-30')),$next);
    $next = next($monate);
    $this->assertEquals(new Datumsbereich(new Datum('2008-12-01'),new Datum('2008-12-15')),$next);
  }
  
  public function testIteration ( )
  {
    $bereich = new Datumsbereich(new Datum('2011-07-22'),new Datum('2011-07-24'));
    $ziel=array(0=>new Datum('2011-07-22'),
                1=>new Datum('2011-07-23'),
                2=>new Datum('2011-07-24'));

    $counter = 0;
    foreach ( $bereich as $key => $value )
      {
        $this->assertEquals($ziel[$key],$value);
        $counter++;
      }
    $this->assertEquals(3,$counter);
  }

}

?>
