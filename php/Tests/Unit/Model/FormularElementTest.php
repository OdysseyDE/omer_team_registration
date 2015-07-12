<?php

require_once __DIR__.'/../BaseTestCase.php';
require_once __DIR__.'/../../../Classes/Model/FormularElement.php';

class FormularElementTest extends BaseTestCase
{
  public function testConstructor ( )
  {
    $formularElement = new FormularElement(1,'label','typ',true,'placeholder');
    $this->assertEquals(1,$formularElement->id);
    $this->assertEquals('label',$formularElement->label);
    $this->assertEquals('typ',$formularElement->typ);
    $this->assertTrue($formularElement->required);
    $this->assertEquals('placeholder',$formularElement->placeholder);
  }

  public function testEmptyConstructor ( )
  {
    $formularElement = new FormularElement;
    $this->assertNull($formularElement->id);
    $this->assertNull($formularElement->label);
    $this->assertNull($formularElement->typ);
    $this->assertFalse($formularElement->required);
    $this->assertNull($formularElement->placeholder);
  }

}

?>
