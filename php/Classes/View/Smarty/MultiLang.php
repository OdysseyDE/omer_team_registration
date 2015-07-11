<?php

/**
* smarty_prefilter_i18n()
* This function takes the language file, and rips it into the template
* $GLOBALS['_NG_LANGUAGE_'] is not unset anymore
*
* @param $tpl_source
* @return
**/
function smarty_prefilter_i18n($tpl_source, &$smarty) 
{
  if ( !is_object($GLOBALS['_NG_LANGUAGE_'])) 
    {
      die("Error loading Multilanguage Support");
    }

  // Now replace the matched language strings with the entry in the file
  return preg_replace_callback('/##(.+?)##/', '_compile_lang', $tpl_source);
}

/**
 * _compile_lang
 * Called by smarty_prefilter_i18n function it processes every language
 * identifier, and inserts the language string in its place.
 *
*/

function _compile_lang($key) {
  return $GLOBALS['_NG_LANGUAGE_']->getTranslation($key[1]);
}

class Smarty_MultiLang extends Smarty 
{
  public $language;

  public function __construct ( $locale = "de" ) 
  {
    parent::__construct(); 
    // Multilanguage Support
    // use $smarty->language->setLocale() to change the language of your template
    //     $smarty->loadTranslationTable() to load custom translation tables
    $this->language = new Smarty_Language($locale); // create a new language object
    $GLOBALS['_NG_LANGUAGE_'] = $this->language;
      
    $this->registerFilter('pre','smarty_prefilter_i18n');
  }

  public function fetch ( $_smarty_tpl_file, $_smarty_cache_id = null, $_smarty_compile_id = null, $_smarty_parent = null, $_smarty_display = false ) 
  {
    // We need to set the cache id and the compile id so a new script will be
    // compiled for each language. This makes things really fast ;-)
    $_smarty_compile_id = $this->language->getCurrentLanguage().'-'.$_smarty_compile_id;
    $_smarty_cache_id = $_smarty_compile_id;
    // Now call parent method
    return parent::fetch( $_smarty_tpl_file, $_smarty_cache_id, $_smarty_compile_id, $_smarty_parent, $_smarty_display);
  }

  /**
   * test to see if valid cache exists for this template
   *
   * @param string $tpl_file name of template file
   * @param string $cache_id
   * @param string $compile_id
   * @return string|false results of {@link _read_cache_file()}
   */
  public function is_cached ( $tpl_file, $cache_id = null, $compile_id = null ) 
  {
    if ( !$this->caching )
      return false;

    if ( !isset($compile_id) ) 
      {
        $compile_id = $this->language->getCurrentLanguage().'-'.$this->compile_id;
        $cache_id = $compile_id;
        return parent::is_cached($tpl_file, $cache_id, $compile_id);
      }
  }

}

?>
