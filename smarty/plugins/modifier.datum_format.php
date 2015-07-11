<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty datum_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     datum_format<br>
 * Purpose:  format strings via datum_format
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_datum_format ( Datum $datum )
{
  return $datum->Format();
}

/* vim: set expandtab: */

?>
