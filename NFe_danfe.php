<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NFe_danfe
 *
 * @author Marlos
 */
require_once('danfe.php');
require_once('NFe.php');

class NFe_danfe {

    private $NFe = null;
    private $salvar = false;
    
    public function  __construct($NFe, $salvar = false) {
       $this->NFe = new NFe();
       $this->NFe = $NFe;
       $this->salvar = $salvar;
        //$this->init();
    }

    public function geraDANFE() {
    //dados
        // fim dos dados


    // setup do relatorio
        $numero = 1;
        $orientacao = 'P'; //portrait

        // margens
        $margSup = 5;
        $margEsq = 5;
        $margDir = 5;

        // posição inicial do relatorio
        $y = 2;
        $x = 5;

        // Geração do relatorio
        // instancia a classe
        $pdf= new DANFE();
        //                         000000000011111111112222222222333333333344444444445555555555
        //                         012345678901234567890123456789012345678901234567890123456789
        
        // estabelece contagem de paginas
        $pdf->AliasNbPages();
        // fixa as margens
        $pdf->SetMargins($margEsq,$margSup,$margDir);
        $pdf->SetDrawColor(100,100,100);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetAuthor($this->NFe->emit_xNome->valor);
        $pdf->SetNum(2);
        $pdf->Open();
        $pdf->empresa = $this->NFe->emit_xNome->valor;
        $pdf->num_nf = $this->NFe->ide_nNF->valor;
        $pdf->serie = $this->NFe->ide_serie->valor;

        $pdf->SetFont('Arial', '', 5);
        $qtdeItensNota = 40;
        $aProdutos = array();
        $prodInfAdic = array();
        for ($i=0;$i<$this->NFe->countProd();$i++) {
            $prod = $this->NFe->getProd($i);

            $first = true;
            $xProd = $prod->xProd->valor;
            $yProd = '';
            for ($j=0;$j<strlen($xProd);$j++) {
                if (($pdf->GetStringWidth($yProd . $xProd[$j]) > 40) OR ($j == strlen($xProd) - 1)) {
                    if ($j == strlen($xProd) - 1) {
                        $yProd .= $xProd[$j];
                    }

                    if ($first) {
                        $ap = array();
                        $ap [] = $prod->cProd->valor;
                        $ap [] = $yProd;
                        $ap [] = $prod->NCM->valor;
                        if (($this->NFe->emit_CRT->valor == 1) OR ($this->NFe->emit_CRT->valor == 2)) {
                            $ap [] = $prod->ICMSSN_orig->valor . $prod->ICMSSN_CSOSN->valor;
                        }
                        else {
                            $ap [] = $prod->orig->valor . $prod->CST->valor;
                        }                        
                        $ap [] = $prod->CFOP->valor;
                        $ap [] = $prod->uCom->valor;
                        $ap [] = $prod->qCom->periodFloat(4);
                        $ap [] = $prod->vUnCom->periodFloat(4);
                        $ap [] = $prod->vProd->periodFloat(2);
						if (($this->NFe->emit_CRT->valor == 1) OR ($this->NFe->emit_CRT->valor == 2)) {
							$ap [] = $prod->ICMSSN_vBC->periodFloat(2);
							$ap [] = $prod->ICMSSN_vICMS->periodFloat(2);
							//echo 'val: '.$prod->ICMSSN_vBC->getValor();
						}
                        else {
							$ap [] = $prod->vBC->periodFloat(2);
							$ap [] = $prod->vICMS->periodFloat(2);
                        }
							//exit;
						$ap [] = $prod->IPI_vIPI->periodFloat(2);
						$ap [] = $prod->pICMS->periodFloat(2);
                        $ap [] = $prod->IPI_pIPI->periodFloat(2);
                        $aProdutos [] = $ap;
                        if (!empty($prod->infAdProd->valor)) {
                            $inf = array();
                            $inf [] = $prod->cProd->valor;
                            $inf [] = $yProd;
                            $inf [] = $prod->qCom->periodFloat(4);
                            $inf [] = $prod->infAdProd->valor;
                            $prodInfAdic [] = $inf;
                        }
                        $yProd = '';
                        $first = false;
                    }
                    else {
                        $ap = array();
                        $ap [] = '';
                        $ap [] = $yProd;
                        $ap [] = '';
                        $ap [] = '';
                        $ap [] = '';
                        $ap [] = '';
                        $ap [] = '';
                        $ap [] = '';
                        $ap [] = '';
                        $ap [] = '';
                        $ap [] = '';
                        $ap [] = '';
                        $ap [] = '';
                        $ap [] = '';
                        $aProdutos [] = $ap;
                        $yProd = '';
                    }
                }
                $yProd .= $xProd[$j];
            }
        }
        //trigger_error(print_r($aProdutos), E_USER_ERROR);
		$tot_prd = count($aProdutos) - 20;
		$qtdeItensNotaAux = $qtdeItensNota;
		//$total_pag = ceil($tot_prd / $qtdeItensNota);
		//$total_pag += 1;
		//$qtdeItensNota = 20;
		$total_pag = ceil($tot_prd / $qtdeItensNota);
		$total_pag += 1;
		$qtdeProd = count($aProdutos);
        $contProd = 0;
        $limProd = $qtdeItensNota;
        for ($num_pag = 1; $num_pag <= $total_pag; $num_pag++) {
            // adiciona a primeira página
            $pdf->AddPage($orientacao);
			
			if($num_pag == 1)
			{
				$qtdeItensNota = 20;
				$limProd = $qtdeItensNota;
			}
			if($num_pag == 2)
			{
				$qtdeItensNota = 40;
				$limProd += 20;
			}
			//echo $qtdeItensNota.'<br>';
            // coloca o logo
            //$pdf->Image(IMGPATH.'logo_novo_azul.jpg',$x,$y,30,'','jpeg');

            
            //$code->draw_barcode($x, $y, $bar_height, $print_text = false);
            $code = new pdfbarcode128($this->NFe->Id, 1);
            $code->set_pdf_document($pdf);
            $code->draw_barcode(105, 5, 10, false );

            //$code->draw_barcode(130, 3, 22, false );
            //
            //Identificação
            if (!empty($this->NFe->logo) AND file_exists($this->NFe->logo)) {
                $pdf->Image($this->NFe->logo, 10, 9, 15, 15);
                $x = 25;
                $y = 9;
                $pdf->SetTextColor(0,0,0);
                $pdf->SetXY($x,$y);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Write(3, iconv('UTF-8','ISO-8859-1',$this->NFe->emit_xFant->valor));
                $pdf->SetFont('Arial', '', 7);
            }
            else {
                $x = 10;
                
                $y = 9;
                $pdf->SetTextColor(0,0,0);
                $pdf->SetXY($x,$y);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Write(3, iconv('UTF-8','ISO-8859-1',$this->NFe->emit_xFant->valor));
                $pdf->SetFont('Arial', 'B', 7);
            }



            $y += 3;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1',$this->NFe->emit_xNome->valor));

            $y += 3;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1',$this->NFe->enderEmit_xLgr->valor . ' ' . $this->NFe->enderEmit_nro->valor . ' ' . $this->NFe->enderEmit_xCpl->valor));

            $y += 3;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1',$this->NFe->enderEmit_xBairro->valor));

            $y += 3;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1',$this->NFe->enderEmit_xMun->valor . ' - ' . $this->NFe->enderEmit_UF->valor));

            $y += 3;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1',$this->NFe->enderEmit_CEP->valor));

            $y += 3;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1',$this->NFe->enderEmit_fone->valor));


            $x = 75;
            $y = 8;
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1','DANFE'));

            $pdf->SetFont('Arial', 'B', 5);
            $y += 5;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1', 'DOCUMENTO AUXILIAR'));
            $y += 2;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1', 'DA NOTA FISCAL ELETRÔNICA'));
            $pdf->SetFont('Arial', '', 5);
            $y += 3;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1', '0 - ENTRADA'));

            $y += 3;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1', '1 - SAÍDA'));

            $pdf->caixaTexto(95,$y-3,5,5,'',$this->NFe->ide_tpNF->valor,7,'C');
            //$pdf->caixaTexto(14,$y,iconv('UTF-8','ISO-8859-1','Número'), $numero,35,8,16,'R');

            $pdf->SetFont('Arial', 'B', 9);
            $y += 4;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1', 'Nº ' . $this->NFe->ide_nNF->valor));

            $pdf->SetFont('Arial', '', 5);
            $y += 4;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1', 'SÉRIE ' . $this->NFe->ide_serie->valor));

            $y += 3;
            $pdf->SetXY($x,$y);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1', 'FOLHA ' . $num_pag . ' DE ' . $total_pag));

            $pdf->caixaTexto(105,16,100,6,'CHAVE DE ACESSO',$this->NFe->Id,7,'R');
            
            $pdf->caixaTexto(105,22,100,6,iconv('UTF-8','ISO-8859-1','PROTOCOLO DE AUTORIZAÇÃO DE USO'),$this->NFe->nProt . ' ' . substr($this->NFe->dhRecbto,8,2).'/'.substr($this->NFe->dhRecbto,5,2).'/'.substr($this->NFe->dhRecbto,0,4).' '.substr($this->NFe->dhRecbto,11,5),7,'R');
            
            $pdf->caixaTexto(105,28,100,8,'','',7,'R');
            $pdf->SetXY(112,30);
            $pdf->SetFont('Arial', '', 6);            
            $pdf->Write(1, 'Consulta de autenticidade no portal nacional da NF-e http://www.nfe.fazenda.gov.br/portal');
            $pdf->SetXY(140,33);
            $pdf->Write(1, 'ou no site da Sefaz Autorizador');
            
            $x = 10;
            $y = 37;
            $pdf->caixaTexto($x,$y,60,6, iconv('UTF-8','ISO-8859-1', 'NATUREZA DA OPERAÇÃO'), iconv('UTF-8','ISO-8859-1', $this->NFe->ide_natOp->valor),7);

            $x += 60;
            $pdf->caixaTexto($x,$y,40,6, iconv('UTF-8','ISO-8859-1', 'INSCRIÇÃO ESTADUAL'), iconv('UTF-8','ISO-8859-1', $this->NFe->emit_IE->valor),7);

            $x += 40;
            $pdf->caixaTexto($x,$y,40,6, iconv('UTF-8','ISO-8859-1', 'INSCR. ESTADUAL DO SUBST. TRIB.'), iconv('UTF-8','ISO-8859-1', $this->NFe->emit_IEST->valor),7);

            $x += 40;
            $pdf->caixaTexto($x,$y,55,6, iconv('UTF-8','ISO-8859-1', 'CNPJ'), iconv('UTF-8','ISO-8859-1', (empty($this->NFe->emit_CNPJ->valor)?$this->NFe->emit_CPF->valor:$this->NFe->emit_CNPJ->valor)),7);

            $x = 10;
            $y = 44;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1', 'DESTINATÁRIO/REMETENTE'));

            $x = 10;
            $y = 47;
            $pdf->caixaTexto($x,$y,120,6, iconv('UTF-8','ISO-8859-1', 'NOME/RAZÃO SOCIAL'), iconv('UTF-8','ISO-8859-1', $this->NFe->dest_xNome->valor),7);

            $x += 120;
            $pdf->caixaTexto($x,$y,45,6, iconv('UTF-8','ISO-8859-1', 'CNPJ/CPF'), iconv('UTF-8','ISO-8859-1', (empty($this->NFe->dest_CNPJ->valor)?$this->NFe->dest_CPF->valor:$this->NFe->dest_CNPJ->valor)),7);

            $x += 45;
            $pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'DATA DA EMISSÃO'), iconv('UTF-8','ISO-8859-1', $this->NFe->ide_dEmi->data()),7,'C');

            $x = 10;
            $y += 6;
            $pdf->caixaTexto($x,$y,85,6, iconv('UTF-8','ISO-8859-1', 'ENDEREÇO'), iconv('UTF-8','ISO-8859-1', $this->NFe->enderDest_xLgr->valor . ' ' . $this->NFe->enderDest_nro->valor . ' ' . $this->NFe->enderDest_xCpl->valor),7);

            $x += 85;
            $pdf->caixaTexto($x,$y,50,6, iconv('UTF-8','ISO-8859-1', 'BAIRRO/DISTRITO'), iconv('UTF-8','ISO-8859-1', $this->NFe->enderDest_xBairro->valor),7);

            $x += 50;
            $pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'CEP'), iconv('UTF-8','ISO-8859-1', $this->NFe->enderDest_CEP->valor),7);

            $x += 30;
            $pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'DATA DE SAÍDA'), iconv('UTF-8','ISO-8859-1', $this->NFe->ide_dSaiEnt->data()),7,'C');

            $x = 10;
            $y += 6;
            $pdf->caixaTexto($x,$y,75,6, iconv('UTF-8','ISO-8859-1', 'MUNICÍPIO'), iconv('UTF-8','ISO-8859-1', $this->NFe->enderDest_xMun->valor),7);

            $x += 75;
            $pdf->caixaTexto($x,$y,40,6, iconv('UTF-8','ISO-8859-1', 'FONE/FAX'), iconv('UTF-8','ISO-8859-1', $this->NFe->enderDest_fone->valor),7);

            $x += 40;
            $pdf->caixaTexto($x,$y,10,6, iconv('UTF-8','ISO-8859-1', 'UF'), iconv('UTF-8','ISO-8859-1', $this->NFe->enderDest_UF->valor),7);

            $x += 10;
            $pdf->caixaTexto($x,$y,40,6, iconv('UTF-8','ISO-8859-1', 'INSCRIÇÃO ESTADUAL'), iconv('UTF-8','ISO-8859-1', $this->NFe->dest_IE->valor),7);

            $x += 40;
            $pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'HORA DE SAÍDA'), iconv('UTF-8','ISO-8859-1', ''),7,'C');
			
			if($num_pag==1)
			{
				$x = 10;
				$y += 7;
				$pdf->SetXY($x,$y);
				$pdf->SetFont('Arial', 'B', 6);
				$pdf->Write(3, iconv('UTF-8','ISO-8859-1', 'FATURA'));
	
				$aFatura = array();
				$aFatura [] = array('FAT./DUP.', 'VENCIMENTO', 'VALOR', 'FAT./DUP.', 'VENCIMENTO', 'VALOR', 'FAT./DUP.', 'VENCIMENTO', 'VALOR', 'FAT./DUP.', 'VENCIMENTO', 'VALOR', 'FAT./DUP.', 'VENCIMENTO', 'VALOR');
	
				if (!empty($this->NFe->cobr_fat_nFat->valor)) {
					$aFatura [] = array($this->NFe->cobr_fat_nFat->valor, $this->NFe->ide_dEmi->valor, $this->NFe->cobr_fat_vLiq->periodFloat(2), '', '', '', '', '', '', '', '', '', '', '', '');
					$aFatura [] = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
				}
				else {
					$aFatura [] = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
					$aFatura [] = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
					//                   0,  1,  2,  3,  4,  5,  6,  7,  8
					$cd = 0;
					$ld = 1;
	
					for ($i=0;$i<$this->NFe->countDup();$i++) {
						$dup = $this->NFe->getDup($i);
	
						$aFatura[$ld][$cd] = $dup->cobr_dup_nDup->valor;
						$cd++;
						$aFatura[$ld][$cd] = $dup->cobr_dup_dVenc->data();
						$cd++;
						$aFatura[$ld][$cd] = $dup->cobr_dup_vDup->periodFloat(2);
						$cd++;
						if ($cd == 15) {
							$cd = 0;
							$ld++;
						}
					}
				}
	
				$y += 3;
				$pdf->SetXY($x,$y);
				$header=array(13.5,12,13.5, 13.5,12,13.5, 13.5,12,13.5, 13.5,12,13.5, 13.5,12,13.5);
				//Header
				$pdf->SetFont('Arial', 'B', 4);
				for($i=0;$i<count($aFatura[0]);$i++)
					$pdf->Cell($header[$i],2.5,$aFatura[0][$i],1,0,'C');
				$pdf->Ln();
	
				$pdf->SetFont('Arial', 'B', 4);
				for($i=1;$i<5;$i++) {
					$x = 10;
					$y += 2.5;
					$pdf->SetXY($x,$y);
					for($j=0;$j<count($aFatura[0]);$j++)
						$pdf->Cell($header[$j],2.5,$aFatura[$i][$j],1,0,'C');
					$pdf->Ln();
				}
	
				$x = 10;
				$y += 5;
				$pdf->SetXY($x,$y);
				$pdf->SetFont('Arial', 'B', 6);
				$pdf->Write(3, iconv('UTF-8','ISO-8859-1', 'CÁLCULO DO IMPOSTO'));
	
				$y += 3;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,35,6, iconv('UTF-8','ISO-8859-1', 'BASE DE CÁCULO DO ICMS'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vBC->periodFloat(2)),7,'R');
	
				$x += 35;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'VALOR DO ICMS'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vICMS->periodFloat(2)),7,'R');
	
				$x += 30;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'BASE DE CALC. DO ICMS SUBST.'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vBCST->periodFloat(2)),7,'R');
	
				$x += 30;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'VALOR DO ICMS SUBSTITUTO'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vST->periodFloat(2)),7,'R');
	
				$x += 30;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'VALOR DO PIS'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vPIS->periodFloat(2)),7,'R');            
				
				$x += 30;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,40,6, iconv('UTF-8','ISO-8859-1', 'VALOR TOTAL DOS PRODUTOS'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vProd->periodFloat(2)),7,'R');
	
				$x = 10;
				$y += 6;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,25,6, iconv('UTF-8','ISO-8859-1', 'VALOR DO FRETE'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vFrete->periodFloat(2)),7,'R');
	
				$x += 25;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,25,6, iconv('UTF-8','ISO-8859-1', 'VALOR DO SEGURO'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vSeg->periodFloat(2)),7,'R');
	
				$x += 25;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,25,6, iconv('UTF-8','ISO-8859-1', 'VALOR DO DESCONTO'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vDesc->periodFloat(2)),7,'R');
	
				$x += 25;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,25,6, iconv('UTF-8','ISO-8859-1', 'OUTRAS DESPESAS'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vOutro->periodFloat(2)),7,'R');
	
				$x += 25;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'VALOR DO IPI'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vIPI->periodFloat(2)),7,'R');
	
				$x += 30;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,25,6, iconv('UTF-8','ISO-8859-1', 'VALOR DO COFINS'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vCOFINS->periodFloat(2)),7,'R');            
				
				$x += 25;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,40,6, iconv('UTF-8','ISO-8859-1', 'VALOR TOTAL DA NOTA'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_vNF->periodFloat(2)),7,'R');
	
				$x = 10;
				$y += 7;
				$pdf->SetXY($x,$y);
				$pdf->SetFont('Arial', 'B', 6);
				$pdf->Write(3, iconv('UTF-8','ISO-8859-1', 'TRANSPORTADOR / VOLUMES TRANSPORTADOS'));
	
				$y += 3;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,70,6, iconv('UTF-8','ISO-8859-1', 'NOME/RAZÃO SOCIAL'), iconv('UTF-8','ISO-8859-1', $this->NFe->transp_xNome->valor),7);
	
				$x += 70;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,40,6, iconv('UTF-8','ISO-8859-1', 'FRETE POR CONTA'), '',7);
	
				$pdf->SetXY($x+1,$y+3);
				$pdf->SetFont('Arial', '', 5);
				$pdf->Write(3, iconv('UTF-8','ISO-8859-1', '0 - EMITENTE / 1 - DESTINATÁRIO'));
				$pdf->caixaTexto($x+35,$y+1,4,4, '', $this->NFe->transp_modFrete->valor,7,'C');
	
				$x += 40;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,20,6, iconv('UTF-8','ISO-8859-1', 'CÓDIGO ANTT'), '',7);
	
				$x += 20;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,25,6, iconv('UTF-8','ISO-8859-1', 'PLACA DO VEÍCULO'), iconv('UTF-8','ISO-8859-1', $this->NFe->transp_veicTransp_Placa->valor),7);
	
				$x += 25;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,7,6, iconv('UTF-8','ISO-8859-1', 'UF'), iconv('UTF-8','ISO-8859-1', $this->NFe->transp_veicTransp_UF->valor),7);
	
				$x += 7;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,33,6, iconv('UTF-8','ISO-8859-1', 'CNPJ'), iconv('UTF-8','ISO-8859-1', (empty($this->NFe->transp_CNPJ->valor)?$this->NFe->transp_CPF->valor:$this->NFe->transp_CNPJ->valor)),7);
	
				$x = 10;
				$y += 6;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,75,6, iconv('UTF-8','ISO-8859-1', 'ENDEREÇO'), iconv('UTF-8','ISO-8859-1', $this->NFe->transp_xEnder->valor),7);
	
				$x += 75;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,70,6, iconv('UTF-8','ISO-8859-1', 'MUNICÍPIO'), iconv('UTF-8','ISO-8859-1', $this->NFe->transp_xMun->valor),7);
	
				$x += 70;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,7,6, iconv('UTF-8','ISO-8859-1', 'UF'), iconv('UTF-8','ISO-8859-1', $this->NFe->transp_UF->valor),7);
	
				$x += 7;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,43,6, iconv('UTF-8','ISO-8859-1', 'INSCRIÇÃO ESTADUAL'), iconv('UTF-8','ISO-8859-1',$this->NFe->transp_IE->valor),7);
	
				$x = 10;
				$y += 6;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'QUANTIDADE'), iconv('UTF-8','ISO-8859-1', (!empty($this->NFe->transp_qVol->valor)?$this->NFe->transp_qVol->valor:'')),7);
	
				$x += 30;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,35,6, iconv('UTF-8','ISO-8859-1', 'ESPÉCIE'), iconv('UTF-8','ISO-8859-1', $this->NFe->transp_esp->valor),7);
	
				$x += 35;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,40,6, iconv('UTF-8','ISO-8859-1', 'MARCA'), iconv('UTF-8','ISO-8859-1', $this->NFe->transp_marca->valor),7);
	
				$x += 40;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'NUMERAÇÃO'), iconv('UTF-8','ISO-8859-1',$this->NFe->transp_nVol->valor),7);
	
				$x += 30;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'PESO BRUTO'), iconv('UTF-8','ISO-8859-1',(($this->NFe->transp_pesoB->valor != '0.000')?$this->NFe->transp_pesoB->periodFloat(3):'')),7,'R');
	
				$x += 30;
				$pdf->SetXY($x,$y);
				$pdf->caixaTexto($x,$y,30,6, iconv('UTF-8','ISO-8859-1', 'PESO LÍQUIDO'), iconv('UTF-8','ISO-8859-1',(($this->NFe->transp_pesoL->valor != '0.000')?$this->NFe->transp_pesoL->periodFloat(3):'')),7,'R');
			}



            $aCabProd = array();
            $descCST = 'CST';
            if (($this->NFe->emit_CRT->valor == 1) OR ($this->NFe->emit_CRT->valor == 2)) {
                $descCST = 'CSOSN';
            }
            
            $aCabProd [] = array('CÓDIGO', 'DESCRIÇÃO DO PRODUTO/SERVIÇO', 'NCM', $descCST, 'CFOP', 'UN', 'QUANT', 'V.UNITÁRIO', 'V.TOTAL', 'BC.ICMS', 'V.ICMS', 'V.IPI', 'A.ICMS', 'A.IPI');

            $x = 10;
            $y += 7;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1', 'DADOS DOS PRODUTOS / SERVIÇOS'));

            $y += 3;
            $pdf->SetXY($x,$y);
            $header=array(12,40,12,10,10,7,15,15,20,15,15,10,7,7);
            //Header
            $pdf->SetFont('Arial', '', 5);
            for($i=0;$i<count($aCabProd[0]);$i++)
                $pdf->Cell($header[$i],4,iconv('UTF-8','ISO-8859-1', $aCabProd[0][$i]),1,0,'C');
            $pdf->Ln();

            $pdf->SetFont('Arial', '', 5);
			
			$contProd += $limProd;
            if ($contProd > $qtdeProd) {
                $limProd = $limProd - ($contProd - $qtdeProd);
            }
			
			/*if($num_pag == 1)
			{
				$i_for = 0;
			}
			
			if($num_pag == 2)
			{
				$i_for = 20;
			}
			
			if($num_pag > 2)
			{
				$i_for += $qtdeItensNota;
			}*/
			//$i_for = ($num_pag == 2) ? 20 : $qtdeItensNota;
			$i_for = ($num_pag == 1) ? 0 : $valor_calc2;
			
			if($num_pag == 1)
			{
				$valor_calc2 = 20;
			}
			
			if($num_pag >= 2)
			{
				$valor_calc2 += 40;
			}
			//echo 'qtde_pro:  '.$qtdeProd;
			//echo 'valor:::   '.$valor_calc2;
			
			//$valor_calc2 = ($num_pag == 2) ? 60 : ($num_pag - 1) * $qtdeItensNota + $limProd;
			
			//echo "i = $i_for; i < $valor_calc2 <br>";
            //for($i = ($num_pag - 1) * $valor_calc; $i < $valor_calc2; $i++) {
			for($i = $i_for; $i < $valor_calc2; $i++) {
                $x = 10;
                $y += 4;
                $pdf->SetXY($x,$y);
                for($j=0;$j<count($aCabProd[0]);$j++) {
                    $align = 'L';
                    switch($j) {
                        case 1:
                            $align = 'L';
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                            $align = 'C';
                            break;
                        case 6:
                        case 7:
                        case 8:
                        case 9:
                        case 10:
                        case 11:
                        case 12:
                        case 13:
                            $align = 'R';
                            break;
                        default:
                            $align = 'C';
                    }
                    $pdf->Cell($header[$j],4,$aProdutos[$i][$j],0,0,$align);
                }
            }

            $yN = 127;
            $yF = 240;
			
			if($num_pag==1)
			{
				$pdf->Line(10, $yN, 10, $yF);
				$pdf->Line(205, $yN, 205, $yF);
				$pdf->Line(10, 240, 205, 240);
			}
			else
			{
				$pdf->Line(10, 70, 10, 277);
				$pdf->Line(205, 70, 205, 277);
				//$pdf->Line(10, 240, 205, 270);
			}
            
            
            
			
			if($num_pag==1)
			{
	
				$x = 10;
				$y = 241;
				
				$pdf->SetXY($x,$y);
				$pdf->SetFont('Arial', 'B', 6);
				$pdf->Write(3, iconv('UTF-8','ISO-8859-1', 'CÁLCULO DO ISSQN'));
	
				$y += 3;
				$pdf->caixaTexto($x,$y,50,6, iconv('UTF-8','ISO-8859-1', 'INSCRIÇÃO MUNICIPAL'), iconv('UTF-8','ISO-8859-1',$this->NFe->emit_IM->valor),7);
	
				$x += 50;
				$pdf->caixaTexto($x,$y,45,6, iconv('UTF-8','ISO-8859-1', 'VALOR TOTAL DOS SERVIÇOS'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_ISSQN_vServ->periodFloat(2)),7);
	
				$x += 45;
				$pdf->caixaTexto($x,$y,45,6, iconv('UTF-8','ISO-8859-1', 'BASE CÁLCULO ISSQN'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_ISSQN_vBC->periodFloat(2)),7);
	
				$x += 45;
				$pdf->caixaTexto($x,$y,55,6, iconv('UTF-8','ISO-8859-1', 'VALOR DO ISSQN'), iconv('UTF-8','ISO-8859-1', $this->NFe->total_ISSQN_vISS->periodFloat(2)),7);
	
	
				$pdf->SetXY(10,251);
				$pdf->SetFont('Arial', 'B', 6);
				$pdf->Write(3, iconv('UTF-8','ISO-8859-1', 'DADOS ADICIONAIS'));
	
				$pdf->Rect(10, 254, 120, 22);
				$pdf->SetXY(9.5, 254.8);
				$pdf->SetFont('Arial', '', 5);
				$pdf->Write(1, iconv('UTF-8','ISO-8859-1', 'INFORMAÇÕES COMPLEMENTARES'));
	
	
				$pdf->SetFont('Arial', '', 5);
	
				$infAdic = @iconv('UTF-8','ISO-8859-1', $this->NFe->infAdic_infAdFisco->valor . chr(13) . chr(10) . $this->NFe->infAdic_infCpl->valor);
				$infAdic = str_replace(chr(13) . chr(10), '|', $infAdic);
				$infX = 9.5;
				$infY = 257;
				$texto = '';
				for ($i=0;$i<strlen($infAdic);$i++) {
					if (($infAdic[$i] == "|") OR ($pdf->GetStringWidth($texto . $infAdic[$i]) > 119)) {
						$pdf->SetXY($infX, $infY);
						$infY += 2;
						$pdf->Write(1, $texto);
						$texto = '';
					}
					if ($infAdic[$i] != "|") {
						$texto .= $infAdic[$i];
					}
				}
	
				if (!empty($texto)) {
					$pdf->SetXY($infX, $infY);
					$pdf->Write(1, $texto);
				}
	
				$pdf->Rect(130, 254, 75, 22);
				$pdf->SetXY(129.5, 254.8);
				$pdf->SetFont('Arial', '', 5);
				$pdf->Write(1, iconv('UTF-8','ISO-8859-1', 'RESERVADO AO FISCO'));
	
				$y = 277;
			}
            //$pdf->Line(10, $y, 205, $y);
            //$pdf->SetXY(13, 278);
            //$pdf->SetFont('Arial', '', 7);
            //$pdf->Write(0, iconv('UTF-8','ISO-8859-1', 'Recebemos de ' . $this->NFe->emit_xNome->valor . ' os produtos constantes na nota fiscal eletrônica ao lado.'));
            //$pdf->Rect(10, 278, 195, 15);
            //$pdf->Line(170, 278, 170, 293);
        }
//exit;
        if (count($prodInfAdic) > 0) {
            $pdf->AddPage($orientacao);
            $pdf->additionalPage = true;
            $pdf->Rect(10, 10, 195, 15);
            $pdf->Line(75, 10, 75, 25);
            $pdf->Line(140, 10, 140, 25);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetXY(10,16);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1',$this->NFe->emit_xFant->valor));
            $pdf->SetXY(100,16);
            $pdf->Write(3, iconv('UTF-8','ISO-8859-1','ANEXO'));
            $pdf->SetXY(145,14);
            $pdf->Write(2, iconv('UTF-8','ISO-8859-1', 'Nº ' . $this->NFe->ide_nNF->valor));
            $pdf->SetXY(145,19);
            $pdf->Write(2, iconv('UTF-8','ISO-8859-1', 'DATA: ' . $this->NFe->ide_dEmi->data()));
            $pdf->Line(10, 30, 10, 290);
            $pdf->Line(205, 30, 205, 290);
            $pdf->Line(10, 290, 205, 290);

            $y = 31;
            $yL = 30;
            for ($i=0;$i<count($prodInfAdic);$i++) {
                $pdf->Line(10, $yL, 205, $yL);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->SetXY(10,$y);
                $pdf->Write(2, iconv('UTF-8','ISO-8859-1', 'ITEM: ' . (string) ($i+1)));
                $pdf->SetXY(25,$y);
                $pdf->Write(2, iconv('UTF-8','ISO-8859-1', 'PRODUTO: ' . $prodInfAdic[$i][1]));
                $pdf->SetXY(135,$y);
                $pdf->Write(2, iconv('UTF-8','ISO-8859-1', 'QTDE: ' . $prodInfAdic[$i][2]));
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetXY(10,$y+5);
                $pdf->Write(2, iconv('UTF-8','ISO-8859-1', $prodInfAdic[$i][3]));
                $y += 15;
                $yL += 15;
            }
        }

        $pdf->Close();
        if ($this->salvar) {
            $name = $this->NFe->tools->aprovadasPDF . 'NFE' . $this->NFe->Id . '.PDF';
            $pdf->Output($name, 'F');
        }
        else {
            $name = 'NFE' . $this->NFe->Id . '.PDF';
            $pdf->Output($name, 'D');
        }

        // envia ao browser para salvar
        //$pdf-Output($numero.'.pdf','D')
        //echo $width;
    }
}
?>