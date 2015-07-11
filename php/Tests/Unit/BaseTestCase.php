<?php

require_once __DIR__.'/../../Classes/Model/BaseClass.php';
require_once __DIR__.'/../../Classes/Model/BaseClassWithID.php';

require_once __DIR__.'/../../Classes/Exceptions/BasicException.php';

require_once __DIR__.'/../../Classes/Libs/Date/Zeitpunkt.php';
require_once __DIR__.'/../../Classes/Libs/Date/Datumsbereich.php';

class BaseTestCase extends  PHPUnit_Framework_TestCase 
{
  protected function helpAttribute ( $expected, $attributes )
  {
    $this->AssertEquals(count($expected),count($attributes),"Falsche Anzahl von Attributen");
    foreach ( $expected as $name => $value )
      {
        $this->AssertTrue(array_key_exists($name,$attributes),"Attribut $name nicht vorhanden");
        if ( is_array($value) )
          $this->helpAttribute($value,$attributes[$name]);
        else
          $this->AssertEquals($attributes[$name],$value,"Attribute $name hat nicht den richtigen Wert");
      }
  }

}

?>
