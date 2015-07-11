<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty zeit_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     zeit_format<br>
 * Purpose:  format strings via zeit_format
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_zeit_format ( Zeit $zeit )
{
  return $zeit->Format('H:i');
}

/* vim: set expandtab: */

?>
