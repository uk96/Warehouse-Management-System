<?php 
  class Mail {
    
    public function sendMailTable() {
        $msg = "First line of text\nSecond line of text";
        $msg = wordwrap($msg,70);
        mail("","My subject",$msg);   
    }
  }
?>