<?php

require_once __DIR__.'/../BaseTestCase.php';
require_once __DIR__.'/../../../Classes/Model/Event.php';

class EventTest extends BaseTestCase
{
  public function testConstructor ( )
  {
    $event = new Event(1,'name');
    $this->assertEquals(1,$event->id);
    $this->assertEquals('name',$event->name);
    $this->assertEquals('name',$event->__toString());
  }

  public function testEmptyConstructor ( )
  {
    $event = new Event;
    $this->assertNull($event->id);
    $this->assertNull($event->name);
    $this->assertEquals('',$event->__toString());
  }

}

?>
