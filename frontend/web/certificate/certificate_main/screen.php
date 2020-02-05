<?php
  header('Content-Type: text/html; charset=utf-8');

  include('./config/main.php');

  function getScreenShot($url, $screen, $size, $format = "jpeg",$screen_name){
      $result = "http://mini.s-shot.ru/".$screen."/".$size."/".$format."/?".$url; // делаем запрос к сайту, который делает скрины
      $pic = file_get_contents($result); // получаем данные. Ответ от сайта
      file_put_contents('./tmp/'.$screen_name.".".$format, $pic); // сохраняем полученную картинку
    }

    if(isset($_GET['idCompany']) && isset($_GET['idTest']) && isset($_GET['userName']) && isset($_GET['userID'])) {

    $idCompany = (int)$_GET['idCompany'];
    $idTest = (int)$_GET['idTest'];
    $userName = (string)$_GET['userName'];
    $user_id = (int)$_GET['userID'];

    $screen_name = md5(microtime() . rand(0, 9999));
    getScreenShot("https://profinavigator.ru/certificate/certificate_main/index.php?idCompany=".$idCompany."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id, "1366", "0", "jpeg",$screen_name);

    #$qrGenerate = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=https://profinavigator.ru/certificate/".$screen_name.".pdf";

  }

 
 
  $images = 'https://profinavigator.ru/certificate/certificate_main/tmp/'.$screen_name.'.jpeg';

  $pdf = new Imagick($images);
  $pdf->setImageFormat('pdf');

  $pdf->writeImages('/home/a0245025/domains/profinavigator.ru/public_html/frontend/web/certificate/'.$screen_name.'.pdf', true); 

  #unlink($images);

  #header('Location: /certificate/certificate_main/index.php')
  
  $file_name = $screen_name.'.pdf';
  $file_pdf = "/home/a0245025/domains/profinavigator.ru/public_html/frontend/web/certificate/".$screen_name.".pdf";
  
  $main->userAddLink($screen_name,$user_id,$idTest);

  header("Location: https://profinavigator.ru/certificate/certificate_main/index.php?idCompany=".$idCompany."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id."");
  #header('Content-type: application/pdf');
  #header('Content-Disposition: inline; filename="' . $file_name . '"');
  #header('Content-Transfer-Encoding: binary');
  #header('Content-Length: ' . filesize($file_pdf));
  #header('Accept-Ranges: bytes');
  #@readfile($file_pdf);

?>