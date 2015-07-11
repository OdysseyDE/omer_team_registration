<?php

class Gateway_Beacon extends Gateway_Base
{
  public function find ( $ids )
  {
    $sql = 'SELECT beacons.id, 
                   beacons.kennung,
                   beacons.name
            FROM   beacons
            WHERE  beacons.id IN ';
    $result = $this->findByIds($sql,$ids);

    $beacons = array();
    foreach ( $result as $row )
      $beacons[$row['id']] = new Beacon($row['id'],
                                      $row['kennung'],
                                      $row['name']);

    return $beacons;
  }

  public function findAll ( )
  {
    $sql = 'SELECT id FROM beacons';
    return $this->find($this->getCol($sql));
  }
  
  public function update ( Beacon $beacon )
  {
    $sql = $data = array();
    $this->getValue($beacon->kennung,'kennung',$sql,$data);
    $this->getValue($beacon->name,'name',$sql,$data);
    return $this->updateOrInsert($sql,$data,'beacons',$beacon->id);
  }
  
}

?>
