<?php

class Event extends BaseClassWithID
{
  protected $name;
  protected $datum;
  protected $aktiv;
  protected $ort;
  protected $informieren;
  protected $formularId;
  
  public function __construct ( $id = null, $name = null, $datum = null, Datumsbereich $aktiv = null, $ort = null, $informieren = null,
                                $formularId = null )
  {
    parent::__construct($id);

    $this->addClassRestriction('aktiv','Datumsbereich');
    
    $this->name = $name;
    $this->datum = $datum;
    $this->aktiv = $aktiv;
    $this->ort = $ort;
    $this->informieren = $informieren;
    $this->formularId = $formularId;
  }

  public function __toString ( )
  {
    return (string)$this->name;
  }
  
}

?>
