<?php

class MultiZeit extends Zeit
{
  public function __construct ( $timeString )
  {
    if ( is_int($timeString) )
      {
        $this->inSeconds = $timeString;
        return;
      }

    if ( !MultiZeit::isValidTime($timeString) )
      throw new DatumException("Keine gültige Zeit übergeben: $timeString");
      
    preg_match('/^(-)?([0-9]*):([0-9]{2}):([0-9]{2})$/',$timeString,$match);

    $this->inSeconds = $match[2] * 3600 + $match[3] * 60 + $match[4];
    if ( $match[1] > '' )
      $this->inSeconds = -$this->inSeconds;
  }

  public static function isValidTime ( $timeString )
  {
    if ( preg_match('/^(-)?([0-9]*):([0-9]{2}):([0-9]{2})$/',$timeString,$match) == 0 )
      return false;
    
    if ( $match[4] >= 60 )
      return false;

    if ( $match[3] >= 60 )
      return false;

    return true;
  }

  public static function fromSeconds ( $seconds )
  {
    $seconds = (int)round($seconds);
    $hours = (int)($seconds / 3600);
    $seconds -= $hours * 3600;
    $minutes = (int)($seconds / 60);
    $seconds -= $minutes * 60;
    return new MultiZeit(sprintf("%02d:%02d:%02d",$hours,$minutes,$seconds));
  }

  public static function fromZeit ( Zeit $zeit )
  {
    return new MultiZeit($zeit);
  }

  public static function now ( )
  {
    return new MultiZeit(date("H:i:s"));
  }

  public function format ( $format = "H:i:s" )
  {
    $format = str_replace('H',sprintf('%02d',$this->hour()),$format);
    $format = str_replace('i',sprintf('%02d',$this->minute()),$format);
    $format = str_replace('s',sprintf('%02d',$this->second()),$format);
    return $format;
  }

  public function add ( MultiZeit $add )
  {
    return self::fromSeconds($this->inSeconds() + $add->inSeconds());
  }

  public function subtract ( MultiZeit $add )
  {
    return self::fromSeconds($this->inSeconds() - $add->inSeconds());
  }

}

?>
