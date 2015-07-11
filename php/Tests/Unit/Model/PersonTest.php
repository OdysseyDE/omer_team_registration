<?php

require_once __DIR__.'/../BaseTestCase.php';
require_once __DIR__.'/../../../Classes/Model/Person.php';

class PersonTest extends BaseTestCase
{
  public function testConstructor ( )
  {
    $user = new Person(1,'vorname','name','email');
    $this->assertEquals(1,$user->id);
    $this->assertEquals('vorname',$user->vorname);
    $this->assertEquals('name',$user->name);
    $this->assertEquals('email',$user->email);
    $this->assertEquals('vorname name',$user->__toString());
  }

  public function testEmptyConstructor ( )
  {
    $user = new Person;
    $this->assertNull($user->id);
    $this->assertNull($user->vorname);
    $this->assertNull($user->name);
    $this->assertNull($user->email);
    $this->assertEquals('',$user->__toString());
  }

}

?>
