<?php
/** kullandigimiz kutuphane cagiriliyor */
include 'wex/excel/Classes/PHPExcel/IOFactory.php';


if(isset($_POST['mb']))
    if(isset($_POST['mb_content']))
    {
        $content = unserialize(base64_decode($_POST['mb_content']));
        // Excel Değişkeni ile Classımızı başlatıyoruz.
        $Excel = new PHPExcel();

// Oluşturacağımız Excel Dosyasının ayarlarını yapıyoruz.
// Bu bilgiler O kadar önenli değil kafanıza göre doldurabilirsiniz.
        $Excel->getProperties()->setCreator("Admin")
            ->setLastModifiedBy("Admin")
            ->setTitle("Musteri Bilgi Listesi")
            ->setSubject("Musteri Bilgi Listesi")
            ->setDescription("Musteri Bilgi Listesi")
            ->setKeywords("Tam Liste")
            ->setCategory("Tam Liste");

//Excel Dosyasının Sayfasını Adını Belirliyoruz
        $Excel->getActiveSheet()->setTitle('Sayfa1');

        $ord = ord('A');

//Başlıklar
        $mb_text = array(
            "Siparis NO: ",
            "Ad Soyad: ",
            "E-Mail: ",
            "Telefon Numarasi: ",
            "Adres: "
        );

        for($i = 0; $i < count($mb_text); $i++)
        {
            $Excel->getActiveSheet()->setCellValue(chr(($ord+$i)).'1', ''.$mb_text[$i]);
        }

        $tur = 2;//her tursa bir alt satira gececegimiz icin sayac kullanıcaz
        $offset = 0;
        for($i = 0; $i < count($content); $i++)
        {
            for($j = 0; $j < count($content[$i]); $j++)
            {

                $Excel->getActiveSheet()->setCellValue(chr(($ord+$offset))."$tur", $content[$i][$j]);
                $offset++;
            }
            $offset = 0;
            $tur++;
        }

        //olusturulan excel dosyası kaydediliyor
        $Kaydet = PHPExcel_IOFactory::createWriter($Excel, 'Excel5');

        //kullanıcı excel dosyasına yonlendiriliyor
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=musteri_bilgi_listesi.xls");

        $Kaydet->save('php://output');

    }

if(isset($_POST['ksl']))
    if(isset($_POST['ksl_content']))
    {
        $content = unserialize(base64_decode($_POST['ksl_content']));

        // Excel Değişkeni ile Classımızı başlatıyoruz.
        $Excel = new PHPExcel();

// Oluşturacağımız Excel Dosyasının ayarlarını yapıyoruz.
// Bu bilgiler O kadar önenli değil kafanıza göre doldurabilirsiniz.
        $Excel->getProperties()->setCreator("Admin")
            ->setLastModifiedBy("Admin")
            ->setTitle("Kesin Siparis Listesi")
            ->setSubject("Tam Liste")
            ->setDescription("Kesin Siparis Listesi")
            ->setKeywords("Tam Liste")
            ->setCategory("Tam Liste");

//Excel Dosyasının Sayfasını Adını Belirliyoruz
        $Excel->getActiveSheet()->setTitle('Sayfa1');

        $ord = ord('A');

//Başlıklar
        $ksl_text = array(
            "Siparis NO: ",
            "Ad Soyad: ",
            "T.C/Vergi NO: ",
            "Vergi Dairesi: ",
            "Siparis Verilen Urunler:",
            "Toplam Tutar: ",
            "E-Mail: ",
            "Telefon Numarasi: ",
            "Adres: "
        );

        for($i = 0; $i < count($ksl_text); $i++)
        {
            $Excel->getActiveSheet()->setCellValue(chr(($ord+$i)).'1', ''.$ksl_text[$i]);
        }

        $tur = 2;//her tursa bir alt satira gececegimiz icin sayac kullanıcaz
        $offset = 0;
        //print_r($content);
        for($i = 0; $i < count($content); $i++)
        {
            for($j = 0; $j < count($content[$i]); $j++)
            {
                if($j == 4)
                {
                    //print_r($content[$i][$j]);
                    $text = "";
                    for($k = 0; $k < count($content[$i][$j][0]); $k++)
                    {
                        $text .= "URUN ID: ".$content[$i][$j][0][$k]." ".$content[$i][$j][1][$k]." ".$content[$i][$j][2][$k]." ADET ".$content[$i][$j][3][$k]." TL\n";

                    }
                    $Excel->getActiveSheet()->setCellValue(chr(($ord+$offset))."$tur", $text);
                    $Excel->getActiveSheet()->getStyle(chr(($ord+$offset))."$tur")->getAlignment()->setWrapText(true);
                }else
                    {
                        $Excel->getActiveSheet()->setCellValue(chr(($ord+$offset))."$tur", $content[$i][$j]);
                    }
                $offset++;

            }
            $offset = 0;
            $tur++;
        }

        //olusturulan excel dosyası kaydediliyor
        $Kaydet = PHPExcel_IOFactory::createWriter($Excel, 'Excel5');

        //kullanıcı excel dosyasına yonlendiriliyor
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=kesin_siparis_listesi.xls");

        $Kaydet->save('php://output');


    }

?>