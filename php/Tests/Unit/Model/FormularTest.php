<?php

require_once __DIR__.'/../BaseTestCase.php';
require_once __DIR__.'/../../../Classes/Model/Formular.php';
require_once __DIR__.'/../../../Classes/Model/FormularElement.php';

class FormularTest extends BaseTestCase
{
  public function testConstructor ( )
  {
    $formular = new Formular(1,'name');
    $this->assertEquals(1,$formular->id);
    $this->assertEquals('name',$formular->name);
    $this->assertEquals('name',$formular->__toString());
    $this->assertEmpty($formular->elemente);
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
    $formular = new Formular;
    $formularElement = new FormularElement(1,'label','typ',true);

    $formular->addElement($formularElement);
    $this->assertCount(1,$formular->elemente);

    $elemente = $formular->elemente;
    $element = reset($elemente);
    $this->assertEquals($formularElement,$element);
  }
  
}

?>
