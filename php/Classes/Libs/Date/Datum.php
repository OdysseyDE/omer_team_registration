<?php

date_default_timezone_set('Europe/Berlin');

class Datum 
{
  protected $year;
  protected $month;
  protected $day;

  public function __construct ( $datum )
  {
    if ( !self::IsValidDate(self::StrToDate($datum)) )
      throw new DatumException("Kein gültiges Datum übergeben: $datum.");

    preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",self::StrToDate($datum),$match);

    $this->year = (int)$match[1];
    $this->month = (int)$match[2];
    $this->day = (int)$match[3];

    if  ( is_string($datum) && strlen($datum) <= 6 && $this->inSeconds() >= time() + 180 * 24 * 3600 )
      $this->year--;

    return TRUE;
  }

  public function __toString ( )
  {
    return sprintf("%04d-%02d-%02d",$this->year,$this->month,$this->day);
  }
  
  public function Year ( )
  {
    return $this->year;
  }

  public function Month ( )
  {
    return $this->month;
  }

  public function Day ( )
  {
    return $this->day;
  }

  public function InSeconds ( )
  {
    $before = date_default_timezone_get();
    date_default_timezone_set('UTC');
    $seconds = strToTime($this.' 00:00:00');
    date_default_timezone_set($before);
    return $seconds;
  }

  public function FirstOfYear ( )
  {
    return new Datum(sprintf("%04d-01-01",$this->year));
  }

  public function FirstOfMonth ( )
  {
    return new Datum(sprintf("%04d-%02d-01",$this->year,$this->month));
  }

  public function LastOfMonth ( )
  {
    return $this->nextFirst()->dateAdd(-1);
  }

  public function LastOfYear ( )
  {
    return new Datum($this->Year().'-12-31');
  }

  public function LastOfHalfYear ( )
  {
    if ( $this->Month() > 6 )
      return new Datum($this->Year().'-12-31');

    return new Datum($this->Year().'-06-30');
  }

  public function LastOfQuarterYear ( )
  {
    if ( $this->Month() > 9 )
      return new Datum($this->Year().'-12-31');

    if ( $this->Month() > 6 )
      return new Datum($this->Year().'-09-30');

    if ( $this->Month() > 3 )
      return new Datum($this->Year().'-06-30');

    return new Datum($this->Year().'-03-31');
  }

  public function previousLastOfQuarter ( )
  {
    if ( $this->lastOfQuarterYear() == $this )
      return clone $this;

    return $this->addMonth(-3)->lastOfQuarterYear();
  }

  public function NextFirst ( )
  {
    if ( $this->month < 12 )
      return new Datum(sprintf("%s-%02d-01",$this->year,$this->month + 1));
    
    return new Datum(sprintf("%s-01-01",$this->year+1));
  }

  public function PreviousLast ( )
  {
    return new Datum(date("Y-m-d",$this->FirstOfMonth()->InSeconds() - 24 * 3600));
  }

  public function PreviousDay ( )
  {
    return new Datum(date("Y-m-d",$this->InSeconds() - 24 * 3600));
  }

  public static function IsValidDate ( $dateString )
  {
    if ( preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/',$dateString) == 0 )
      return false;

    return date("Y-m-d",StrToTime($dateString)) == $dateString;
  }

  public static function StrToDate ( $dateString )
  {
    if ( preg_match('/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{2})$/',$dateString, $match) )
      $dateString = sprintf("20%02d-%02d-%02d", $match[3], $match[2], $match[1]);
    elseif ( preg_match('/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})/',$dateString, $match) )
      $dateString = sprintf("%04d-%02d-%02d", $match[3], $match[2], $match[1]);
    elseif ( preg_match('/^([0-9]{1,2})\.([0-9]{1,2})(\.)?$/',$dateString, $match) )
      $dateString = sprintf("%04d-%02d-%02d", date('Y'), $match[2], $match[1]);
    elseif ( preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2})$/',$dateString, $match) )
      $dateString = sprintf("20%02d-%02d-%02d", $match[3], $match[2], $match[1]);
    elseif ( preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})/',$dateString, $match) )
      $dateString = sprintf("%04d-%02d-%02d", $match[3], $match[2], $match[1]);
    elseif ( preg_match('/^([0-9]{1,2})\/([0-9]{1,2})(\/)?$/',$dateString, $match) )
      $dateString = sprintf("%04d-%02d-%02d", date('Y'), $match[2], $match[1]);
    elseif ( preg_match('/^([0-9]{2})([0-9]{2})([0-9]{4})$/',$dateString, $match) )
      $dateString = sprintf("%04d-%02d-%02d",$match[3],$match[2],$match[1]);

    return $dateString;
  }

  public function Before ( Datum $after )
  {
    return $this->InSeconds() < $after->InSeconds();
  }

  public function Format ( $format = "d.m.Y" )
  {
    return date($format,$this->InSeconds());
  }

  public static function ToDay ( )
  {
    return new Datum(date("Y-m-d"));
  }

  public function DateAdd ( $days )
  {
    // zusätzliche 3601 wegen möglicher zeitumstellung ...
    return new Datum(date("Y-m-d",$this->InSeconds() + $days * 24 * 3600 + 3601));
  }

  public function Wochentag ( $id = null )
  {
    if ( $id === null )
      $id = $this->Format('w');

    $tage = array(0 => 'Sonntag',
                  1 => 'Montag',
                  2 => 'Dienstag',
                  3 => 'Mittwoch',
                  4 => 'Donnerstag',
                  5 => 'Freitag',
                  6 => 'Samstag');
    return $tage[$id];
  }

  public function Monatsname ( $id = null )
  {
    if ( $id === null )
      $id = $this->Month();

    $monate = array(1 => 'Januar',
                    2 => 'Februar',
                    3 => 'März',
                    4 => 'April',
                    5 => 'Mai',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'August',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Dezember');
    return $monate[$id];
  }

  public function FirstOfWeek ( )
  {
    $day = $this->Format('w');
    if ( $day == 0 )
      $day = 7;
    return $this->DateAdd(-$day + 1);
  }

  public function LastOfWeek ( )
  {
    $days = 7 - $this->Format('w');
    if ( $days == 7 )
      return clone $this;
    return $this->DateAdd($days);
  }

  public function DateDiff ( Datum $date )
  {
    return (int)(abs($this->InSeconds() - $date->InSeconds()) / 3600 / 24);
  }

  public function Jahrestag ( Datum $date = null )
  {
    if ( $date === null )
      $date = Datum::ToDay();
    return $this->Month() == $date->Month() && $this->Day() == $date->Day();
  }

  public function Alter ( Datum $date = null )
  {
    if ( $date === null )
      $date = Datum::ToDay();
    return $date->Year() - $this->Year();
  }

  public function addYear ( $years )
  {
    $dateString = sprintf('%04d-%02d-%02d',$this->year + $years,$this->month,$this->day);
    if ( !self::isValidDate($dateString) && $this->month == 2 && $this->day == 29 )
      $dateString = sprintf('%04d-%02d-%02d',$this->year + $years,2,28);

    return new Datum($dateString);
  }

  public function addMonth ( $months )
  {
    $year = $this->year;
    $month = $this->month + $months;
    $day = $this->day;
    if ( $month > 12 )
      while ( $month > 12 )
        {
          $year++;
          $month -= 12;
        }
    elseif ( $month < 0 )
      {
        $year = $this->addYear((int)floor($month/12))->Year();
        $month -= (int)floor($month/12) * 12 - 1;
      }
    elseif ( $month == 0 )
      {
        $year = $this->Year() - 1;
        $month = 12;
      }
      
    $dateString = sprintf('%04d-%02d-%02d',$year,$month,$day);
    if ( !self::isValidDate($dateString) && $day >= 29 )
      {
        $day -= 1;
        $dateString = sprintf('%04d-%02d-%02d',$year,$month,$day);
        if ( !self::isValidDate($dateString) && $day >= 29 )
          {
            $day -= 1;
            $dateString = sprintf('%04d-%02d-%02d',$year,$month,$day);
            if ( !self::isValidDate($dateString) && $day >= 29 )
              {
                $day -= 1;
                $dateString = sprintf('%04d-%02d-%02d',$year,$month,$day);
              }
          }
      }

    return new Datum($dateString);
  }

  public static function fromSeconds ( $seconds )
  {
    $before = date_default_timezone_get();
    date_default_timezone_set('UTC');
    $return = new Datum(date('Y-m-d',$seconds));
    date_default_timezone_set($before);
    return $return;
  }

  public static function lastWeekNumberOfYear ( $year )
  {
    $timestamp = strtotime((int)$year.'-W53');
    return date('W',$timestamp) == 53 ? 53 : 52;
  }

  public static function firstDateFromWeekNumberOfCurrentYear ( $weeknumber )
  {
    $weeknumber = (int)$weeknumber;
    self::wochennummerPrüfen($weeknumber);
         
    $timestamp_montag = strtotime(date('Y')."-W".$weeknumber); 
    return new Datum(date("Y-m-d", $timestamp_montag));
  }

  public static function lastDateFromWeekNumberOfCurrentYear ( $weeknumber )
  {
    return self::firstDateFromWeekNumberOfCurrentYear($weeknumber)->lastOfWeek();
  }

  private static function wochennummerPrüfen ( $wochennummer )
  {
    if ( $wochennummer < 1 )
      throw new DatumException('Woche Muss >= 1 sein, übergeben wurde: '.$wochennummer);

    if ( self::lastWeekNumberOfYear(date('Y')) < $wochennummer )
      throw new DatumException('Letzte Woche in diesem Jahr ist '.self::lastWeekNumberOfYear(date('Y')).', übergeben wurde: '.$wochennummer);
  }

}

?>
