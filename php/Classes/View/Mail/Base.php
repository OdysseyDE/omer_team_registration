<?php

require_once('markdownify.php');

abstract class Mail_Base extends BaseClass
{
  protected $receipients;
  protected $headers;
  protected $txtBody;
  protected $htmlBody;
  protected $attachments;
  protected $bcc;
  protected $delay;

  protected $wrap;

  public function __construct ( )
  {
    $this->receipients = "";
    $this->headers = array('From' => 'SMOICE <support@smoice.com>',
                           'Return-Path' =>  'SMOICE <system@smoice.com>',
                           'Subject' => '',
                           'X-SMOICE-MailType' => 'Standard');
    $this->txtBody = "";
    $this->htmlBody = null;
    $this->attachments = array();
    $this->wrap = 79;
    $this->delay = 0;
  }

  public function addAttachment ( Attachment $attachment )
  {
    $this->attachments[] = $attachment;
  }

  public function createTextBody ( ) 
  {
  }

  public function createBodies ( )
  {
    $this->createHtmlBody();
    if ( $this->htmlBody > '' )
      {
        $md = new Markdownify(true,false,false);
        //$this->txtBody = str_replace('</body></html>','',$md->parseString($this->htmlBody));
        $this->wrap($md->parseString($this->htmlBody));
      }
    else
      $this->createTextBody();
  }

  protected function createHtmlBody ( )
  {
  }

  public function sending ( $alternateRecipient = null )
  {
    $this->createBodies();
    return $this->send($alternateRecipient);
  }

  protected function send ( $alternateRecipient = null )
  {
    $mime = new Mail_mime(array("head_charset" => "utf-8", "text_charset" => "utf-8", "html_charset" => "utf-8", 'eol' => "\n"));

    $mime->setTXTBody($this->txtBody);
    if ( $this->htmlBody !== null )
      $mime->setHTMLBody($this->htmlBody);

    if ( !empty($this->attachments) )
      foreach ( $this->attachments as $attachment )
        $mime->addAttachment($attachment->File(),$attachment->Type());

    $this->headers['To'] = $this->receipients;
    $this->headers['Sender'] = $this->headers['From'];

    $empfaenger = $this->receipients;
    if ( $this->bcc !== null )
      $this->receipients .= ($this->receipients > '' ? ',' : '').$this->bcc;

    //do not ever try to call these lines in reverse order
    $body = $mime->get();
    $headers = $mime->headers($this->headers,true);
    if ( $this->receipients > '' )
      {
        if ( !$GLOBALS['Settings']['OnServer'] )
          $this->receipients = 'christian@smoice.com';
        elseif ( $alternateRecipient )
          $this->receipients = $alternateRecipient;

        $mail_queue = new Mail_Queue($GLOBALS['Settings']['MailQueue']['db_options'],
                                     $GLOBALS['Settings']['MailQueue']['mail_options']);
        $mail_queue->put($this->headers['From'],$this->receipients,$headers,$body,$this->delay);
      }

    return true;
  }

  protected function stringPad ( $string, $length, $before = false )
  {
    if ( mb_strlen($string,'utf8') > $length ) 
      return mb_substr($string,0,$length,'utf8');
    
    $begin = mb_strlen($string,'utf8');
    for ( $i = $begin; $i < $length; $i++ )
      if ( $before )
        $string = ' '.$string;
      else
        $string .= ' ';

    return $string;
  }

  protected function wrap ( $text )
  {
    $this->txtBody .= wordwrap($text,$this->wrap);
  }

  public function subject ( )
  {
    return $this->headers['Subject'];
  }

  public function from ( )
  {
    return $this->headers['From'];
  }

  final public function mailType ( $type = null )
  {
    if ( $type !== null )
      $this->headers['X-SMOICE-MailType'] = $type;
    return $this->headers['X-SMOICE-MailType'];
  }

  public function receipients ( )
  {
    return $this->receipients;
  }

  protected function enumerate ( $items )
  {
    $counter = 1;

    $length = 3 + (int)log10(count($items));
    foreach ( $items as $item )
      {
        $lines = explode("\n",wordwrap($item,$this->wrap - $length));
        $lines[0] = sprintf('% '.($length-2).'d. %s',$counter++,$lines[0]);
        if ( count($lines) > 1 )
          for ( $i = 1; $i < count($lines); $i++ )
            $lines[$i] = sprintf('% '.$length.'s%s','',$lines[$i]);
            
        $this->txtBody .= implode("\n",$lines)."\n";
      }
  }

  protected function mfg ( )
  {
    $text = $GLOBALS['_NG_LANGUAGE_']->getTranslation('MAIL_MFG');
    $this->wrap("$text\n\n");
  }

  protected function mfgHtml ( )
  {
    $this->htmlBody .= '<p>'.$GLOBALS['_NG_LANGUAGE_']->getTranslation('MAIL_MFG').'</p>';
  }

  protected function smoiceTeam ( )
  {
    $this->wrap($GLOBALS['_NG_LANGUAGE_']->getTranslation('MAIL_IhrTeam')."\n\n");
  }

  protected function smoiceTeamHtml ( )
  {
    $this->htmlBody .= '<p>'.$GLOBALS['_NG_LANGUAGE_']->getTranslation('MAIL_IhrTeam').'</p>';
  }

  protected function smoiceFooter ( )
  {
    $this->txtBody .= "-------------------------------------------------------------------------------\n";
    $this->txtBody .= "SMOICE UG (haftungsbeschränkt)\n";
    $this->txtBody .= "Kastanienallee 71\n";
    $this->txtBody .= "10435 Berlin\n\n";
    $this->txtBody .= "Telefon: +49 - (0) 30 - 89006716\n";
    $this->txtBody .= "E-Mail:  support@smoice.com\n\n";
    $this->txtBody .= "Geschäftsführung: Dipl-Inf. Christian Anger\n";
    $this->txtBody .= "Sitz: Berlin; Amtsgericht Berlin-Charlottenburg, HRB 145673 B\n";
    $this->txtBody .= "-------------------------------------------------------------------------------\n";
  }

  protected function smoiceFooterHtml ( )
  {
    $this->htmlBody .= "<hr /><p>";
    $this->htmlBody .= "SMOICE UG (haftungsbeschränkt)<br />";
    $this->htmlBody .= "Kastanienallee 71<br />";
    $this->htmlBody .= "10435 Berlin<br /><br />";
    $this->htmlBody .= "Telefon: +49 &ndash; (0) 30 &ndash; 89006716<br />";
    $this->htmlBody .= "E&ndash;Mail:  support@smoice.com<br /><br />";
    $this->htmlBody .= "Geschäftsführung: Dipl&ndash;Inf. Christian Anger<br />";
    $this->htmlBody .= "Sitz: Berlin; Amtsgericht Berlin&ndash;Charlottenburg, HRB 145673 B";
    $this->htmlBody .= "</p><hr />";
  }

  protected function htmlHeader ( $smoice = true )
  {
    $this->htmlBody = '<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <style>
      body ';
    if ( $smoice )
      $this->htmlBody .= '{ background: url("http://www.smoice.com/smoice_logo_web_small.jpg") 5px 5px no-repeat; margin-top: 65px; }';
    else
      $this->htmlBody .= '{ background: margin: 5px; }';
    $this->htmlBody .= '
      p.greeting { font-weight: bold; }
      p.upgrade a { display: block; background: url("http://www.smoice.com/preistabelle.jpg") no-repeat; width: 600px; height: 199px; }
      p.upgrade a span { visibility: hidden; }
      ul { list-style: none; }
      ul.bullet { list-style: outside circle; }
    </style>
  </head>
  <body>
    <h2>'.$this->headers['Subject'].'</h2>
';
  }

  protected function htmlFooter ( )
  {
    $this->htmlBody .= '</body></html>';
  }

  public function greeting ( Employee $employee, $style = 'formell' )
  {
    return $GLOBALS['_NG_LANGUAGE_']->getGreeting($employee->address->salutation,$employee->address->name,$style);
  }

  public function email ( $email )
  {
    return '<a href="mailto:'.$email.'">'.$email.'</a>';
  }

  public function link ( $title, $link )
  {
    if ( strpos($title,'##') === 0 )
      $title = $GLOBALS['_NG_LANGUAGE_']->getTranslation(str_replace('##','',$title));
    return '<a href="'.$link.'">'.$title.'</a>';
  }

  protected function absatz ( $text, $class = null )
  {
    if ( strpos($text,'##') === 0 )
      $text = $GLOBALS['_NG_LANGUAGE_']->getTranslation(str_replace('##','',$text));
    $this->htmlBody .= '<p'.($class === null ? '' : ' class="'.$class.'"').'>'.$text.'</p>';
  }
    
  protected function ol ( $lis )
  {
    $this->htmlBody .= '<ol>';
    foreach ( $lis as $li )
      {
        if ( strpos($li,'##') === 0 )
          $li = $GLOBALS['_NG_LANGUAGE_']->getTranslation(str_replace('##','',$li));
        $this->htmlBody .= '<li>'.$li.'</li>';
      }
    $this->htmlBody .= '</ol>';
  }

}

?>
