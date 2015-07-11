<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty number_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     number_format<br>
 * Purpose:  format strings via number_format
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_number_format ( $float, $decimal = 2 )
{
  $dec_point = ",";
  $thousand_sep = ".";
  return number_format($float, $decimal, $dec_point, $thousand_sep);
}

/* vim: set expandtab: */

?>
