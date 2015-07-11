<?php

class Smarty_Language 
{
   private $translationTable;        // currently loaded translation table
   private $defaultLocale;           // the default language
   private $currentLocale;           // currently set locale
   private $currentLanguage;         // currently loaded language
   private $languageTable;           // array of language to file associations
   private $loadedTranslationTables; // array of all loaded translation tables

   public function __construct ( $locale = "" ) 
   {
     $this->languageTable = array(
                                  "de" => "deu",
                                  "de-anwalt" => "deuAnwalt",
                                  "en" => "eng",
                                  "en-us" => "eng",
                                  "en-gb" => "eng",
                                  "fr" => "fra",
                                  );

     $this->translationTable = array();
     $this->loadedTranslationTables = array();

     foreach ($this->languageTable as $lang)
       $this->translationTable[$lang] = array();

     $this->defaultLocale = 'de';

     if ( empty($locale) )
       $locale = $this->defaultLocale;

     $this->setCurrentLocale($locale);
   }

   public function getAvailableLocales ( )
   {
     return array_keys($this->languageTable);
   }

   public function getAvailableLanguages ( )
   {
     return array_unique(array_values($this->languageTable));
   }

   public function getCurrentLanguage ( )
   {
     return $this->currentLanguage;
   }

   public function setCurrentLanguage ( $language )
   {
     $this->currentLanguage = $language;
   }

   public function getCurrentLocale ( )
   {
     return $this->currentLocale;
   }

   public function setCurrentLocale ( $locale )
   {
     $language = $this->languageTable[$locale];
     if (empty($language)) {
       die ("LANGUAGE Error: Unsupported locale '$locale'");
     }
     $this->currentLocale = $locale;
     return $this->setCurrentLanguage($language);
   }

   public function getDefaultLocale ( )
   {
     return $this->defaultLocale;
   }

   public function loadTranslationTable ( $locale, $path )
   {
     if (empty($locale))
       $locale = $this->defaultLocale;

     $language = $this->languageTable[$locale];

     if ( empty($language) ) 
       die ("LANGUAGE Error: Unsupported locale '$locale'");

     if ( !is_array($this->translationTable[$language]) )
       die ("LANGUAGE Error: Language '$language' not available");

     $path .= "/$language.lng";

     if ( isset($this->loadedTranslationTables[$language]) 
          && in_array($path, $this->loadedTranslationTables[$language]) )
       // Translation table was already loaded
       return true;

     if ( file_exists($path) ) 
       {
         $entries = file($path);
         $this->translationTable[$language][$path] = array();
         $this->loadedTranslationTables[$language][] = $path;
         foreach ( $entries as $row )
           {
             if ( substr(ltrim($row),0,2) == '//' ) // ignore comments
               continue;

             $keyValuePair = explode('=',$row);
             // multiline values: the first line with an equal sign '=' will start a new key=value pair
             if ( sizeof($keyValuePair) == 1 ) 
               {
                 $this->translationTable[$language][$path][$key] .= chop(' ' . $keyValuePair[0]);
                 continue;
               }

             $key = trim($keyValuePair[0]);
             $value = $keyValuePair[1];
             if ( !empty($key) ) 
               $this->translationTable[$language][$path][$key] = chop($value);
           }
         return true;
       }

     return false;
   }

   public function getTranslation ( $key ) 
   {
     $trans = $this->translationTable[$this->currentLanguage];
     if ( is_array($trans) ) 
       foreach ($this->loadedTranslationTables[$this->currentLanguage] as $table) 
         if (isset($trans[$table][$key])) 
           return $trans[$table][$key];
     return $key;
   }

}

?>
