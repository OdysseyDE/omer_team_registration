<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty amount_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     amount_format<br>
 * Purpose:  format strings via amount_format
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_amount_format ( $amount, $decimal = 2, $dec_point = ",", $thousand_sep = "." )
{
  return number_format($amount->Amount(),$decimal,$dec_point,$thousand_sep);
}

/* vim: set expandtab: */

?>
