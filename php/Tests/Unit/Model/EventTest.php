<?php

require_once __DIR__.'/../BaseTestCase.php';
require_once __DIR__.'/../../../Classes/Model/Event.php';

class EventTest extends BaseTestCase
{
  public function testConstructor ( )
  {
    $event = new Event(1,'name','Datum oder Datumsbereich',new Datumsbereich(Datum::toDay(),Datum::toDay()->dateAdd(7)),"Location",
                       'email1@mail.de;email2@mail.de',7);
    $this->assertEquals(1,$event->id);
    $this->assertEquals('name',$event->name);
    $this->assertEquals('Datum oder Datumsbereich',$event->datum);
    $this->assertEquals(new Datumsbereich(Datum::toDay(),Datum::toDay()->dateAdd(7)),$event->aktiv);
    $this->assertEquals('Location',$event->ort);
    $this->assertEquals('email1@mail.de;email2@mail.de',$event->informieren);
    $this->assertEquals(7,$event->formularId);
    $this->assertEquals('name',$event->__toString());
  }

  public function testEmptyConstructor ( )
  {
    $event = new Event;
    $this->assertNull($event->id);
    $this->assertNull($event->name);
    $this->assertNull($event->datum);
    $this->assertNull($event->aktiv);
    $this->assertNull($event->ort);
    $this->assertNull($event->informieren);
    $this->assertNull($event->formularId);
    $this->assertEquals('',$event->__toString());
  }

}

?>
