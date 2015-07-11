<?php

class WrapperFactory
{
  public static function create ( $key )
  {
    $scheme = 'https';
      
    $url = $scheme.'://'.$GLOBALS['Settings']['smoiceApi'].'/';

    return new smoice\Wrapper($key,$url);
  }

}

?>
