#!/usr/bin/php
<?php

require_once('../php/include/init.php');
require_once('functions.php');

$info = false;
foreach ( $argv as $parameter )
  if ( $parameter == "--info" )
    $info = true;

$result = $db->getAll("SELECT id, filename, insertTime FROM _updates JOIN ids USING (id)",array(),false);
$done = array();
if ( !empty($result) )
  foreach ( $result as $row )
    $done[strToLower($row['filename'])] = $row;

$dir = ".";
$files = array();
if ( $dh = opendir($dir) )
{
  while ( ($file = readdir($dh)) !== false )
    $files[] = $file;
  closedir($dh);
}
else
{
  echo "Konnte Verzeichnis nicht öffnen.\n\n";
  echo "\n\nBeendet\n\n";
  die();
}
sort($files);

foreach ( $files as $file )
{
  if ( preg_match("/^[0-9]+.*\.php$/", $file) )
    {
      $thisOneDone = isset($done[strToLower($file)]);
      if ( $info )
	{
	  echo "$file ";
	  if ( $thisOneDone )
	    echo date("d.m.Y H:i",StrToTime($done[strToLower($file)]['insertTime']))." Uhr \n";
	  else
	    echo "noch nicht.\n";
	}
      elseif ( !$thisOneDone )
	{
	  echo "$file ";
	  require_once($file);
          $db->query('INSERT INTO `_updates` SET `filename` = ?',array($file),false);
	  echo "vollständig bearbeitet.\n";
	}
    }
}

?>
