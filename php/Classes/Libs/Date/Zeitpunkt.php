<?php

require_once("Datum.php");
require_once("Zeit.php");

class Zeitpunkt 
{
  protected $date;
  protected $time;

  public function __construct ( $dateTime )
  {
    if ( !Zeitpunkt::IsValidDateTime($dateTime) )
      throw new DatumException("Kein gültiges DateTime übergeben: $dateTime.");

    $parts = explode(" ",$dateTime);
    $this->date = new Datum($parts[0]);
    $this->time = new Zeit($parts[1]);

    return TRUE;
  }

  public function __toString ( )
  {
    return $this->date." ".$this->time;
  }
  
  public static function IsValidDateTime ( $dateTimeString )
  {
    if ( preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',$dateTimeString) == 0 )
      return false;

    $before = date_default_timezone_get();
    date_default_timezone_set('UTC');
    $return = date("Y-m-d H:i:s",StrToTime($dateTimeString)) == $dateTimeString;
    date_default_timezone_set($before);
    return $return;
  }

  public static function Now ( )
  {
    return new Zeitpunkt(Datum::ToDay()->__toString()." ".Zeit::Now()->__toString());
  }

  public function Date ( )
  {
    return $this->date;
  }

  public function Time ( )
  {
    return $this->time;
  }

  public function Format ( $dateFormat = "d.m.Y", $timeFormat = "H:i:s", $trenner = " " )
  {
    return $this->date->Format($dateFormat).$trenner.$this->time->Format($timeFormat);
  }

  public function InDateTime ( $timeZone = 'GMT' )
  {
    if ( $timeZone != 'GMT' )
      throw new Exception('Unsupported TimeZone: '.$timeZone);

    $time = $this->time->InSeconds() - 3600;
    if ( date('I') == 1 )
      $time -= 3600;
    $date = $this->date;
    if ( $time < 0 )
      {
        $time += 24*3600;
        $date = $date->DateAdd(-1);
      }
    $time = Zeit::FromSeconds($time);

    return new DateTime($date.' '.$time,new DateTimeZone($timeZone));
  }

  public function AddSeconds ( $seconds )
  {
    return self::fromSeconds($this->inSeconds() + $seconds);
  }


  public function Before ( Zeitpunkt $after )
  {
    return $this->InSeconds() < $after->InSeconds();
  }


  public function InSeconds ( )
  {
    $before = date_default_timezone_get();
    date_default_timezone_set('UTC');
    $seconds = strToTime($this->format('Y-m-d','H:i:s'));
    date_default_timezone_set($before);
    return $seconds;
  }


  public function Diff ( Zeitpunkt $other )
  {
    return abs($this->InSeconds() - $other->InSeconds());
  }

  public static function fromSeconds ( $seconds, $useUTC = true )
  {
    $before = date_default_timezone_get();
    if ( $useUTC )
      date_default_timezone_set('UTC');
    $return = new Zeitpunkt(date('Y-m-d H:i:s',$seconds));
    date_default_timezone_set($before);
    return $return;
  }

}

?>
