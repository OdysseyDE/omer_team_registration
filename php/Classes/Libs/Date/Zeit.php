<?php

date_default_timezone_set('Europe/Berlin');

class Zeit
{
  protected $inSeconds;

  public function __construct ( $timeString )
  {
    if ( is_int($timeString) )
      {
        $this->inSeconds = $timeString;
        return;
      }

    if ( !Zeit::IsValidTime($timeString) )
      throw new DatumException("Keine gültige Zeit übergeben: $timeString");
      
    preg_match('/^([0-9]{2}):([0-9]{2}):([0-9]{2})$/',$timeString,$match);
    $this->inSeconds = ($match[1] == 24 ? 0 : $match[1]) * 3600 + $match[2] * 60 + $match[3];
  }

  public function __toString ( )
  {
    return sprintf("%02d:%02d:%02d",$this->hour(),$this->minute(),$this->second());
  }

  public function hour ( )
  {
    return ($this->inSeconds - $this->second() - $this->minute() * 60) / 3600;
  }

  public function minute ( )
  {
    return (($this->inSeconds - $this->second()) / 60) % 60;
  }

  public function second ( )
  {
    return $this->inSeconds % 60;
  }

  public function inSeconds ( )
  {
    return $this->inSeconds;
  }

  public function format ( $format = "H:i:s" )
  {
    $before = date_default_timezone_get();
    date_default_timezone_set('UTC');
    $return = date($format,$this->InSeconds());
    date_default_timezone_set($before);
    return $return;
  }

  public function before ( Zeit $after )
  {
    return $this->InSeconds() < $after->InSeconds();
  }

  public function beforeOrSame ( Zeit $after )
  {
    return $this->InSeconds() <= $after->InSeconds();
  }

  public function addSeconds ( $seconds )
  {
    $seconds = $this->inSeconds() + $seconds;
    if ( $seconds < 0 )
      $seconds = 0;
    if ( $seconds > 86399 )
      $seconds = 86399;
    return self::fromSeconds($seconds);
  }

  public static function fromSeconds ( $seconds )
  {
    if ( $seconds < 0 )
      throw new DatumException('Zeit kann nicht negativ sein: '.$seconds);
    return new Zeit($seconds);
  }

  public static function isValidTime ( $timeString )
  {
    if ( preg_match('/^([0-9]{2}):([0-9]{2}):([0-9]{2})$/',$timeString,$match) == 0 )
      return false;
    
    if ( $match[3] >= 60 )
      return false;

    if ( $match[2] >= 60 )
      return false;

    if ( $match[1] >= 24 )
      {
        if ( $match[1] == 24 && $match[2] == 0 && $match[3] == 0 )
          return true;
        return false;
      }

    return true;
  }

  public static function now ( )
  {
    return new Zeit(date("H:i:s"));
  }

  public static function strToTime ( $timeString )
  {
    if ( preg_match('/^([0-9]{1,2})([:.]([0-9]{1,2})([:,]([0-9]{2}))?)?$/',$timeString, $match) )
      $timeString = sprintf("%02d:%02d:%02d",$match[1],isset($match[3]) ? $match[3] : 0,isset($match[5]) ? $match[5] : 0);

    if ( is_numeric($timeString) && $timeString < 10000 )
      {
        $hours = (int)($timeString/100);
        $minutes = $timeString - $hours * 100;
        if ( $hours < 23 && $minutes < 60 )
          $timeString = sprintf("%02d:%02d:00",$hours,$minutes);
      }

    return $timeString;
  }

}

?>
