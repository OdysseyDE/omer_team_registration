<?php

class Datumsbereich implements Iterator
{
  private $start;
  private $end;
  private $current;


  public function __construct ( Datum $start, Datum $end = null )
  {
    $this->start = $start;
    $this->end = $end;
    $this->current=$start;
  }

  
  public function __toString ( )
  {
    return $this->start." - ".$this->end;
  }


  public function Start ( Datum $start = null )
  {
    if ( $start !== null )
      $this->start = $start;
    return $this->start;
  }


  public function End ( Datum $end = null )
  {
    if ( $end !== null )
      $this->end = $end;
    return $this->end;
  }


  public function DateWithin ( Datum $date )
  {
    if ( $date->Before($this->start) )
      return false;

    if ( $this->end !== null && $this->end->Before($date) )
      return false;

    return true;
  }


  public function Length ( )
  {
    if ( $this->end === null )
      return -1;

    if ( $this->end->Before($this->start) )
      return -1;

    return (int)round((($this->end->InSeconds() - $this->start->InSeconds()) / 3600 / 24)) + 1;
  }


  public function Months ( )
  {
    if ( $this->end === null )
      return -1;

    if ( $this->end->Before($this->start) )
      return -1;

    
    if ( $this->start->Month() == $this->end->Month() && $this->start->Year() == $this->end->Year() )
      {
        $wholeMonth = new Datumsbereich($this->start->FirstOfMonth(),$this->start->LastOfMonth());
        return $this->Length() / $wholeMonth->Length();
      }

    $startMonth = new Datumsbereich($this->start,$this->start->LastOfMonth());
    $wholeMonth = new Datumsbereich($this->start->FirstOfMonth(),$this->start->LastOfMonth());
    $total = $startMonth->Length() / $wholeMonth->Length();

    $between = new Datumsbereich($this->start->NextFirst(),$this->end->PreviousLast());
    $total += round($between->Length() / 30);

    $endMonth = new Datumsbereich($this->end->FirstOfMonth(),$this->end);
    $wholeMonth = new Datumsbereich($this->end->FirstOfMonth(),$this->end->LastOfMonth());
    $total += $endMonth->Length() / $wholeMonth->Length();

    if ( $this->start->Day() == $this->end->Day() || ($this->end->month() == 2 && $this->end->day() == $this->end->lastOfMonth()->day() && $this->end->day() < $this->start->day()) )
      $total = (int)round($total);

    return $total;
  }


  public function Monate ( )
  {
    if ( $this->Months() < 0 )
      return array();

    $start = $this->start;
    $monate = array();
    while ( $start->LastOfMonth()->Before($this->end) )
      {
        $monate[] = new Datumsbereich($start,$start->LastOfMonth());
        $start = $start->LastOfMonth()->DateAdd(1);
      }

    if ( $start->Before($this->end) )
      $monate[] = new Datumsbereich($start,$this->end);

    return $monate;
  }


  public function rewind ( )
  {
    $this->current=$this->start;
  }

  public function current ( )
  {
    return clone $this->current;
  }

  public function key ( )
  {
    $key = $this->current->DateDiff($this->start);
    if ( $this->end->Before($this->start->DateAdd($key)) )
      return false;
    return $key;
  }

  public function next ( )
  {
    $this->current=$this->current->DateAdd(1);
    return $this->current;
  }

  public function valid ( )
  {
    return $this->Key() !== false;
  }

}

?>
