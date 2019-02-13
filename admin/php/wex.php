<?php



require_once ("wex/pdf/fpdf.php");

class WexRepPDF extends FPDF
{


    function Header($header_title)
    {
        // Logo ayarlanır
        $this->Image('../../images/icons/logo-01.png',10,5,40, 22);

        // Yazı rengi ayarlanır
        $this->SetTextColor(0,0,140);

        // Satır 25 pixel içeriden başlasın
        $this->Cell(80);

        // Satıra yazı yazılır
        $this->Write (2, ''.$header_title);

        // 4 pixel aşağıda yeni satıra geç
        $this->Ln(4);

        // Satır 25 pixel içeriden başlasın
        $this->Cell(165);

        // Arial italic 8
        $this->SetFont('Arial','',8);
        // Yazı rengi ayarlanır
        $this->SetTextColor(0,70,80);
        // Satıra yazı yazılır
        $this->Write (10, ''.date("d-m-Y"));
        // 15 pixel aşağıda yeni satıra geç
        $this->Ln(5);

        // Satır 160 pixel içeriden başlasın
        $this->Cell(160);

        // Satıra yazı yazılır
        $this->Write (10, 'optimumilac.com', 'https://optimumilac.com/');
        // 10 pixel aşağıda yeni satıra geç
        $this->Ln(10);

        // X koordinatı
        $x = $this->GetX();
        // Y Koordinatı
        $y = $this->GetY();
        // Düz çizgi çizilir
        $this->Line( $x, $y , $x + 185, $y );

        // 5 pixel aşağıda yeni satıra geç
        $this->Ln(5);
    }

    function Content($content, $type)
    {

        if($type == "mb")
        {

            //Is Content Interface
            $mb_text = array(
                "Siparis NO: ",
                "Ad Soyad: ",
                "E-Mail: ",
                "Telefon Numarasi: ",
                "Adres: "
            );

            //Content Container Var
            $set_container_width = 185;
            $set_container_height = 7;
            $set_container_padding = 1;

            //Content Var
            $set_content_margin_top_bot = 4;
            $set_content_margin_left = 5;

            $set_content_text_padding = 5;


            $count_page = 0;

            $height_to_page = 0;


            foreach ($content as $item)
            {
                // X koordinatı
                $x = $this->GetX();
                // Y Koordinatı
                $y = $this->GetY();
                // Düz çizgi çizilir
                $this->Line( $x, $y , $x + $set_container_width, $y );


                $this->Ln($set_content_margin_top_bot);

                $text_offset = array();
                array_push($text_offset, 0);
                $counter = 0;

                for($i = 0; $i < count($mb_text); $i++)
                {
                    if($i != count($mb_text)-1)
                    {
                        if($text_offset[$counter]+$set_content_margin_left + mb_strlen($mb_text[$i], 'UTF-8') + $set_content_margin_left + mb_strlen($item[$i], 'UTF-8')*(14/9) > 185)
                        {
                            array_push($text_offset, 0);
                            $counter++;

                            $this->Ln(($set_content_text_padding * (count($text_offset)-1)));
                            $this->writeText(0,$set_content_margin_left + $text_offset[$counter], $mb_text[$i],8,0,60,70);
                            $text_offset[$counter] += $set_content_margin_left + mb_strlen($mb_text[$i], 'UTF-8');

                            if($i == 5)
                            {
                                $this->writeText(0,$set_content_margin_left+$text_offset[$counter], $item[$i].' TL',8,0,60,70);
                                $text_offset[$counter] += $set_content_margin_left + mb_strlen($item[$i].' TL', 'UTF-8')*(14/9);
                            }else
                            {
                                $this->writeText(0,$set_content_margin_left+$text_offset[$counter], $item[$i],8,0,60,70);
                                $text_offset[$counter] += $set_content_margin_left + mb_strlen($item[$i], 'UTF-8')*(14/9);
                            }

                            $this->Ln(-($set_content_text_padding * (count($text_offset)-1)));

                        }else
                        {

                            $this->Ln(($set_content_text_padding * (count($text_offset)-1)));

                            $this->writeText(0,$set_content_margin_left + $text_offset[$counter], $mb_text[$i],8,0,60,70);
                            $text_offset[$counter] += $set_content_margin_left + mb_strlen($mb_text[$i], 'UTF-8');

                            $this->writeText(0,$set_content_margin_left+$text_offset[$counter], $item[$i],8,0,60,70);
                            $text_offset[$counter] += $set_content_margin_left + mb_strlen($item[$i], 'UTF-8')*(14/9);

                            $this->Ln(-($set_content_text_padding * (count($text_offset)-1)));
                        }
                    }else
                        {
                            if($text_offset[count($text_offset)-1] + $set_content_margin_left + $set_content_margin_left+mb_strlen($mb_text[$i],'UTF-8')+2+mb_strlen($item[$i], 'UTF-8')*(14/9) > 185)
                            {
                                array_push($text_offset, 0);

                                $this->Ln(($set_content_text_padding * (count($text_offset)-1)));
                                $this->writeText(0,$set_content_margin_left, $mb_text[$i],8,0,60,70);
                                $this->writeText(0,$set_content_margin_left+mb_strlen($mb_text[$i],'UTF-8')+2, $item[$i],8,0,60,70);
                                $this->Ln(-($set_content_text_padding * (count($text_offset)-1)));
                            }else
                            {
                                $this->Ln(($set_content_text_padding * (count($text_offset)-1)));
                                $this->writeText(0,$set_content_margin_left + $text_offset[count($text_offset)-1], $mb_text[$i],8,0,60,70);
                                $text_offset[count($text_offset)-1] += $set_content_margin_left;
                                $this->writeText(0,$set_content_margin_left+mb_strlen($mb_text[$i],'UTF-8')+ $text_offset[count($text_offset)-1] +2, $item[$i],8,0,60,70);
                                $text_offset[count($text_offset)-1] += $set_content_margin_left+mb_strlen($mb_text[$i],'UTF-8')+2;
                                $this->Ln(-($set_content_text_padding * (count($text_offset)-1)));
                            }
                        }
                }

                // Yukarıdan Verilen Margin geri iade edilir
                $this->Ln(-$set_content_margin_top_bot);

                // X koordinatı
                $x = $this->GetX();
                // Y Koordinatı
                $y = $this->GetY();
                //Yazı Satırı Kadar Yükseklik Çizgileri Eklenir
                $this->Line($x, $y, $x, $y+($set_container_height * count($text_offset)));
                $this->Line($x+$set_container_width, $y, $x+$set_container_width, $y+$set_container_height * count($text_offset));

                ////Yazı Satırı Kadar Yükseklik Çizgileri Eklenir
                $this->Ln($set_container_height * count($text_offset));

                $x = $this->GetX();
                // Y Koordinatı
                $y = $this->GetY();
                //Yatay kapatma çizgisi ile Container Kapatılır
                $this->Line( $x, $y , $x + $set_container_width, $y );
                //Containerler Arası 1px Pad Atılır
                $this->Ln($set_container_padding);

                $max_offset = count($text_offset);
                $height_to_page += $max_offset * $set_container_height;
                if($height_to_page > 200)
                {
                    $this->AddPage('Musteri Bilgi Listesi');

                    $count_page++;
                    $text_offset = array();
                    $height_to_page = 0;
                }
            }

        }else if($type == "ksl")
        {

            //Is Content Interface
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


            //Content Container Var
            $set_container_width = 185;
            $set_container_height = 7;
            $set_container_padding = 1;

            //Content Var
            $set_content_margin_top_bot = 4;
            $set_content_margin_left = 5;

            $set_content_text_padding = 5;


            $count_page = 0;

            $height_to_page = 0;

            foreach ($content as $item)
            {

                    // X koordinatı
                    $x = $this->GetX();
                    // Y Koordinatı
                    $y = $this->GetY();
                    // Düz çizgi çizilir
                    $this->Line( $x, $y , $x + $set_container_width, $y );


                    $this->Ln($set_content_margin_top_bot);

                    $text_offset = array();
                    array_push($text_offset, 0);
                    $counter = 0;
                    for($i = 0; $i < count($ksl_text); $i++)
                    {
                        if($i != count($ksl_text)-1)
                        {
                            if($i == 4)
                            {
                                array_push($text_offset, 0);
                                $counter++;

                                $this->Ln(($set_content_text_padding * (count($text_offset)-1)));
                                $this->writeText(0,$set_content_margin_left + $text_offset[$counter], $ksl_text[$i],8,0,60,70);
                                $text_offset[$counter] += $set_content_margin_left + mb_strlen($ksl_text[$i], 'UTF-8');

                                $this->Ln(-($set_content_text_padding * (count($text_offset)-1)));



                                for($j = 0; $j < count($item[$i][0]); $j++)
                                {
                                    array_push($text_offset, 0);
                                    $counter++;

                                    $this->Ln(($set_content_text_padding * (count($text_offset)-1)));
                                    $this->writeText(0,$set_content_margin_left + $text_offset[$counter], 'Urun-'.($j+1).': ',8,0,60,70);
                                    $text_offset[$counter] += $set_content_margin_left + mb_strlen('Urun-'.($j+1).': ', 'UTF-8');

                                    $this->writeText(0,$set_content_margin_left+$text_offset[$counter], $item[$i][0][$j],8,0,60,70);
                                    $text_offset[$counter] += $set_content_margin_left + mb_strlen($item[$i][0][$j], 'UTF-8')*(14/9);

                                    $this->writeText(0,$set_content_margin_left+$text_offset[$counter], $item[$i][1][$j],8,0,60,70);
                                    $text_offset[$counter] += $set_content_margin_left + mb_strlen($item[$i][1][$j], 'UTF-8')*(14/9);

                                    $this->writeText(0,$set_content_margin_left+$text_offset[$counter], $item[$i][2][$j].' Adet',8,0,60,70);
                                    $text_offset[$counter] += $set_content_margin_left + mb_strlen($item[$i][2][$j].' Adet', 'UTF-8')*(14/9);

                                    $this->writeText(0,$set_content_margin_left+$text_offset[$counter], $item[$i][3][$j].' TL',8,0,60,70);
                                    $text_offset[$counter] += $set_content_margin_left + mb_strlen($item[$i][3][$j].' TL', 'UTF-8')*(14/9);
                                    $this->Ln(-($set_content_text_padding * (count($text_offset)-1)));




                                }

                            }else
                                {
                                    if($text_offset[$counter]+$set_content_margin_left + mb_strlen($ksl_text[$i], 'UTF-8') + $set_content_margin_left + mb_strlen($item[$i], 'UTF-8')*(14/9) > 185)
                                    {
                                        array_push($text_offset, 0);
                                        $counter++;

                                        $this->Ln(($set_content_text_padding * (count($text_offset)-1)));
                                        $this->writeText(0,$set_content_margin_left + $text_offset[$counter], $ksl_text[$i],8,0,60,70);
                                        $text_offset[$counter] += $set_content_margin_left + mb_strlen($ksl_text[$i], 'UTF-8');

                                        if($i == 5)
                                        {
                                            $this->writeText(0,$set_content_margin_left+$text_offset[$counter], $item[$i].' TL',8,0,60,70);
                                            $text_offset[$counter] += $set_content_margin_left + mb_strlen($item[$i].' TL', 'UTF-8')*(14/9);
                                        }else
                                            {
                                                $this->writeText(0,$set_content_margin_left+$text_offset[$counter], $item[$i],8,0,60,70);
                                                $text_offset[$counter] += $set_content_margin_left + mb_strlen($item[$i], 'UTF-8')*(14/9);
                                            }

                                        $this->Ln(-($set_content_text_padding * (count($text_offset)-1)));

                                    }else
                                    {

                                        $this->Ln(($set_content_text_padding * (count($text_offset)-1)));
                                        $this->writeText(0,$set_content_margin_left + $text_offset[$counter], $ksl_text[$i],8,0,60,70);
                                        $text_offset[$counter] += $set_content_margin_left + mb_strlen($ksl_text[$i], 'UTF-8');

                                        if($i == 5)
                                        {
                                            $this->writeText(0,$set_content_margin_left+$text_offset[$counter], $item[$i].' TL',8,0,60,70);
                                            $text_offset[$counter] += $set_content_margin_left + mb_strlen($item[$i].' TL', 'UTF-8')*(14/9);
                                        }else
                                        {
                                            $this->writeText(0,$set_content_margin_left+$text_offset[$counter], $item[$i],8,0,60,70);
                                            $text_offset[$counter] += $set_content_margin_left + mb_strlen($item[$i], 'UTF-8')*(14/9);
                                        }
                                        $this->Ln(-($set_content_text_padding * (count($text_offset)-1)));
                                    }
                                }



                        }else
                        {
                            if($text_offset[count($text_offset)-1] + $set_content_margin_left + $set_content_margin_left+mb_strlen($ksl_text[$i],'UTF-8')+2+mb_strlen($item[$i], 'UTF-8')*(14/9) > 185)
                            {
                                array_push($text_offset, 0);

                                $this->Ln(($set_content_text_padding * (count($text_offset)-1)));
                                $this->writeText(0,$set_content_margin_left, $ksl_text[$i],8,0,60,70);
                                $this->writeText(0,$set_content_margin_left+mb_strlen($ksl_text[$i],'UTF-8')+2, $item[$i],8,0,60,70);
                                $this->Ln(-($set_content_text_padding * (count($text_offset)-1)));
                            }else
                            {
                                $this->Ln(($set_content_text_padding * (count($text_offset)-1)));
                                $this->writeText(0,$set_content_margin_left + $text_offset[count($text_offset)-1], $ksl_text[$i],8,0,60,70);
                                $text_offset[count($text_offset)-1] += $set_content_margin_left;
                                $this->writeText(0,$set_content_margin_left+mb_strlen($ksl_text[$i],'UTF-8')+ $text_offset[count($text_offset)-1] +2, $item[$i],8,0,60,70);
                                $text_offset[count($text_offset)-1] += $set_content_margin_left+mb_strlen($ksl_text[$i],'UTF-8')+2;
                                $this->Ln(-($set_content_text_padding * (count($text_offset)-1)));
                            }

                        }
                    }

                    // Yukarıdan Verilen Margin geri iade edilir
                    $this->Ln(-$set_content_margin_top_bot);

                    // X koordinatı
                    $x = $this->GetX();
                    // Y Koordinatı
                    $y = $this->GetY();
                    //Yazı Satırı Kadar Yükseklik Çizgileri Eklenir
                    $this->Line($x, $y, $x, $y+($set_container_height * count($text_offset)));
                    $this->Line($x+$set_container_width, $y, $x+$set_container_width, $y+$set_container_height * count($text_offset));

                    ////Yazı Satırı Kadar Yükseklik Çizgileri Eklenir
                    $this->Ln($set_container_height * count($text_offset));

                    $x = $this->GetX();
                    // Y Koordinatı
                    $y = $this->GetY();
                    //Yatay kapatma çizgisi ile Container Kapatılır
                    $this->Line( $x, $y , $x + $set_container_width, $y );
                    //Containerler Arası 1px Pad Atılır
                    $this->Ln($set_container_padding);

                $max_offset = count($text_offset);
                $height_to_page += $max_offset * $set_container_height;
                if($height_to_page > 200)
                {
                    $this->AddPage('Kesin Siparis Listesi');

                    $count_page++;
                    $text_offset = array();
                    $height_to_page = 0;
                }

            }
        }

    }


    // Sayfa Altı
    function Footer()
    {
        // 15 pıxel sayfa altından yukarıda başla
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Sayfa Numarası
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function writeText($pad, $cell, $text, $txt_size, $r, $g, $b)
    {
        // Arial italic 8
        $this->SetFont('Arial','',$txt_size);
        //Yazıyı Utf-8 yapılır
        $text = iconv('utf-8', 'ISO-8859-9', $text);

        // Yazı rengi ayarlanır
        $this->SetTextColor($r,$g,$b);

        //Content Now Writed..

        $this->Cell($cell);

        $this->Write (0,$text);

        $this->Ln($pad);
    }

    function createPDF($content, $type)
    {
        // Sayfa altında numaraları göstermek için kullanılır
        $this->AliasNbPages();
//Font Ayarlama
        $this->AddFont('Arial','','arial.php');
        $this->SetFont('Arial','',14);

        if($type == "mb")
        {
            $this->AddPage('Musteri Bilgi Listesi');
        }elseif($type == "ksl")
            {
                $this->AddPage('Kesin Siparis Listesi');
            }
        else
            {
                $this->AddPage('');
            }
//Sayfa eklenir


        $this->Content($content, $type);


        $this->Output();
    }
}

if(isset($_POST['mb']))
    if(isset($_POST['mb_content']))
    {
        $content = unserialize(base64_decode($_POST['mb_content']));

        $create_pdf = new WexRepPDF();

        $create_pdf->createPDF($content, "mb");

    }

if(isset($_POST['ksl']))
    if(isset($_POST['ksl_content']))
    {
        $content = unserialize(base64_decode($_POST['ksl_content']));

        $create_pdf = new WexRepPDF();

        $create_pdf->createPDF($content, "ksl");

    }

?>