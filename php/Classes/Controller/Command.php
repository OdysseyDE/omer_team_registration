<?php

abstract class Command
{
  public function __construct ( )
  {
  }

  protected function success ( $text = "##TXT_Success##" )
  {
    if ( strpos($text,'##') === 0 )
      $text = $GLOBALS['_NG_LANGUAGE_']->getTranslation(str_replace('##','',$text));

    $_SESSION['message'] = $text;
  }

  protected function failure ( $text = "Es ist ein Fehler aufgetreten" )
  {
    if ( strpos($text,'##') === 0 )
      $text = $GLOBALS['_NG_LANGUAGE_']->getTranslation(str_replace('##','',$text));

    $_SESSION['error'][] = $text;
  }

  protected function hasErrors ( )
  {
    return !empty($_SESSION['error']);
  }

  public function display ( $page = null, $action = null )
  {
    if ( $page !== null )
      $GLOBALS['Where']['Page'] = $page;
    if ( $action !== null )
      $GLOBALS['Where']['Action'] = $action;

    $GLOBALS['Smarty']->assign('where',"page=".$GLOBALS['Where']['Page']."&amp;action=".$GLOBALS['Where']['Action']);
    $GLOBALS['Smarty']->assign('page',$GLOBALS['Where']['Page']);
    $GLOBALS['Smarty']->assign('action',$GLOBALS['Where']['Action']);
    $GLOBALS['Smarty']->assign('mode',$GLOBALS['Settings']['OnServer'] ? "normal" : "dev");
    
    if ( isset($_SESSION['message']) && $_SESSION['message'] > '' )
      {
        $GLOBALS['Smarty']->Assign('message',$_SESSION['message']);
        unset($_SESSION['message']);
      }
                    
    if ( isset($_SESSION['error']) && $_SESSION['error'] > '' )
      {
        $GLOBALS['Smarty']->Assign('errormessage',$_SESSION['error']);
        unset($_SESSION['error']);
      }
                    
    if ( $this->isJson() )
      $this->fetchAndSend();
    else
      $this->executeDisplay();
  }

  protected function fetchAndSend ( )
  {
    $GLOBALS['Smarty']->assign('ajax',true);
    $this->sendAnswer($GLOBALS['Smarty']->fetch('main.tpl'));
  }

  protected function executeDisplay ( )
  {
    $GLOBALS['Smarty']->Display('main.tpl');
  }

  public function isJson ( )
  {
    return false;
  }

  protected function csvExport ( $buffer, $fileName = 'export.csv' )
  {
    header('Content-Type: application/text');
    header('Content-Length: '.strlen($buffer));
    header('Content-disposition: attachment; filename="'.$fileName.'"');
    echo $buffer;
    die();
  }

  protected function sendAnswer ( $result = "" )
  {
    header('Content-Type: application/json');
    echo json_encode($result);
    die();
  }

  protected function redirect ( $page = '', $action = '', $addition = array() )
  {
    $url = 'index.php';
    $params = array();
    if ( $page > '' )
      $params[] = 'page='.$page;
    if ( $action > '' )
      $params[] = 'action='.$action;
    if ( !empty($addition) )
      foreach ( $addition as $name => $value )
        $params[] = $name.'='.$value;
    if ( !empty($params) )
      $url .= '?'.implode('&',$params);
    header('Location: '.$url);
  }

  abstract public function run ( ) ;
}

?>
