<?php

abstract class FormHandler implements FormHandlerInterface
{
  protected $request;
  protected $post;
  protected $get;

  final public function __construct ( $request, $post, $get )
  {
    $this->request = $request;
    $this->post = $post;
    $this->get = $get;
  }

  protected function failure ( $text = "Es ist ein Fehler aufgetreten" )
  {
    if ( strpos($text,'##') === 0 )
      $text = $GLOBALS['_NG_LANGUAGE_']->getTranslation(str_replace('##','',$text));

    $_SESSION['error'][] = $text;
  }

}

?>
