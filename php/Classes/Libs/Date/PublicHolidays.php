<?php

class PublicHolidays 
{
  public static function IsSunday ( Datum $day )
  {
    return in_array($day->Format('w'),array(0));
  }


  public static function EasterSunday ( $year )
  {
    $p = floor($year/100);
    $r = floor($year/400);
    $o = floor(($p*8+13)/25)-2;
    $w = (19*($year%19)+(13+$p-$r-$o)%30)%30;
    $e = ($w==29?28:$w);
    if ($w==28&&($year%19)>10) $e=27;
    $day = (2*($year%4)+4*($year%7)+6*$e+(4+$p-$r)%7)%7+22+$e;
    $month = ($day>31?4:3);
    if ($day>31) $day-=31;
    return new Datum(sprintf("%04d-%02d-%02d",$year,$month,$day));
  }


  public static function Holidays ( $year, Bundesland $bundesland ) 
  {
    $easterSunday = PublicHolidays::EasterSunday($year);

    $days['Neujahr'] = new Datum($year.'-01-01');
    $days['Tag der Arbeit'] = new Datum($year.'-05-01');
    $days['Tag der deutschen Einheit'] = new Datum($year.'-10-03');
    $days['1. Weihnachtsfeiertag'] = new Datum($year.'-12-25');
    $days['2. Weihnachtsfeiertag'] = new Datum($year.'-12-26');

    $days['Karfreitag'] = $easterSunday->DateAdd(-2);
    $days['Ostermontag'] = $easterSunday->DateAdd(1);
    $days['Christi Himmelfahrt'] = $easterSunday->DateAdd(39);
    $days['Pfingstmontag'] = $easterSunday->DateAdd(50);

    if ( in_array($bundesland->Abbreviation(),array('BW','BY','ST')) )
      $days['Hlg. drei Könige'] = new Datum($year.'-01-06');

    if ( in_array($bundesland->Abbreviation(),array('BW','BY','HE','NW','RP','SL')) )
      $days['Fronleichnam'] = $easterSunday->DateAdd(60);

    if ( in_array($bundesland->Abbreviation(),array('SL')) )
      $days['Maria Himmelfahrt'] = new Datum($year.'-08-15');

    if ( in_array($bundesland->Abbreviation(),array('BB','MV','SN','ST','TH')) )
      $days['Reformationstag'] = new Datum($year.'-10-31');

    if ( in_array($bundesland->Abbreviation(),array('BW','BY','NW','RP','SL')) )
      $days['Allerheiligen'] = new Datum($year.'-11-01');

    if ( in_array($bundesland->Abbreviation(),array('SN')) )
      {
        $date = new Datum($year.'-11-23');
        $tage = $date->Format('w') + 4;
        if ( $tage > 7 )
          $tage -= 7;
        $days['Buß- und Bettag'] = $date->DateAdd(-$tage);
      }

    return $days;
  }



  public static function IsHoliday ( Datum $day, Bundesland $bundesland )
  {
    $holidays = PublicHolidays::Holidays($day->Year(),$bundesland);
    foreach ( $holidays as $holiday )
      if ( $holiday == $day )
        return true;

    return false;
  }


  public static function IsHalfHoliday ( Datum $day )
  {
    if ( $day->Month() == 12 && in_array($day->Day(),array(24,31)) )
      return true;

    return false;
  }


  protected static function IsWeekend ( Datum $day )
  {
    return $day->Format("w") == 0 || $day->Format("w") == 6;
  }


  public static function AddWorkingDays ( $days, Datum $date = null )
  {
    if ( $date === null )
      $date = Datum::ToDay();

    if ( $days == 0 )
      while ( PublicHolidays::IsWeekend($date) || PublicHolidays::IsHoliday($date,new Bundesland('BB','Brandenburg')) )
        $date = $date->DateAdd(1);
      
    $i = 0;
    while ( $i < $days )
      {
        $date = $date->DateAdd(1);
        if ( !PublicHolidays::IsWeekend($date) && !PublicHolidays::IsHoliday($date,new Bundesland('BB','Brandenburg')) )
          $i++;
      }

    return $date;
  }

}

?>
