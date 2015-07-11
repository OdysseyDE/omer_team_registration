<?php

if ( false === function_exists('lcfirst') ):
  function lcfirst( $str )
  { return (string)(strtolower(substr($str,0,1)).substr($str,1));}
endif;

// Pflichtangaben, die local/config enthalten sein müssen
$pflichtAngaben = array('DB' => array('Host',
                                      'Database',
                                      'User',
                                      'Password',
                                      ),
                        );

// falls keine local/config existiert, anlegen
$localConf = dirname(__FILE__).'/../local/config.php';
if ( !file_exists($localConf) )
  {
    if ( ($fh = @fopen($localConf,'w')) === false )
      die("Nicht möglich, $localConf anzulegen, Rechteproblem?");

    fputs($fh,"<?php\n");
    foreach ( $pflichtAngaben as $title => $angaben )
      {
        if ( !is_array($angaben) )
          fputs($fh,"\$GLOBALS['Settings']['$angaben'] = '';\n");
        else
          foreach($angaben as $angabe )
            fputs($fh,"\$GLOBALS['Settings']['$title']['$angabe'] = '';\n");
        fputs($fh,"\n");
      }
    fputs($fh,"?>\n");
  } 

require_once('config.php');
require_once($localConf);

// prüfen, ob alle Pflichtangabe gesetzt sind
foreach ( $pflichtAngaben as $title => $angaben )
{
  foreach ( $angaben as $angabe )
    {
      if ( !isset($GLOBALS['Settings'][$title][$angabe]) || $GLOBALS['Settings'][$title][$angabe] == '' )
        die("$title-$angabe fehlt in der local_config.php");
    }
}

$GLOBALS['Debugging'] = 0;

// Path to template files
define('TEMPLATE_DIR', $GLOBALS['Settings']['RootPath']."/smarty/templates/");
define('PICTURE_DIR', $GLOBALS['Settings']['RootPath']."/smarty/cache");

$smarty_path = $GLOBALS['Settings']['RootPath']."/php/Classes/Libs/Smarty";
$paths = array($GLOBALS['Settings']['RootPath'],
	       $GLOBALS['Settings']['RootPath']."/php/include",
	       $GLOBALS['Settings']['RootPath']."/php/lang",

	       $GLOBALS['Settings']['RootPath']."/php/Classes",
	       $GLOBALS['Settings']['RootPath']."/php/Classes/Controller",
	       $GLOBALS['Settings']['RootPath']."/php/Classes/Exceptions",
	       $GLOBALS['Settings']['RootPath']."/php/Classes/Model",
	       $GLOBALS['Settings']['RootPath']."/php/Classes/Libs",
	       $GLOBALS['Settings']['RootPath']."/php/Classes/Libs/Date",
	       $GLOBALS['Settings']['RootPath']."/php/Classes/Libs/Money",
	       $GLOBALS['Settings']['RootPath']."/php/Classes/View",
	       
               $smarty_path,
	       );
ini_set('include_path',implode(":",$paths));

function autoload ( $class )
{
  if ( $class == 'Smarty' )
    include_once("Smarty.class.php");
  else
    include_once(str_replace('_','/',$class).".php");
}
spl_autoload_register('autoload');

set_exception_handler('ExceptionHandler');
set_error_handler('ErrorHandler');

function errhndlOffline ($err) 
{
  $body = "<h1>FEHLER</h1>".chr(10);
  $body .= $err->getMessage()."<br>".chr(10);
  $body .= $err->getUserInfo()."<br>".chr(10);
  $body .= "<div>Backtrace:</div>".chr(10);
  $body .= "<ul>".chr(10);
  $backtrace = $err->getBackTrace();
  foreach ($backtrace as $trace)
    {
      if ( is_array($trace['args']) && strToLower(get_class($trace['args'][0])) != 'smarty' )
	$body .= "<li>".$trace['file'].": ".$trace['line']." - ".$trace['function']."(".implode(', ',$trace['args']).") </li>".chr(10);
      else
	$body .= "<li>".$trace['file'].": ".$trace['line']." - ".$trace['function']."(".$trace['args'].") </li>".chr(10);
    }
  $body .= "</ul>".chr(10);
  echo $body;
  die();
}

function ExceptionHandler ( $exception )
{
  if ( $GLOBALS['Settings']['OnServer'] )
    echo "Es ist eine schwerer Fehler aufgetreten. Die Anwendung wird beendet.";
  else
    print_r($exception);
  die();
}

function ErrorHandler ( $fehlercode, $fehlertext, $fehlerdatei, $fehlerzeile )
{
  if ( in_array($fehlercode,array(E_NOTICE,E_USER_NOTICE,E_STRICT,E_DEPRECATED,2)) )
    return true;

  echo $fehlercode." ".$fehlertext." ".$fehlerdatei." ".$fehlerzeile;
  die();
}

$GLOBALS['Smarty'] = new Smarty_MultiLang();
$GLOBALS['Smarty']->language->loadTranslationTable('de',$GLOBALS['Settings']['RootPath']."/smarty/languages");

$GLOBALS['Smarty']->template_dir = TEMPLATE_DIR;
$GLOBALS['Smarty']->compile_dir = $GLOBALS['Settings']['RootPath'].'/smarty/compile';
$GLOBALS['Smarty']->cache_dir = $GLOBALS['Settings']['RootPath'].'/smarty/cache';
$GLOBALS['Smarty']->plugins_dir = array($smarty_path."/plugins",$GLOBALS['Settings']['RootPath'].'/smarty/plugins');

// Change comment on these when you're done developing to improve performance
$GLOBALS['Smarty']->force_compile = true;
$GLOBALS['Smarty']->caching = 2; // Lebensdauer ist pro Cache

// Standardwert für '$cache_lifetime' auf 0 setzen
$GLOBALS['Smarty']->cache_lifetime = 0;

//session_name("");
session_start();


?>
