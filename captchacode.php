<?php
  session_start();
  unset($_SESSION['captchacode']);
  
  $moeglicheZeichen = "ABCDEFGHIKLMNPQRSTUVWXY123456789";
  $captcha = rand(0, 1);
  if($captcha == "0")
  {
    $anzahlZeichen = 5;
  }
  if($captcha == "1")
  {
    $anzahlZeichen = rand(5, 9);
  }
  
  $captchacode = "";
  
  for($i = 0; $i < $anzahlZeichen; $i++)
    {
      $captchacode .= substr($moeglicheZeichen, (rand()%(strlen($moeglicheZeichen))), 1);    
    }
    

  $_SESSION['captchacode'] = $captchacode;
  


  header('Content-type: image/jpg');
  
  if($captcha == "1")
  {
    $img = ImageCreateFromJPEG('images/captcha_back_2.jpeg');
  }
  if($captcha == "0")
  {
    $img = ImageCreateFromJPEG('images/captcha_back.jpeg');
  }
  

  $farbe = ImageColorAllocate($img, rand(0, 55), rand(0, 55), rand(0, 55));
  $ttf = "images/font.ttf";

  if($captcha == "0")
  {
    $groesse = 18;  // Schriftgröße
  }
  if($captcha == "1")
  {
    $groesse = 24;
  }

  $winkel = rand(0, 5);  // Winkel der Schrift (Zufallswert)

  $x = rand(15, 20);   // Horizontale Position (Zufallswert)  

  $y = 26;  // Vertikale Position (Schriftgröße + Abstand zum Rand)
  
  if($captcha == "1")
  {
    $y = $y+10;
  }
  
  imagettftext($img, $groesse, $winkel, $x, $y, $farbe, $ttf, $captchacode);
  imagejpeg($img);
  imagedestroy($img);
  
?>