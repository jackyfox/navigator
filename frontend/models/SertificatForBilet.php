<?php

namespace frontend\models;
use Yii;
use yii\db\Query;
use Dompdf\Dompdf;

class SertificatForBilet extends yii\base\Model {
   public function createDompdf()
    {
        $userId = Yii::$app->user->identity->id;
        $userSurname = Yii::$app->user->identity->first_name;
        $userName = Yii::$app->user->identity->last_name;

        // instantiate and use the dompdf class
        if (!empty($userId) && !empty($userSurname) && !empty($userName)) {

            $sertTitle ="Сертификат за прохождение игры проекта билет в будущее";
            $sertName ="certForBiletGame.pdf";

            $dir = $_SERVER['DOCUMENT_ROOT'].'/frontend/web/upload/profile/'.$userId;
            $link = $dir.'/certificate/'.$sertName;
            if (!file_exists($link)){
                $dompdf = new Dompdf();
                $us = $userName." ".$userSurname;
                    $html = '
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <style type="text/css">
                                * { 
                                  font-family: "DejaVu Sans" !important;
                                }
                                @page {
                                  size: 21cm 29.7cm;
                                  margin: 0;
                                }
                                /* конец следующие свойство убирает рамку*/
                                
                                body {
                                    background: url("../web/img/sertificat/bilet-cert-bg.jpg") 6% 10% no-repeat;
                                }
                                h1,h2,p {
                                    color: #000;
                                    text-align: center;
                                }
                                .title p{
                                    margin-top: 0;
                                    padding:0;
                                }
                                h1 {
                                    text-align: center; 
                                    margin-top: 450px;
                                    font-size: 65px;
                                    margin-bottom: 0px;
                                }
                                h2 {
                                    font-size: 40px;
                                }
                                .info p {
                                    color: #fff;
                                    font-size: 12px;
                                    text-align: right;
                                    padding: 0px 75px;
                                    margin: 0;
                                }   
                                h3 {
                                    margin:0;
                                    color: #fff;
                                    padding: 0px 75px;
                                    text-align: right;
                                    text-transform: uppercase;
                                    font-size: 14px;
                                }               
                                .info {
                                    margin-top: 290px;

                                }
                            </style>
                        </head>
                        <body>
                        <div class="title">
                            <h1>Сертификат</h1>
                            <p>о прохождении профессионального тестирования<br>в проекте «Билет в будущее» получает</p>
                            <h2>'.$us.'</h2>
                        </div>
                        <div class="info">
                            <p>Узнать о востребованных и перспективных профессиях <br>  на современном рынке труда, найти подходящее учебное заведение <br> и узнать о запросах работодателей вы всегда можете на сайте <br> ГИС «Навигатор профессий Санкт-Петербурга»</p>
                            <h3>profinavigator.ru</h3>
                            <p>САНКТ-ПУТЕРБУРГ, 2019</p>
                        </div>
                        </body>
                    </html>
                ';
                $dompdf->loadHtml($html, 'UTF-8');

                // (Optional) Setup the paper size and orientation
                //$dompdf->setPaper('A4', 'landscape');
                $dompdf->setPaper('A4', 'portrait');

                // Render the HTML as PDF
                $dompdf->render();

                // Вывод файла в браузер или на скачку:
                //$dompdf->stream('sertificat_'.$us.''); 

                //создание необходимых каталогов для сохранения на сервере
                if (!file_exists($dir)) mkdir($dir, 0777, true);
                if (!file_exists($dir.'/certificate')) mkdir($dir.'/certificate', 0777, true);
                if (!file_exists($dir.'/certificate')) mkdir($dir.'/certificate', 0777, true);

                $link = "upload/profile/".$userId."/certificate/".$sertName;
                // Сохранение на сервере:
                $pdf = $dompdf->output();
                file_put_contents($link, $pdf);

                //вставим в бд что нагенерили
                Yii::$app->db->createCommand("INSERT INTO `profile_has_portfolio`(`id_user`, `title`, `link`) 
                    VALUES ($userId,'$sertTitle','$link')")->execute();

                //почистить куки
                unset($_COOKIE['gameCookie']);
                setcookie("gameCookie", null, time() - 3600, "/", ".profinavigator.ru");

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}