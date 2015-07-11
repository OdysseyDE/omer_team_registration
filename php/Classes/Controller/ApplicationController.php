<?php

final class ApplicationController extends Command
{
  private $page;
  private $action;
  private $command;
  private $klassenName;

  public function __construct ( $page = null, $action = null )
  {
    parent::__construct();
    $this->page = $page ? ucfirst($page) : 'Main';
    $this->action = $action ? ucfirst($action) : 'Index';
    $this->command = $this->klassenName = null;
  }

  public function run ( )
  {
    $this->initializeSmartyEnviroment();
    $this->buildCommand();
    $this->executeCommand();
  }

  private function initializeSmartyEnviroment ( )
  {
    $GLOBALS['Smarty']->assign('Settings',$GLOBALS['Settings']);
    $GLOBALS['Smarty']->assign('message',false);
    $GLOBALS['Smarty']->assign('errormessage',false);
  }

  private function buildCommand ( )
  {
    if ( $this->wartungsModusIstAktiv() )
      $this->wartungsCommandAuswählen();

    $this->commandKlassenNamenAusParamenternBauen();
    $this->parameterInGlobalsSpeichern();

    $this->klassenExistenzBehandeln();
    $this->constructCommand();
    $this->fügeFormularVerarbeiterHinzu();
  }

  private function executeCommand ( )
  {
    //$this->command->menu();
    $this->command->run();
    $this->command->display();
  }

  private function wartungsModusIstAktiv ( )
  {
    return $GLOBALS['Settings']['Wartung'];
  }

  private function wartungsCommandAuswählen ( )
  {
    $this->page = 'Main';
    $this->action = 'Wartung';
  }

  private function commandKlassenNamenAusParamenternBauen ( )
  {
    $this->klassenName = $this->page.'_'.$this->action.'Command';
  }

  private function parameterInGlobalsSpeichern ( )
  {
    $GLOBALS['Where'] = array('Page' => $this->page,
                              'Action' => $this->action);
  }

  private function klassenExistenzBehandeln ( )
  {
    if ( !class_exists($this->klassenName) )
      {
        $command = new Main_NotFoundCommand($this->klassenName);
        $command->run();
      }
  }

  private function constructCommand ( )
  {
    $this->command = new $this->klassenName;
  }

  private function fügeFormularVerarbeiterHinzu ( )
  {
    $formularVerarbeiterName = $this->page.'_'.$this->action.'FormHandler';
    if ( class_exists($formularVerarbeiterName) )
      {
        $formHandler = new $formularVerarbeiterName($_REQUEST,$_POST,$_GET);
        $this->command->formHandler = $formHandler;
      }
  }

}
?>
