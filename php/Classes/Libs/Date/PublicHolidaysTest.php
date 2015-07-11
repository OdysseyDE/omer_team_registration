<?php

require_once 'Datum.php';
require_once 'Bundesland.php';
require_once 'PublicHolidays.php';

class PublicHolidaysTest extends PHPUnit_Framework_TestCase 
{
  public function testAddWorkingDays()
  {
    $this->assertEquals(new Datum('2011-07-18'),PublicHolidays::AddWorkingDays(0,new Datum('2011-07-18')));
    $this->assertEquals(new Datum('2011-07-18'),PublicHolidays::AddWorkingDays(0,new Datum('2011-07-17')));

    $this->assertEquals(new Datum('2011-07-19'),PublicHolidays::AddWorkingDays(1,new Datum('2011-07-18')));
    $this->assertEquals(new Datum('2011-07-18'),PublicHolidays::AddWorkingDays(1,new Datum('2011-07-17')));

    $this->assertEquals(new Datum('2011-12-23'),PublicHolidays::AddWorkingDays(0,new Datum('2011-12-23')));
    $this->assertEquals(new Datum('2011-12-27'),PublicHolidays::AddWorkingDays(1,new Datum('2011-12-23')));
    $this->assertEquals(new Datum('2011-12-28'),PublicHolidays::AddWorkingDays(2,new Datum('2011-12-23')));
    $this->assertEquals(new Datum('2011-12-29'),PublicHolidays::AddWorkingDays(3,new Datum('2011-12-23')));
    $this->assertEquals(new Datum('2011-12-30'),PublicHolidays::AddWorkingDays(4,new Datum('2011-12-23')));
    $this->assertEquals(new Datum('2012-01-02'),PublicHolidays::AddWorkingDays(5,new Datum('2011-12-23')));
  }

  public function testAlteTests ( ) 
  {
    $this->assertEquals(new Datum('2011-05-27'),PublicHolidays::AddWorkingDays(0,new Datum('2011-05-27')));
    $this->assertEquals(new Datum('2011-05-30'),PublicHolidays::AddWorkingDays(1,new Datum('2011-05-27')));

    $this->assertEquals(new Datum('2011-05-30'),PublicHolidays::AddWorkingDays(0,new Datum('2011-05-28')));
    $this->assertEquals(new Datum('2011-05-30'),PublicHolidays::AddWorkingDays(1,new Datum('2011-05-28')));

    $this->assertEquals(new Datum('2011-05-30'),PublicHolidays::AddWorkingDays(0,new Datum('2011-05-29')));
    $this->assertEquals(new Datum('2011-05-30'),PublicHolidays::AddWorkingDays(1,new Datum('2011-05-29')));

    $this->assertEquals(new Datum('2011-06-06'),PublicHolidays::AddWorkingDays(2,new Datum('2011-06-01')));
    $this->assertEquals(new Datum('2011-06-06'),PublicHolidays::AddWorkingDays(2,new Datum('2011-06-02')));
  }

}

?>
