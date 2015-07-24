<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$MySQLHost = 'localhost';
$MySQLUser = 'root';
$MySQLPass = '';
$MySQLBD = 'nfe';

if (empty($_GET['acao'])) {
    mysql_connect($MySQLHost, $MySQLUser, $MySQLPass);
    mysql_select_db($MySQLBD);

    echo '<p><input type=button value="Gerar Nota" onclick="location.href='.chr(39).'teste.php?acao=gerar'.chr(39).'"></p>';
    echo '<p><input type=button value="Inutilizar" onclick="location.href='.chr(39).'teste.php?acao=inutilizar'.chr(39).'"></p>';
    
    $sql = "SELECT * FROM nfe_notas";
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        echo '<p>'.$r['Id'].' - '.$r['emit_xNome'].' - <a href="teste.php?acao=verlote&id='.$r['Id'].'">Pegar Resposta</a> - <a href="teste.php?acao=imprimir&id='.$r['Id'].'">Gerar DANFE</a> - <a href="teste.php?acao=cancelar&id='.$r['Id'].'">Cancelar</a></p> - <a href="teste.php?acao=salvarem&id='.$r['Id'].'">Salvar</a> - <a href="teste.php?acao=salvarpdf&id='.$r['Id'].'">Salvar PDF</a> - <a href="teste.php?acao=cce&id='.$r['Id'].'">Carta de Correcao</a></p>';
    }
}
else if ($_GET['acao'] == 'cce') {
    require_once('CCe.php');
    
    $CCe = new CCe(); //Informar 2 para v2.0
    $CCe->path = 'C:/http/nfe';
    $CCe->nameCert = 'certificado.pfx';
    $CCe->passKey = 'senhadocertificado';
    $CCe->MySQLHost = $MySQLHost;
    $CCe->MySQLUser = $MySQLUser;
    $CCe->MySQLPass = $MySQLPass;
    $CCe->MySQLBD = $MySQLBD;
    $CCe->ambiente = 2; 
    //$NFe->logo = 'C:/http/b2/imagens/home.jpg'; //--Arquivo do logo
    $CCe->UFcod = "43";
    
    $CCe->inicializa();
    
    $CCe->cOrgao->valor = 43;
    $CCe->tpAmb->valor = 2;
    $CCe->CNPJ->valor = '12345678000109';
    $CCe->chNFe->valor = $_GET['id'];
    $CCe->dhEvento->valor = date('Y-m-d') . 'T' . date('H:i:s') . date('P');
    $CCe->tpEvento->valor = 110110;
    $CCe->nSeqEvento->valor = 4;
    $CCe->verEvento->valor = '1.00';
    $CCe->descEvento->valor = 'Carta de Correcao';
    $CCe->xCorrecao->valor = 'Texto de teste para Carta de Correcao. Conteúdo do campo xCorrecao.';
    $CCe->xCondUso->valor = 'A Carta de Correcao e disciplinada pelo paragrafo 1o-A do art. 7o do Convenio S/N, de 15 de dezembro de 1970 e pode ser utilizada para regularizacao de erro ocorrido na emissao de documento fiscal, desde que o erro nao esteja relacionado com: I - as variaveis que determinam o valor do imposto tais como: base de calculo, aliquota, diferenca de preco, quantidade, valor da operacao ou da prestacao; II - a correcao de dados cadastrais que implique mudanca do remetente ou do destinatario; III - a data de emissao ou de saida.';

    $CCe->processa();

    if ($CCe->temErro()) {
        echo 'Ocorreram erros ao gerar a CCe:<br>';
        foreach ($CCe->erros as $erro) {
            echo $erro . '<br>';
        }
    }
    else {
        echo "CCe enviada com sucesso.";
    }    
    
}
else {
    require_once('NFe.php');

    $NFe = new NFe(2); //Informar 2 para v2.0
    $NFe->path = 'C:/http/nfe';
    $NFe->nameCert = 'certificado.pfx';
    $NFe->passKey = 'senhadocertificado';
    $NFe->MySQLHost = $MySQLHost;
    $NFe->MySQLUser = $MySQLUser;
    $NFe->MySQLPass = $MySQLPass;
    $NFe->MySQLBD = $MySQLBD;
    $NFe->ambiente = 2;
    //$NFe->logo = 'C:/http/b2/imagens/home.jpg'; //--Arquivo do logo
    $NFe->UFcod = "43";
    
    $NFe->inicializa();

    if ($_GET['acao'] == 'gerar') {
        $NFe->calcTotal = false;
        $NFe->ide_cUF->valor = 43;
        $NFe->ide_natOp->valor = 'Venda a Vista';
        $NFe->ide_indPag->valor = 0;
        $NFe->ide_mod->valor = 55;
        $NFe->ide_serie->valor = 0;
        $NFe->ide_nNF->valor = 2147;
        $NFe->ide_dEmi->valor = '2012-10-30';
        $NFe->ide_dSaiEnt->valor = '2012-11-01';
        $NFe->ide_hSaiEnt->valor = '08:30:00';
        $NFe->ide_tpNF->valor = 1;
        $NFe->ide_cMunFG->valor = 4314902;
        $NFe->ide_tpImp->valor = 1;
        $NFe->ide_tpEmis->valor = 1;
        $NFe->ide_tpAmb->valor = 2;
        $NFe->ide_finNFe->valor = 1;
        $NFe->ide_procEmi->valor = 0;

        $NFe->emit_CNPJ->valor = '12345678000109';
        $NFe->emit_xNome->valor = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        $NFe->emit_xFant->valor = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        $NFe->enderEmit_xLgr->valor = 'RUA GENERAL MAGALHAES';
        $NFe->enderEmit_nro->valor = '1234';
        //$NFe->enderEmit_xCpl->valor = 'Complemento';
        $NFe->enderEmit_xBairro->valor = 'SAO JOAO';
        $NFe->enderEmit_cMun->valor = 4314902;
        $NFe->enderEmit_xMun->valor = 'PORTO ALEGRE';
        $NFe->enderEmit_UF->valor = 'RS';
        $NFe->enderEmit_CEP->valor = 99999999;
        $NFe->enderEmit_fone->valor = 5555555555;
        $NFe->emit_IE->valor = '111111111';
        $NFe->emit_CRT->valor = 1; //Campo novo - Olhar manual

        $NFe->dest_xNome->valor = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        $NFe->dest_CNPJ->valor = '12345678000189';
        $NFe->enderDest_xLgr->valor = 'Rua Jose Flores';
        $NFe->enderDest_nro->valor = '1033';
        $NFe->enderDest_xCpl->valor = 'Sala 5112';
        $NFe->enderDest_xBairro->valor = 'Centro';
        $NFe->enderDest_cMun->valor = 4314902;
        $NFe->enderDest_xMun->valor = 'PORTO ALEGRE';
        $NFe->enderDest_UF->valor = 'RS';
        $NFe->enderDest_CEP->valor = 99999999;
        $NFe->enderDest_cPais->valor = 1334;
        $NFe->enderDest_xPais->valor = 'BRASIL';
        $NFe->enderDest_fone->valor = 5555555555;
        $NFe->dest_IE->valor = 'ISENTO'; //Se não tem IE, informar ISENTO

        $NFe_prod = new NFe_prod(2);
        $NFe_prod->cProd->valor = 892860;
        $NFe_prod->xProd->valor = 'CONSERTO COMPUTADOR';
        $NFe_prod->CFOP->valor = '5102';
        $NFe_prod->uTrib->valor = 'UNIT';
        $NFe_prod->uCom->valor = 'UNIT';
        $NFe_prod->qTrib->valor = 2.000;
        $NFe_prod->qCom->valor = 2.000;
        $NFe_prod->vUnCom->valor = 20.00;
        $NFe_prod->vUnTrib->valor = 20.00;
        $NFe_prod->vProd->valor = 40.00;
        //$NFe_prod->orig->valor = '0';
        //$NFe_prod->CST->valor = '40';
        $NFe_prod->ICMSSN_orig->valor = '0';
        $NFe_prod->ICMSSN_CSOSN->valor = '102';        
        //$NFe_prod->IPI_CST->valor = '04';
        $NFe_prod->PIS_CST->valor = '04';
        $NFe_prod->COFINS_CST->valor = '04';
        
        //$NFe_prod->IPI_cEnq->valor = '999';
        //$NFe_prod->IPI_CST->valor = '99';
        //$NFe_prod->IPI_vBC->valor = 40.00;
        //$NFe_prod->IPI_pIPI->valor = 0.00;
        //$NFe_prod->IPI_vIPI->valor = 0.00;
        
        //$NFe_prod->ISSQN_vBC->valor = 4.25;
        //$NFe_prod->ISSQN_vAliq->valor = 10;
        //$NFe_prod->ISSQN_vISSQN->valor = 0.42;
        //$NFe_prod->ISSQN_cMunFG->valor = 4314902;
        //$NFe_prod->ISSQN_cListServ->valor = '101';
        //$NFe_prod->ISSQN_cSitTrib->valor = 'N'; //Campo novo pra serviço - ver manual
        $NFe_prod->produto_cod = 111;
        $NFe_prod->indTot->valor = 1; //Campo novo / 0 - para não somar no total e 1 - para somar / ver manual
        $NFe_prod->NCM->valor = '99'; //Na v2.0 o NCM é obrigatório
        
        $NFe_di = new NFe_di();
        $NFe_di->nDI->valor = '1013710578';
        $NFe_di->dDI->valor = '2010-08-10'; 
        $NFe_di->xLocDesemb->valor = 'VIRACOPOS'; 
        $NFe_di->ufDesemb->valor = 'SP'; 
        $NFe_di->dDesemb->valor = '2010-08-10'; 
        $NFe_di->cExportador->valor = '0000021248'; 
        
        $NFe_di_adi = new NFe_di_adi();
        $NFe_di_adi->nAdicao->valor = 3;
        $NFe_di_adi->nSeqAdic->valor = 2;
        $NFe_di_adi->cFabricante->valor = '21248';
        
        $NFe_di->addAdi($NFe_di_adi);
        $NFe_prod->addDI($NFe_di);
        $NFe->addProd($NFe_prod);

        $NFe->total_vProd->valor = 40.00;
        $NFe->total_vNF->valor = 40.00;
        //$NFe->total_vIPI->valor = 0.00;
        $NFe->transp_modFrete->valor = 1;
        //$NFe->transp_CNPJ->valor = '12345678000189';
        //$NFe->transp_xNome->valor = 'Transportadora';
        //$NFe->transp_IE->valor = 'ISENTO';
        //$NFe->transp_xEnder->valor = 'Endereco';
        //$NFe->transp_xMun->valor = 'Município';
        //$NFe->transp_UF->valor = 'RS';
        //$NFe->transp_veicTransp_Placa->valor = 'DAD9999';
        //$NFe->transp_veicTransp_UF->valor = 'RS';
        $NFe->transp_qVol->valor = 12;
        $NFe->transp_esp->valor = 'Caixa';
        $NFe->transp_marca->valor = 'Diversas';
        $NFe->transp_nVol->valor = 'Diversas';
        $NFe->transp_pesoL->valor = 232;
        $NFe->transp_pesoB->valor = 121;

        $NFe->exporta_UFEmbarq->valor = 'RS';
        $NFe->exporta_xLocEmbarq->valor = 'Porto de Rio Grande';
        $NFe->filial = 1;
        $NFe->pedido = 1;
        $NFe->cliente_cod = 2;
        $NFe->cliente_fil = 2;
        $NFe->cliente_cf = 'S';
        $NFe->forma_pag_cod = 2;
        $NFe->transportadora_cod = 11;

        $NFe_dup = new NFe_dup();
        $NFe_dup->cobr_dup_nDup->valor = 123123;
        $NFe_dup->cobr_dup_dVenc->valor = '2009-12-12';
        $NFe_dup->cobr_dup_vDup->valor = 100.00;
        $NFe->addDup($NFe_dup);

        $NFe->infAdic_infAdFisco->valor = 'ICMS CFME ETC ETC ETC';
        $NFe->infAdic_infCpl->valor = 'Informações Adicionais';

        $NFe->processa();

        if ($NFe->temErro()) {
            echo 'Ocorreram erros ao gerar a NFe:<br>';
            foreach ($NFe->erros as $erro) {
                echo $erro . '<br>';
            }
        }
        else {
            echo "NFe enviada com sucesso.";
        }
    }
    elseif($_GET['acao'] == 'verlote') {
        $NFe->verificaNFe($_GET['id']);

        if ($NFe->temErro()) {
            foreach ($NFe->erros as $erro) {
                echo $erro . '<br>';
            }
        }
        else {
            echo "NFe aprovada para uso.";
        }
    }
    elseif($_GET['acao'] == 'imprimir') {
        $NFe->imprimir($_GET['id']);
    }
    elseif($_GET['acao'] == 'cancelar') {
        $justificativa = 'Teste de cancelamento';
        $NFe->cancelarNFe($_GET['id'], $justificativa);

        if ($NFe->temErro()) {
            foreach ($NFe->erros as $erro) {
                echo $erro . '<br>';
            }
        }
        else {
            echo "NFe cancelada.";
        }
    }
    elseif($_GET['acao'] == 'salvarem') {
        $NFe->salvarNFeDoBanco($_GET['id']);

        if ($NFe->temErro()) {
            foreach ($NFe->erros as $erro) {
                echo $erro . '<br>';
            }
        }
        else {
            echo "NFe válida.";
        }
    }
    elseif($_GET['acao'] == 'salvarpdf') {
        $NFe->imprimir($_GET['id'], true);
    }
    elseif($_GET['acao'] == 'inutilizar') {
        //inutilizaNF($ano,$nfSerie,$modelo,$numIni,$numFim,$CNPJ,$xJust)
        $NFe->inutilizaNF('09', '0', '55', 10, 11, '12345678000189', 'Teste de inutilizacao de numeracao.');

        if ($NFe->temErro()) {
            foreach ($NFe->erros as $erro) {
                echo $erro . '<br>';
            }
        }
        else {
            echo "Inutilizacao realizada com sucesso.";
        }
    }



}
?>