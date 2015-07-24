<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// nao permitir qualquer aviso no pdf
//error_reporting(E_ALL);
set_time_limit(1800);
define('FPDF_FONTPATH','./libs/fpdf/font/');
define('IMGPATH','./images/');
require_once('./libs/fpdf/pdfbarcode128.inc');
require_once('./libs/fpdf/fpdf.php');
//require_once('baseconfig_inc.php');

class DANFE extends FPDF {

        var $num; //numero da NF
        var $empresa = '';
        var $num_nf = '';
        var $serie = '';
        var $additionalPage = false;

        function SetNum($numero){
            //Set numero da NF
            $this->num=$numero;
        }

        function Cabecalho() {

        }

        function Footer() {
            if (!$this->additionalPage) {
                $this->Line(10, 277, 205, 277);
                $this->SetXY(13, 281);
                $this->SetFont('Arial', 'B', 7);
                $this->Write(0, iconv('UTF-8','ISO-8859-1', 'Recebemos de ' . $this->empresa . ' os produtos constantes na nota fiscal eletrônica ao lado.'));
                $this->Rect(10, 278, 195, 15);
                $this->Line(170, 278, 170, 293);
                $this->Line(10, 285, 170, 285);
                $this->Line(60, 285, 60, 293);
                $this->SetXY(11, 285.5);
                $this->SetFont('Arial', 'B', 6);
                $this->Write(2, iconv('UTF-8','ISO-8859-1', 'DATA DE RECEBIMENTO'));
                $this->SetXY(61, 285.5);
                $this->SetFont('Arial', 'B', 6);
                $this->Write(2, iconv('UTF-8','ISO-8859-1', 'ASSINATURA'));

                $this->SetXY(172, 282);
                $this->SetFont('Arial', 'B', 10);
                $this->Write(2, iconv('UTF-8','ISO-8859-1', 'Nº ' . $this->num_nf));

                $this->SetXY(172, 288);
                $this->SetFont('Arial', 'B', 8);
                $this->Write(2, iconv('UTF-8','ISO-8859-1', 'SÉRIE ' . $this->serie));
            }
        }

        function caixaTexto($x,$y,$l,$h,$rotulo,$texto,$tamfont,$alinha = 'L'){
            $this->SetDrawColor(100,100,100);

            $this->Rect($x, $y, $l, $h);
            $posY = 0;
            if ($h > 5) {
                $posY = $y + 3;
            }
            elseif ($h == 5) {
                $posY = $y + 2;
            }
            else {
                $posY = $y + 1;
            }
            
            if (!empty($rotulo)) {
                $this->SetXY($x - 0.5, $y + 0.8);
                $this->SetFont('Arial', '', $tamfont - 2);
                $this->Write(1, $rotulo);
            }

            $this->SetFont('Arial', 'B', $tamfont);
            switch ($alinha) {
                case 'R':
                    $tam = $this->GetStringWidth($texto);
                    //echo ($x - 0.5) + ($l - $tam - 1) . '<br>';
                    //echo $posY;
                    $posX = ($x - 0.5) + ($l - $tam - 1);
                    if ($posX + $tam > 201) {
                        $posX = 203 - $tam;
                    }

                    $this->SetXY($posX, $posY);
                    $this->Write(3, $texto);
                    break;
                case 'C':
                    $tam = $this->GetStringWidth($texto) / 2;
                    $this->SetXY(($x - 0.5) + $tam + 1 , $posY);
                    $this->Write(3, $texto);
                    break;
                default:
                    $this->SetXY(($x - 0.5), $posY);
                    $this->Write(3, $texto);
            }

        }

        // Table
        function fTable($header,$data,$w,$alinh='') {
            //Colors, line width and bold font
            $this->SetFillColor(200,200,200);
            $this->SetTextColor(0,0,0);
            $this->SetDrawColor(100,100,100);
            //$this->SetLineWidth(.3);
            $x = $this->GetX();
            $this->SetFont('Arial','B',8);
            //Header
            //$w=array(20,20,20,20,20);
            for($i=0;$i<count($header);$i++) {
                $this->Cell($w[$i],4,$header[$i],1,0,'C',true);
            }
            $this->Ln();
            //Color and font restoration
            $this->SetFillColor(255,255,255);
            $this->SetFont('Arial','',8);
            //Data
            $fill=false;
            $lin = 0;
            foreach($data as $row) {
              $this->SetX($x);
              for ($n=0;$n<count($w);$n++){
                $alinhamento = 'R';
                if($alinh<>''){
                      $alinhamento = $alinh[$n];
                }
                $this->Cell($w[$n],4,$row[$n],1,0,$alinhamento,$fill);
              }
              //$this->Cell($w[1],3,$row[1],1,0,'R',$fill);
              //$this->Cell($w[2],3,number_format($row[2]),1,0,'R',$fill);
              //$this->Cell($w[3],3,number_format($row[3]),1,0,'R',$fill);
              //$this->Cell($w[4],3,number_format($row[3]),1,0,'R',$fill);
              $this->Ln();

              $fill=!$fill;
           }
           //$this->Cell(array_sum($w),0,'','T');
        }

}
?>