<?php

class Position extends BaseClassWithID
{
  protected $beaconId;
  protected $clientId;
  protected $distance;
  protected $battery;
  protected $timestamp;

  public function __construct ( $id = null, $beaconId = null, $clientId = null, $distance = null, $battery = null, Zeitpunkt $timestamp = null )
  {
    parent::__construct($id);

    $this->addClassRestriction('timestamp','Zeitpunkt');
    
    $this->beaconId = $beaconId;
    $this->clientId = $clientId;
    $this->distance = $distance;
    $this->battery = $battery;
    $this->timestamp = $timestamp;
  }
  
}

?>
