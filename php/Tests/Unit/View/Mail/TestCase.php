<?php

require_once __DIR__.'/../../BaseTestCase.php';
require_once __DIR__.'/../../../Classes/View/Mail/Base.php';

abstract class Mail_TestCase extends BaseTestCase
{
  protected $mail;
  protected $createBodies;
  protected $company;

  public function __construct ( $name = NULL, array $data = array(), $dataName = '')
  {
    parent::__construct($name,$data,$dataName);
    $this->createBodies = false;
  }

  protected function setUp ( )
  {
    $GLOBALS['Debugging'] = true;
    $GLOBALS['OnServer'] = false;
  }

  abstract protected function getMailBodiesBase ( ) ;

  final protected function makePath ( $addition = null, $html = false )
  {
    $fileName = __DIR__.'/TestMailBodies/';
    $fileName .= $this->getMailBodiesBase();
    $fileName .= $addition;
    $fileName .= $html ? '.html' : '.txt';
    return $fileName;
  }

  final protected function getHtmlBody ( $addition = null )
  {
    return $this->getMailBody($addition,true);
  }

  final protected function getMailBody ( $addition = null, $html = false )
  {
    if ( $this->createBodies )
      $this->createMailFile($addition,$html);

    $content = @file_get_contents($this->makePath($addition,$html));
    $this->assertNotInternalType('boolean',$content,'Datei '.$this->makePath($addition,$html).' konnte nicht geladen werden.');
    return $content;
  }

  final private function createMailFile ( $addition = null, $html = false )
  {
    $fh = fopen($this->makePath($addition,$html),'w');
    fputs($fh,$html ? $this->mail->htmlBody : $this->mail->txtBody);
    fclose($fh);
  }

}

?>
