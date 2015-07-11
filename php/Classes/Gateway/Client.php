<?php

class Gateway_Client extends Gateway_Base
{
  public function find ( $ids )
  {
    $sql = 'SELECT clients.id, 
                   clients.clientId,
                   clients.name
            FROM   clients
            WHERE  clients.id IN ';
    $result = $this->findByIds($sql,$ids);

    $clients = array();
    foreach ( $result as $row )
      $clients[$row['id']] = new Client($row['id'],
                                        $row['clientId'],
                                        $row['name']);

    return $clients;
  }

  public function findAll ( )
  {
    $sql = 'SELECT id FROM clients';
    return $this->find($this->getCol($sql));
  }
  
  public function update ( Client $client )
  {
    $sql = $data = array();
    $this->getValue($client->clientId,'clientId',$sql,$data);
    $this->getValue($client->name,'name',$sql,$data);
    return $this->updateOrInsert($sql,$data,'clients',$client->id);
  }
  
}

?>
