<?php

require_once __DIR__.'/../BaseTestCase.php';
require_once __DIR__.'/../../../Classes/Model/Formular.php';

class FormularTest extends BaseTestCase
{
  public function testConstructor ( )
  {
    $formular = new Formular(1,'name');
    $this->assertEquals(1,$formular->id);
    $this->assertEquals('name',$formular->name);
    $this->assertEquals('name',$formular->__toString());
  }

  public function testEmptyConstructor ( )
  {
    $formular = new Formular;
    $this->assertNull($formular->id);
    $this->assertNull($formular->name);
    $this->assertEquals('',$formular->__toString());
  }

  public function testElemente ( )
  {
  }
  
}

?>
