<?php

require_once __DIR__.'/../BaseTestCase.php';
require_once __DIR__.'/../../../Classes/Model/User.php';

class UserTest extends BaseTestCase
{
  public function testConstructor ( )
  {
    $user = new User(1,'email');
    $this->assertEquals(1,$user->id);
    $this->assertEquals('email',$user->email);
    $this->assertEquals('email',$user->__toString());
  }

  public function testEmptyConstructor ( )
  {
    $user = new User;
    $this->assertNull($user->id);
    $this->assertNull($user->email);
    $this->assertEquals('',$user->__toString());
  }

}

?>
