<?php

class Gateway_Position extends Gateway_Base
{
  public function find ( $ids )
  {
    $sql = 'SELECT positions.id,
                   positions.beacon,
                   positions.client,
                   positions.distance,
                   positions.battery,
                   positions.timestamp
           FROM    positions WHERE positions.id IN ';
    $result = $this->findByIds($sql,$ids);

    $positions = array();
    foreach ( $result as $row )
      $positions[$row['id']] = new Position($row['id'],$row['beacon'],$row['client'],$row['distance'],$row['battery'],new Zeitpunkt($row['timestamp']));
    return $positions;
  }
  
  public function findNewest ( )
  {
    $sql = 'SELECT max(id) FROM positions GROUP BY beacon';
    return $this->find($this->getCol($sql));
  }
  
  public function update ( Position $position )
  {
    $sql = $data = array();
    $this->getValue($position->beaconId,'beacon',$sql,$data);
    $this->getValue($position->clientId,'client',$sql,$data);
    $this->getValue($position->distance,'distance',$sql,$data);
    $this->getValue($position->battery,'battery',$sql,$data);
    $this->getValue($position->timestamp->__toString(),'timestamp',$sql,$data);
    return $this->updateOrInsert($sql,$data,'positions',$position->id);
  }
  
}

?>
