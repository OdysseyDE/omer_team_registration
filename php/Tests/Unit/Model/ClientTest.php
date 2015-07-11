<?php

require_once __DIR__.'/../BaseTestCase.php';
require_once __DIR__.'/../../../Classes/Model/Client.php';

class ClientTest extends BaseTestCase
{
  public function testConstructor ( )
  {
    $client = new Client(1,'clientId','name');
    $this->assertEquals(1,$client->id);
    $this->assertEquals('clientId',$client->clientId);
    $this->assertEquals('name',$client->name);
  }

  public function testEmptyConstructor ( )
  {
    $client = new Client;
    $this->assertNull($client->id);
    $this->assertNull($client->clientId);
    $this->assertNull($client->name);
    $this->assertEquals('',$client->__toString());
  }

  public function testHalberToString ( )
  {
    $client = new Client(null,'clientId');
    $this->assertEquals('clientId',$client->__toString());

    $client = new Client(null,null,'name');
    $this->assertEquals('name',$client->__toString());
  }
  
}

?>
