<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NFe
 *
 * @author Marlos
 */
require_once('NFe_campo.php');
require_once('NFe_prod.php');
require_once('NFe_dup.php');
require_once('NFe_tools.php');
require_once('NFe_danfe.php');

define('GERADA', 'G');
define('VALIDADA', 'V');
define('ENVIADA', 'E');
define('APROVADA', 'A');
define('CANCELADA', 'C');
define('NAO_APROVADA', 'N');
define('RECUSADA', 'R');
define('CONTIGENCIA', 'G');

class NFe {

    private $versaoNFe = null;
    private $versao = null;
    public $Id = null;
    //ide
    public $ide_cUF = null;
    public $ide_cNF = null;
    public $ide_natOp = null;
    public $ide_indPag = null;
    public $ide_mod = null;
    public $ide_serie = null;
    public $ide_nNF = null;
    public $ide_dEmi = null;
    public $ide_dSaiEnt = null;
    public $ide_hSaiEnt = null; //v2.0
    public $ide_tpNF = null;
    public $ide_cMunFG = null;
    public $ide_refNFe = null;
    public $ide_tpImp = null;
    public $ide_tpEmis = null;
    public $ide_cDV = null;
    public $ide_tpAmb = null;
    public $ide_finNFe = null;
    public $ide_procEmi = null;
    public $ide_verProc = null;
    public $ide_dhCont = null; //v2.0
    public $ide_xJust = null; //v2.0
    public $emit_CNPJ = null;
    public $emit_CPF = null;
    public $emit_xNome = null;
    public $emit_xFant = null;
    public $enderEmit_xLgr = null;
    public $enderEmit_nro = null;
    public $enderEmit_xCpl = null;
    public $enderEmit_xBairro = null;
    public $enderEmit_cMun = null;
    public $enderEmit_xMun = null;
    public $enderEmit_UF = null;
    public $enderEmit_CEP = null;
    public $enderEmit_cPais = null;
    public $enderEmit_xPais = null;
    public $enderEmit_fone = null;
    public $emit_IE = null;
    public $emit_IEST = null;
    public $emit_IM = null;
    public $emit_CNAE = null;
    public $emit_CRT = null; //v2.0
    public $dest_CNPJ = null;
    public $dest_CPF = null;
    public $dest_xNome = null;
    public $enderDest_xLgr = null;
    public $enderDest_nro = null;
    public $enderDest_xCpl = null;
    public $enderDest_xBairro = null;
    public $enderDest_cMun = null;
    public $enderDest_xMun = null;
    public $enderDest_UF = null;
    public $enderDest_CEP = null;
    public $enderDest_cPais = null;
    public $enderDest_xPais = null;
    public $enderDest_fone = null;
    public $dest_IE = null;
    public $dest_ISUF = null;
    public $dest_email = null; //v2.0
    public $retirada_CNPJ = null;
    public $retirada_CPF = null; //v2.0
    public $retirada_xLgr = null;
    public $retirada_nro = null;
    public $retirada_xCpl = null;
    public $retirada_xBairro = null;
    public $retirada_cMun = null;
    public $retirada_xMun = null;
    public $retirada_UF = null;
    public $entrega_CNPJ = null;
    public $entrega_CPF = null; //v2.0
    public $entrega_xLgr = null;
    public $entrega_nro = null;
    public $entrega_xCpl = null;
    public $entrega_xBairro = null;
    public $entrega_cMun = null;
    public $entrega_xMun = null;
    public $entrega_UF = null;
    public $total_vBC = null;
    public $total_vICMS = null;
    public $total_vBCST = null;
    public $total_vST = null;
    public $total_vProd = null;
    public $total_vFrete = null;
    public $total_vSeg = null;
    public $total_vDesc = null;
    public $total_vII = null;
    public $total_vIPI = null;
    public $total_vPIS = null;
    public $total_vCOFINS = null;
    public $total_vOutro = null;
    public $total_vNF = null;
    public $total_ISSQN_vServ = null;
    public $total_ISSQN_vBC = null;
    public $total_ISSQN_vISS = null;
    public $total_ISSQN_vPIS = null;
    public $total_ISSQN_vCOFINS = null;
    public $transp_modFrete = null;
    public $transp_CNPJ = null;
    public $transp_CPF = null;
    public $transp_xNome = null;
    public $transp_IE = null;
    public $transp_xEnder = null;
    public $transp_xMun = null;
    public $transp_UF = null;
    public $transp_veicTransp_Placa = null;
    public $transp_veicTransp_UF = null;
    public $transp_qVol = null;
    public $transp_esp = null;
    public $transp_marca = null;
    public $transp_nVol = null;
    public $transp_pesoL = null;
    public $transp_pesoB = null;
    public $cobr_fat_nFat = null;
    public $cobr_fat_vOrig = null;
    public $cobr_fat_vDesc = null;
    public $cobr_fat_vLiq = null;
    public $infAdic_infAdFisco = null;
    public $infAdic_infCpl = null;
    public $exporta_UFEmbarq = null;
    public $exporta_xLocEmbarq = null;
    private $Itens = array();
    private $qtdeItens = 0;
    private $Duplicatas = array();
    public $status = null;
    public $msg_erro = null;
    public $cod_ret = null;
    public $recibo = null;
    public $nProt = null;
    public $digVal = null;
    public $xJust = null;
    public $dhRecbto = null;
    public $verAplic = null;
    public $IdLote = null;
    public $XML = null;
    public $tools = null;
    public $path = null;
    public $nameCert = null;
    public $passKey = null;
    public $MySQLHost = null;
    public $MySQLUser = null;
    public $MySQLPass = null;
    public $MySQLBD = null;
    private $conMysql = null;
    public $erros = null;
    public $ambiente = null;
    public $UFcod = null;
    public $calcTotal = null;
    public $logo = null;
    public $filial = null;
    public $pedido = null;
    public $cliente_cod = null;
    public $cliente_fil = null;
    public $cliente_cf = null;
    public $forma_pag_tipo = null;
    public $forma_pag_cod = null;
    public $transportadora_cod = null;
    public $vendedor_cod = null;
    public $vendedor_fil = null;
    public $p_comissao = null;
    public $v_comissao = null;
    public $pvenda_pservico = null;
    public $pathCerts = null;

    public function __construct($versao = 1) {
        $this->versaoNFe = $versao;
        $this->init();
    }

    private function init() {
        if ($this->versaoNFe == 1) {
            $this->versao = "1.10";
        } else {
            $this->versao = "2.00";
        }
        $this->Id = "";
        //ide
        $this->ide_cUF = new NFe_campo();
        $this->ide_cUF->tag = 'cUF';
        $this->ide_cUF->obrigatorio = true;
        $this->ide_cUF->tipo = NUMERO;

        $this->ide_cNF = new NFe_campo();
        $this->ide_cNF->tag = 'cNF';
        $this->ide_cNF->obrigatorio = true;
        $this->ide_cNF->tipo = NUMERO;

        $this->ide_natOp = new NFe_campo();
        $this->ide_natOp->tag = 'natOp';
        $this->ide_natOp->obrigatorio = true;

        $this->ide_indPag = new NFe_campo();
        $this->ide_indPag->tag = 'indPag';
        $this->ide_indPag->obrigatorio = true;
        $this->ide_indPag->tipo = NUMERO;

        $this->ide_mod = new NFe_campo();
        $this->ide_mod->tag = 'mod';
        $this->ide_mod->valor = '55';
        $this->ide_mod->obrigatorio = true;

        $this->ide_serie = new NFe_campo();
        $this->ide_serie->tag = 'serie';
        $this->ide_serie->valor = 0;
        $this->ide_serie->obrigatorio = true;
        $this->ide_serie->tipo = NUMERO;

        $this->ide_nNF = new NFe_campo();
        $this->ide_nNF->tag = 'nNF';
        $this->ide_nNF->obrigatorio = true;

        $this->ide_dEmi = new NFe_campo();
        $this->ide_dEmi->tag = 'dEmi';
        $this->ide_dEmi->obrigatorio = true;
        $this->ide_dEmi->tipo = DATA;

        $this->ide_dSaiEnt = new NFe_campo();
        $this->ide_dSaiEnt->tag = 'dSaiEnt';
        $this->ide_dSaiEnt->tipo = DATA;

        $this->ide_tpNF = new NFe_campo();
        $this->ide_tpNF->tag = 'tpNF';
        $this->ide_tpNF->obrigatorio = true;

        $this->ide_cMunFG = new NFe_campo();
        $this->ide_cMunFG->tag = 'cMunFG';
        $this->ide_cMunFG->obrigatorio = true;

        $this->ide_refNFe = new NFe_campo();
        $this->ide_refNFe->tag = 'refNFe';

        $this->ide_tpImp = new NFe_campo();
        $this->ide_tpImp->tag = 'tpImp';
        $this->ide_tpImp->obrigatorio = true;

        $this->ide_tpEmis = new NFe_campo();
        $this->ide_tpEmis->tag = 'tpEmis';
        $this->ide_tpEmis->obrigatorio = true;

        $this->ide_cDV = new NFe_campo();
        $this->ide_cDV->tag = 'cDV';
        $this->ide_cDV->obrigatorio = true;

        $this->ide_cDV = new NFe_campo();
        $this->ide_cDV->tag = 'cDV';
        $this->ide_cDV->obrigatorio = true;

        $this->ide_tpAmb = new NFe_campo();
        $this->ide_tpAmb->tag = 'tpAmb';
        $this->ide_tpAmb->obrigatorio = true;

        $this->ide_finNFe = new NFe_campo();
        $this->ide_finNFe->tag = 'finNFe';
        $this->ide_finNFe->obrigatorio = true;

        $this->ide_procEmi = new NFe_campo();
        $this->ide_procEmi->tag = 'procEmi';
        $this->ide_procEmi->valor = 0;
        $this->ide_procEmi->obrigatorio = true;

        $this->ide_verProc = new NFe_campo();
        $this->ide_verProc->tag = 'verProc';
        $this->ide_verProc->valor = '1.0';
        $this->ide_verProc->obrigatorio = true;

        $this->emit_CNPJ = new NFe_campo();
        $this->emit_CNPJ->tag = 'CNPJ';
        //$this->emit_CNPJ->obrigatorio = true;

        $this->emit_CPF = new NFe_campo();
        $this->emit_CPF->tag = 'CPF';

        $this->emit_xNome = new NFe_campo();
        $this->emit_xNome->tag = 'xNome';
        $this->emit_xNome->obrigatorio = true;

        $this->emit_xFant = new NFe_campo();
        $this->emit_xFant->tag = 'xFant';

        $this->enderEmit_xLgr = new NFe_campo();
        $this->enderEmit_xLgr->tag = 'xLgr';
        $this->enderEmit_xLgr->obrigatorio = true;

        $this->enderEmit_nro = new NFe_campo();
        $this->enderEmit_nro->tag = 'nro';
        $this->enderEmit_nro->obrigatorio = true;

        $this->enderEmit_xCpl = new NFe_campo();
        $this->enderEmit_xCpl->tag = 'xCpl';

        $this->enderEmit_xBairro = new NFe_campo();
        $this->enderEmit_xBairro->tag = 'xBairro';
        $this->enderEmit_xBairro->obrigatorio = true;

        $this->enderEmit_cMun = new NFe_campo();
        $this->enderEmit_cMun->tag = 'cMun';
        $this->enderEmit_cMun->obrigatorio = true;

        $this->enderEmit_xMun = new NFe_campo();
        $this->enderEmit_xMun->tag = 'xMun';
        $this->enderEmit_xMun->obrigatorio = true;

        $this->enderEmit_UF = new NFe_campo();
        $this->enderEmit_UF->tag = 'UF';
        $this->enderEmit_UF->obrigatorio = true;

        $this->enderEmit_CEP = new NFe_campo();
        $this->enderEmit_CEP->tag = 'CEP';

        $this->enderEmit_cPais = new NFe_campo();
        $this->enderEmit_cPais->tag = 'cPais';
        $this->enderEmit_cPais->valor = 1058;

        $this->enderEmit_xPais = new NFe_campo();
        $this->enderEmit_xPais->tag = 'xPais';
        $this->enderEmit_xPais->valor = 'BRASIL';

        $this->enderEmit_fone = new NFe_campo();
        $this->enderEmit_fone->tag = 'fone';
        $this->enderEmit_fone->tipo = NUMERO;

        $this->emit_IE = new NFe_campo();
        $this->emit_IE->tag = 'IE';

        $this->emit_IEST = new NFe_campo();
        $this->emit_IEST->tag = 'IEST';

        $this->emit_IM = new NFe_campo();
        $this->emit_IM->tag = 'IM';

        $this->emit_CNAE = new NFe_campo();
        $this->emit_CNAE->tag = 'CNAE';

        $this->dest_CNPJ = new NFe_campo();
        $this->dest_CNPJ->tag = 'CNPJ';

        $this->dest_CPF = new NFe_campo();
        $this->dest_CPF->tag = 'CPF';

        $this->dest_xNome = new NFe_campo();
        $this->dest_xNome->tag = 'xNome';

        $this->enderDest_xLgr = new NFe_campo();
        $this->enderDest_xLgr->tag = 'xLgr';

        $this->enderDest_nro = new NFe_campo();
        $this->enderDest_nro->tag = 'nro';

        $this->enderDest_xCpl = new NFe_campo();
        $this->enderDest_xCpl->tag = 'xCpl';

        $this->enderDest_xBairro = new NFe_campo();
        $this->enderDest_xBairro->tag = 'xBairro';

        $this->enderDest_cMun = new NFe_campo();
        $this->enderDest_cMun->tag = 'cMun';

        $this->enderDest_xMun = new NFe_campo();
        $this->enderDest_xMun->tag = 'xMun';

        $this->enderDest_UF = new NFe_campo();
        $this->enderDest_UF->tag = 'UF';

        $this->enderDest_CEP = new NFe_campo();
        $this->enderDest_CEP->tag = 'CEP';

        $this->enderDest_cPais = new NFe_campo();
        $this->enderDest_cPais->tag = 'cPais';
        $this->enderDest_cPais->valor = 1058;

        $this->enderDest_xPais = new NFe_campo();
        $this->enderDest_xPais->tag = 'xPais';
        $this->enderDest_xPais->valor = 'BRASIL';

        $this->enderDest_fone = new NFe_campo();
        $this->enderDest_fone->tag = 'fone';
        $this->enderDest_fone->tipo = NUMERO;

        $this->dest_IE = new NFe_campo();
        $this->dest_IE->tag = 'IE';
        //$this->dest_IE->obrigatorio = true;

        $this->dest_ISUF = new NFe_campo();
        $this->dest_ISUF->tag = 'ISUF';

        $this->retirada_CNPJ = new NFe_campo();
        $this->retirada_CNPJ->tag = 'CNPJ';

        $this->retirada_xLgr = new NFe_campo();
        $this->retirada_xLgr->tag = 'xLgr';

        $this->retirada_nro = new NFe_campo();
        $this->retirada_nro->tag = 'nro';

        $this->retirada_xCpl = new NFe_campo();
        $this->retirada_xCpl->tag = 'xCpl';

        $this->retirada_xBairro = new NFe_campo();
        $this->retirada_xBairro->tag = 'xBairro';

        $this->retirada_cMun = new NFe_campo();
        $this->retirada_cMun->tag = 'cMun';

        $this->retirada_xMun = new NFe_campo();
        $this->retirada_xMun->tag = 'xMun';

        $this->retirada_UF = new NFe_campo();
        $this->retirada_UF->tag = 'UF';

        $this->entrega_CNPJ = new NFe_campo();
        $this->entrega_CNPJ->tag = 'CNPJ';

        $this->entrega_xLgr = new NFe_campo();
        $this->entrega_xLgr->tag = 'xLgr';

        $this->entrega_nro = new NFe_campo();
        $this->entrega_nro->tag = 'nro';

        $this->entrega_xCpl = new NFe_campo();
        $this->entrega_xCpl->tag = 'xCpl';

        $this->entrega_xBairro = new NFe_campo();
        $this->entrega_xBairro->tag = 'xBairro';

        $this->entrega_cMun = new NFe_campo();
        $this->entrega_cMun->tag = 'cMun';

        $this->entrega_xMun = new NFe_campo();
        $this->entrega_xMun->tag = 'xMun';

        $this->entrega_UF = new NFe_campo();
        $this->entrega_UF->tag = 'UF';

        $this->total_vBC = new NFe_campo();
        $this->total_vBC->tag = 'vBC';
        $this->total_vBC->valor = 0.00;
        $this->total_vBC->obrigatorio = true;
        $this->total_vBC->tipo = NUMERO;
        $this->total_vBC->casas_decimais = 2;

        $this->total_vICMS = new NFe_campo();
        $this->total_vICMS->tag = 'vICMS';
        $this->total_vICMS->valor = 0.00;
        $this->total_vICMS->obrigatorio = true;
        $this->total_vICMS->tipo = NUMERO;
        $this->total_vICMS->casas_decimais = 2;

        $this->total_vBCST = new NFe_campo();
        $this->total_vBCST->tag = 'vBCST';
        $this->total_vBCST->valor = 0.00;
        $this->total_vBCST->obrigatorio = true;
        $this->total_vBCST->tipo = NUMERO;
        $this->total_vBCST->casas_decimais = 2;

        $this->total_vST = new NFe_campo();
        $this->total_vST->tag = 'vST';
        $this->total_vST->valor = 0.00;
        $this->total_vST->obrigatorio = true;
        $this->total_vST->tipo = NUMERO;
        $this->total_vST->casas_decimais = 2;

        $this->total_vProd = new NFe_campo();
        $this->total_vProd->tag = 'vProd';
        $this->total_vProd->valor = 0.00;
        $this->total_vProd->obrigatorio = true;
        $this->total_vProd->tipo = NUMERO;
        $this->total_vProd->casas_decimais = 2;

        $this->total_vFrete = new NFe_campo();
        $this->total_vFrete->tag = 'vFrete';
        $this->total_vFrete->valor = 0.00;
        $this->total_vFrete->obrigatorio = true;
        $this->total_vFrete->tipo = NUMERO;
        $this->total_vFrete->casas_decimais = 2;

        $this->total_vSeg = new NFe_campo();
        $this->total_vSeg->tag = 'vSeg';
        $this->total_vSeg->valor = 0.00;
        $this->total_vSeg->obrigatorio = true;
        $this->total_vSeg->tipo = NUMERO;
        $this->total_vSeg->casas_decimais = 2;

        $this->total_vDesc = new NFe_campo();
        $this->total_vDesc->tag = 'vDesc';
        $this->total_vDesc->valor = 0.00;
        $this->total_vDesc->obrigatorio = true;
        $this->total_vDesc->tipo = NUMERO;
        $this->total_vDesc->casas_decimais = 2;

        $this->total_vII = new NFe_campo();
        $this->total_vII->tag = 'vII';
        $this->total_vII->valor = 0.00;
        $this->total_vII->obrigatorio = true;
        $this->total_vII->tipo = NUMERO;
        $this->total_vII->casas_decimais = 2;

        $this->total_vIPI = new NFe_campo();
        $this->total_vIPI->tag = 'vIPI';
        $this->total_vIPI->valor = 0.00;
        $this->total_vIPI->obrigatorio = true;
        $this->total_vIPI->tipo = NUMERO;
        $this->total_vIPI->casas_decimais = 2;

        $this->total_vPIS = new NFe_campo();
        $this->total_vPIS->tag = 'vPIS';
        $this->total_vPIS->valor = 0.00;
        $this->total_vPIS->obrigatorio = true;
        $this->total_vPIS->tipo = NUMERO;
        $this->total_vPIS->casas_decimais = 2;

        $this->total_vCOFINS = new NFe_campo();
        $this->total_vCOFINS->tag = 'vCOFINS';
        $this->total_vCOFINS->valor = 0.00;
        $this->total_vCOFINS->obrigatorio = true;
        $this->total_vCOFINS->tipo = NUMERO;
        $this->total_vCOFINS->casas_decimais = 2;

        $this->total_vOutro = new NFe_campo();
        $this->total_vOutro->tag = 'vOutro';
        $this->total_vOutro->valor = 0.00;
        $this->total_vOutro->obrigatorio = true;
        $this->total_vOutro->tipo = NUMERO;
        $this->total_vOutro->casas_decimais = 2;

        $this->total_vNF = new NFe_campo();
        $this->total_vNF->tag = 'vNF';
        $this->total_vNF->valor = 0.00;
        $this->total_vNF->obrigatorio = true;
        $this->total_vNF->tipo = NUMERO;
        $this->total_vNF->casas_decimais = 2;

        $this->total_ISSQN_vServ = new NFe_campo();
        $this->total_ISSQN_vServ->tag = 'vServ';
        $this->total_ISSQN_vServ->tipo = NUMERO;
        $this->total_ISSQN_vServ->casas_decimais = 2;

        $this->total_ISSQN_vBC = new NFe_campo();
        $this->total_ISSQN_vBC->tag = 'vBC';
        $this->total_ISSQN_vBC->tipo = NUMERO;
        $this->total_ISSQN_vBC->casas_decimais = 2;

        $this->total_ISSQN_vISS = new NFe_campo();
        $this->total_ISSQN_vISS->tag = 'vISS';
        $this->total_ISSQN_vISS->tipo = NUMERO;
        $this->total_ISSQN_vISS->casas_decimais = 2;

        $this->total_ISSQN_vPIS = new NFe_campo();
        $this->total_ISSQN_vPIS->tag = 'vPIS';
        $this->total_ISSQN_vPIS->tipo = NUMERO;
        $this->total_ISSQN_vPIS->casas_decimais = 2;

        $this->total_ISSQN_vCOFINS = new NFe_campo();
        $this->total_ISSQN_vCOFINS->tag = 'vCOFINS';
        $this->total_ISSQN_vCOFINS->tipo = NUMERO;
        $this->total_ISSQN_vCOFINS->casas_decimais = 2;

        $this->transp_modFrete = new NFe_campo();
        $this->transp_modFrete->tag = 'modFrete';
        $this->transp_modFrete->obrigatorio = true;

        $this->transp_CNPJ = new NFe_campo();
        $this->transp_CNPJ->tag = 'CNPJ';

        $this->transp_CPF = new NFe_campo();
        $this->transp_CPF->tag = 'CPF';

        $this->transp_xNome = new NFe_campo();
        $this->transp_xNome->tag = 'xNome';

        $this->transp_IE = new NFe_campo();
        $this->transp_IE->tag = 'IE';

        $this->transp_xEnder = new NFe_campo();
        $this->transp_xEnder->tag = 'xEnder';

        $this->transp_xMun = new NFe_campo();
        $this->transp_xMun->tag = 'xMun';

        $this->transp_UF = new NFe_campo();
        $this->transp_UF->tag = 'UF';

        $this->transp_veicTransp_Placa = new NFe_campo();
        $this->transp_veicTransp_Placa->tag = 'placa';

        $this->transp_veicTransp_UF = new NFe_campo();
        $this->transp_veicTransp_UF->tag = 'UF';

        $this->transp_esp = new NFe_campo();
        $this->transp_esp->tag = 'esp';

        $this->transp_marca = new NFe_campo();
        $this->transp_marca->tag = 'marca';

        $this->transp_qVol = new NFe_campo();
        $this->transp_qVol->tag = 'qVol';
        $this->transp_qVol->tipo = NUMERO;

        $this->transp_nVol = new NFe_campo();
        $this->transp_nVol->tag = 'nVol';

        $this->transp_pesoL = new NFe_campo();
        $this->transp_pesoL->tag = 'pesoL';
        $this->transp_pesoL->tipo = NUMERO;
        $this->transp_pesoL->casas_decimais = 3;

        $this->transp_pesoB = new NFe_campo();
        $this->transp_pesoB->tag = 'pesoB';
        $this->transp_pesoB->tipo = NUMERO;
        $this->transp_pesoB->casas_decimais = 3;

        $this->cobr_fat_nFat = new NFe_campo();
        $this->cobr_fat_nFat->tag = 'nFat';

        $this->cobr_fat_vOrig = new NFe_campo();
        $this->cobr_fat_vOrig->tag = 'vOrig';

        $this->cobr_fat_vDesc = new NFe_campo();
        $this->cobr_fat_vDesc->tag = 'vDesc';
        $this->cobr_fat_vDesc->tipo = NUMERO;
        $this->cobr_fat_vDesc->casas_decimais = 2;

        $this->cobr_fat_vLiq = new NFe_campo();
        $this->cobr_fat_vLiq->tag = 'vLiq';
        $this->cobr_fat_vLiq->tipo = NUMERO;
        $this->cobr_fat_vLiq->casas_decimais = 2;

        $this->infAdic_infAdFisco = new NFe_campo();
        $this->infAdic_infAdFisco->tag = 'infAdFisco';

        $this->infAdic_infCpl = new NFe_campo();
        $this->infAdic_infCpl->tag = 'infCpl';

        $this->exporta_UFEmbarq = new NFe_campo();
        $this->exporta_UFEmbarq->tag = 'UFEmbarq';

        $this->exporta_xLocEmbarq = new NFe_campo();
        $this->exporta_xLocEmbarq->tag = 'xLocEmbarq';

        //v2.0
        $this->ide_hSaiEnt = new NFe_campo();
        $this->ide_hSaiEnt->tag = 'hSaiEnt';
        $this->ide_hSaiEnt->tipo = HORA;

        $this->ide_dhCont = new NFe_campo();
        $this->ide_dhCont->tag = 'dhCont';

        $this->ide_xJust = new NFe_campo();
        $this->ide_xJust->tag = 'xJust';

        $this->emit_CRT = new NFe_campo();
        $this->emit_CRT->tag = 'CRT';
        $this->emit_CRT->obrigatorio = true;

        $this->dest_email = new NFe_campo();
        $this->dest_email->tag = 'email';

        $this->retirada_CPF = new NFe_campo();
        $this->retirada_CPF->tag = 'CPF';

        $this->entrega_CPF = new NFe_campo();
        $this->entrega_CPF->tag = 'CPF';

        $this->Itens = array();
        $this->qtdeItens = 0;
        $this->Duplicatas = array();

        $this->status = GERADA;
        $this->msg_erro = '';
        $this->cod_ret = '';
        $this->recibo = 0;
        $this->nProt = 0;
        $this->digVal = '';
        $this->xJust = '';
        $this->dhRecbto = '';
        $this->verAplic = '';

        $this->MySQLHost = '';
        $this->MySQLUser = '';
        $this->MySQLPass = '';
        $this->MySQLBD = '';
        $this->conMysql = null;

        $this->IdLote = 0;

        $this->filial = 0;
        $this->pedido = 0;
        $this->cliente_cod = 0;
        $this->cliente_fil = 0;
        $this->cliente_cf = '';
        $this->forma_pag_tipo = 0;
        $this->forma_pag_cod = 0;
        $this->transportadora_cod = 0;

        $this->vendedor_cod = 0;
        $this->vendedor_fil = 0;
        $this->p_comissao = 0.00;
        $this->v_comissao = 0.00;
        $this->pvenda_pservico = '';

        $this->erros = array();

        $this->ambiente = 1;
        $this->UFcod = '43';

        $this->calcTotal = true;

        $this->tools = new NFe_tools($this->versaoNFe);
    }

    public function inicializa() {
        $this->conMysql = mysql_connect($this->MySQLHost, $this->MySQLUser, $this->MySQLPass);
        if (!$this->conMysql) {
            $this->erros [] = "Não foi possível conectar ao servidor de banco de dados.";
        }

        if (!mysql_select_db($this->MySQLBD, $this->conMysql)) {
            $this->erros [] = "Banco de dados não encontrado.";
        }

        $this->tools->UFcod = $this->UFcod;
        $this->tools->ambiente = $this->ambiente;
        if ($this->pathCerts == null) {
            $this->tools->pathCerts = $this->path . '/certs/';
        } else {
            $this->tools->pathCerts = $this->pathCerts;
        }
        $this->tools->nameCert = $this->nameCert;
        $this->tools->passKey = $this->passKey;
        $this->tools->passPhrase = $this->passKey;

        $this->tools->entradasNF = $this->path . '/notas/entradas/';
        $this->tools->assinadasNF = $this->path . '/notas/assinadas/';
        $this->tools->validadasNF = $this->path . '/notas/validadas/';
        $this->tools->aprovadasNF = $this->path . '/notas/aprovadas/';
        $this->tools->enviadasNF = $this->path . '/notas/enviadas/';
        $this->tools->canceladasNF = $this->path . '/notas/canceladas/';
        $this->tools->inutilizadasNF = $this->path . '/notas/inutilizadas/';
        $this->tools->temporarioNF = $this->path . '/notas/temporario/';
        $this->tools->recebidasNF = $this->path . '/notas/recebidas/';
        $this->tools->consultadasNF = $this->path . '/notas/consultadas/';
        $this->tools->aprovadasPDF = $this->path . '/notas/pdf_aprovadas/';

        $this->tools->getWebServices();

        if (!$this->temErro()) {
            $this->tools->carregaCert();
        }
    }

    public function processa() {
        $xmlAprovada = '';

        if ($this->temErro()) {
            return false;
        }

        $this->ide_tpAmb->valor = $this->ambiente;
        $this->geraXML();

        $xmlFile = $this->tools->temporarioNF . $this->Id . '-nfe.xml';
        $f = fopen($xmlFile, 'w+');
        fwrite($f, $this->XML);
        fclose($f);


        //$xmlFile = $this->tools->assinadasNF . $this->Id . '-nfe.xml';
        $this->XML = $this->tools->assina($this->XML, 'infNFe');
        $this->XML = str_replace('<?xml version="1.0"?>', '', $this->XML);

        $xmlAprovada = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" . $this->XML;

        if ($this->versaoNFe == 1) {
            $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
            $xml .= "<enviNFe  xmlns=\"http://www.portalfiscal.inf.br/nfe\" xmlns:ds=\"http://www.w3.org/2000/09/xmldsig#\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" versao=\"1.10\">";
        } else {
            $xml = "<enviNFe  xmlns=\"http://www.portalfiscal.inf.br/nfe\" versao=\"2.00\">";
        }
        $xml .= "<idLote>000000000000001</idLote>";
        $xml .= trim($this->XML);
        $xml .= "</enviNFe>";
        $this->XML = $xml;
        if ($this->versaoNFe == 1) {
            $this->tools->validaXML($this->XML, $this->path . '/Schemas/enviNFe_v1.10.xsd');
        } else {
            $this->tools->validaXML($this->XML, $this->path . '/Schemas/enviNFe_v2.00.xsd');
        }
        if ($this->tools->errorStatus) {
            $erros__ = $this->tools->errorMsg;
            array_pop($erros__);
            $erro__ = array();

            for ($b = 0; $b < count($erros__); $b++) {
                $mystring = substr($erros__[$b], 0, 100);
                $findme = 'uCom';

                $pos = strpos($mystring, $findme);
                if ($pos === false) {
                    
                } else {
                    continue;
                }

                $findme = 'uTrib';

                $pos = strpos($mystring, $findme);
                if ($pos === false) {
                    
                } else {
                    continue;
                }

                if (trim($erros__[$b]) == 'Erro 1839:' || trim($erros__[$b]) == 'Erro 1824:') {
                    continue;
                }
            }

            if (count($erro__) > 0) {
                $this->erros[] = 'Erro na validação do XML';
                $this->erros = array_merge($this->erros, $erro__);
            }
        }

        if (!$this->temErro()) {
            $this->IdLote = $this->geraNumeroLote();
        }

        if (!$this->temErro()) {
            $this->XML = str_replace('<idLote>000000000000001</idLote>', '<idLote>' . $this->strzero($this->IdLote, 15) . '</idLote>', $this->XML);

            $xmlFile = $this->tools->temporarioNF . $this->strzero($this->IdLote, 15) . '-env-lot.xml';
            $f = fopen($xmlFile, 'w+');
            fwrite($f, $this->XML);
            fclose($f);
        }

        if (!$this->temErro()) {
            $this->status = VALIDADA;
            $this->gravaDadosNFe();
        }

        if (!$this->temErro()) {
            $this->enviaNFe();
        }

        /*
          if (!$this->temErro()) {
          $xmlFile = $this->tools->aprovadasNF . $this->Id . '-nfe.xml';
          $f = fopen($xmlFile, 'w+');
          fwrite($f, $xmlAprovada);
          fclose($f);
          }
         */

        return !$this->temErro();
    }

    public function enviaNFe() {
        if ($this->tools->enviaNF($this->XML)) {
            $this->cod_ret = $this->tools->cStat;
            $this->msg_erro = $this->tools->xMotivo;
            $this->verAplic = $this->tools->verAplic;
            if ($this->cod_ret == '103') {
                $this->recibo = $this->tools->nRec;
                $this->dhRecbto = $this->tools->dhRecbto;
                $this->status = ENVIADA;
            } else {
                $this->erros [] = "NFe não foi aceita.";
                $this->erros [] = $this->tools->xMotivo;
                $this->status = RECUSADA;
            }
            $sql = "UPDATE nfe_notas SET status = '" . $this->status . "', cod_ret = " . $this->cod_ret . ", msg_erro = '" . $this->msg_erro . "', recibo = " . $this->recibo . ", dhRecbto = '" . $this->dhRecbto . "', verAplic = '" . $this->verAplic . "' WHERE Id = '" . $this->Id . "'";
            mysql_query($sql, $this->conMysql);

            $sql = "UPDATE nfe_lotes SET recibo = " . $this->recibo . " WHERE IdLote = " . $this->IdLote;
            mysql_query($sql, $this->conMysql);
        } else {
            $this->erros [] = "Falha no envio da NFe.";
            echo '<pre>' . htmlspecialchars($this->tools->debug_str) . '<br>' . $this->tools->errMsg . '</pre>';
        }
    }

    public function verificaNFe($Id) {
        $this->getDadosNFe($Id);
        if ($this->tools->retornoNF($this->recibo)) {
            $this->cod_ret = $this->tools->cStat;
            $this->msg_erro = $this->tools->xMotivo;
            if ($this->cod_ret == '104') {
                $this->cod_ret = $this->tools->aNFe[1]['cStat'];
                $this->msg_erro = $this->tools->aNFe[1]['xMotivo'];
                $this->nProt = $this->tools->aNFe[1]['nProt'];
                $this->digVal = $this->tools->aNFe[1]['digVal'];
                $this->dhRecbto = $this->tools->aNFe[1]['dhRecbto'];

                if ($this->cod_ret == '100') {
                    $this->status = APROVADA;
                } else {
                    $this->erros [] = "NFe não foi aprovada.";
                    $this->erros [] = $this->msg_erro;
                    $this->status = NAO_APROVADA;
                }
            } else {
                $this->erros [] = "NFe não foi aprovada.";
                $this->erros [] = $this->tools->xMotivo;
                $this->status = NAO_APROVADA;
            }
            $sql = "UPDATE nfe_notas SET status = '" . $this->status . "', cod_ret = " . $this->cod_ret . ", msg_erro = '" . $this->msg_erro . "', nProt = " . $this->nProt . ", digVal = '" . $this->digVal . "', dhRecbto = '" . $this->dhRecbto . "' WHERE Id = '" . $this->Id . "'";
            mysql_query($sql, $this->conMysql);
        } else {
            $this->erros [] = "Ocorreu um erro ao consultar a situação da NFe.";
        }

        if ($this->status == APROVADA) {
            $this->salvaNFeAprovada();
        }
    }

    public function geraXML() {
        $this->geraId();
        $this->XML = '<NFe xmlns="http://www.portalfiscal.inf.br/nfe">';
        $this->XML .= sprintf('<infNFe versao="%s" Id="NFe%s">', $this->versao, $this->Id);

        $this->XML .= '<ide>';
        $this->XML .= $this->ide_cUF->getXML();
        $this->XML .= $this->ide_cNF->getXML();
        $this->XML .= $this->ide_natOp->getXML();
        $this->XML .= $this->ide_indPag->getXML();
        $this->XML .= $this->ide_mod->getXML();
        $this->XML .= $this->ide_serie->getXML();
        $this->XML .= $this->ide_nNF->getXML();
        $this->XML .= $this->ide_dEmi->getXML();
        $this->XML .= $this->ide_dSaiEnt->getXML();
        if ($this->versaoNFe == 2) {
            $this->XML .= $this->ide_hSaiEnt->getXML();
        }
        $this->XML .= $this->ide_tpNF->getXML();
        $this->XML .= $this->ide_cMunFG->getXML();
        $this->XML .= $this->ide_refNFe->getXML();
        $this->XML .= $this->ide_tpImp->getXML();
        $this->XML .= $this->ide_tpEmis->getXML();
        $this->XML .= $this->ide_cDV->getXML();
        $this->XML .= $this->ide_tpAmb->getXML();
        $this->XML .= $this->ide_finNFe->getXML();
        $this->XML .= $this->ide_procEmi->getXML();
        $this->XML .= $this->ide_verProc->getXML();
        if ($this->versaoNFe == 2) {
            $this->XML .= $this->ide_dhCont->getXML();
            $this->XML .= $this->ide_xJust->getXML();
        }
        $this->XML .= '</ide>';

        $this->XML .= '<emit>';
        $this->XML .= $this->emit_CNPJ->getXML();
        $this->XML .= $this->emit_CPF->getXML();
        $this->XML .= $this->emit_xNome->getXML();
        $this->XML .= $this->emit_xFant->getXML();
        $this->XML .= '<enderEmit>';
        $this->XML .= $this->enderEmit_xLgr->getXML();
        $this->XML .= $this->enderEmit_nro->getXML();
        $this->XML .= $this->enderEmit_xCpl->getXML();
        $this->XML .= $this->enderEmit_xBairro->getXML();
        $this->XML .= $this->enderEmit_cMun->getXML();
        $this->XML .= $this->enderEmit_xMun->getXML();
        $this->XML .= $this->enderEmit_UF->getXML();
        $this->XML .= $this->enderEmit_CEP->getXML();
        $this->XML .= $this->enderEmit_cPais->getXML();
        $this->XML .= $this->enderEmit_xPais->getXML();
        $this->XML .= $this->enderEmit_fone->getXML();
        $this->XML .= '</enderEmit>';
        $this->XML .= $this->emit_IE->getXML();
        $this->XML .= $this->emit_IEST->getXML();
        $this->XML .= $this->emit_IM->getXML();
        $this->XML .= $this->emit_CNAE->getXML();
        if ($this->versaoNFe == 2) {
            $this->XML .= $this->emit_CRT->getXML();
        }
        $this->XML .= '</emit>';

        $this->XML .= '<dest>';
        if (empty($this->dest_CNPJ->valor) AND empty($this->dest_CPF->valor)) {
            $this->XML .= '<CNPJ></CNPJ>';
        } else {
            $this->XML .= $this->dest_CNPJ->getXML();
            $this->XML .= $this->dest_CPF->getXML();
        }
        $this->XML .= $this->dest_xNome->getXML();
        $this->XML .= '<enderDest>';
        $this->XML .= $this->enderDest_xLgr->getXML();
        $this->XML .= $this->enderDest_nro->getXML();
        $this->XML .= $this->enderDest_xCpl->getXML();
        if (empty($this->enderDest_xBairro->valor)) {
            $this->XML .= '<xBairro></xBairro>';
        } else {
            $this->XML .= $this->enderDest_xBairro->getXML();
        }
        $this->XML .= $this->enderDest_cMun->getXML();
        $this->XML .= $this->enderDest_xMun->getXML();
        $this->XML .= $this->enderDest_UF->getXML();
        $this->XML .= $this->enderDest_CEP->getXML();
        $this->XML .= $this->enderDest_cPais->getXML();
        $this->XML .= $this->enderDest_xPais->getXML();
        $this->XML .= $this->enderDest_fone->getXML();
        $this->XML .= '</enderDest>';
        if (empty($this->dest_IE->valor) OR ($this->dest_IE->valor == 'ISENTO')) {
            if ($this->versaoNFe == 1) {
                $this->XML .= '<IE></IE>';
            } else {
                $this->XML .= '<IE>ISENTO</IE>';
            }
        } else {
            $this->XML .= $this->dest_IE->getXML();
        }
        $this->XML .= $this->dest_ISUF->getXML();
        if ($this->versaoNFe == 2) {
            $this->XML .= $this->dest_email->getXML();
        }
        $this->XML .= '</dest>';

        $retirada = '<retirada>';
        $retirada .= $this->retirada_CNPJ->getXML();
        if ($this->versaoNFe == 2) {
            $this->XML .= $this->retirada_CPF->getXML();
        }
        $retirada .= $this->retirada_xLgr->getXML();
        $retirada .= $this->retirada_nro->getXML();
        $retirada .= $this->retirada_xCpl->getXML();
        $retirada .= $this->retirada_xBairro->getXML();
        $retirada .= $this->retirada_cMun->getXML();
        $retirada .= $this->retirada_xMun->getXML();
        $retirada .= $this->retirada_UF->getXML();
        $retirada .= '</retirada>';
        if ($retirada != '<retirada></retirada>') {
            $this->XML .= $retirada;
        }

        $entrega = '<entrega>';
        $entrega .= $this->entrega_CNPJ->getXML();
        if ($this->versaoNFe == 2) {
            $this->XML .= $this->entrega_CPF->getXML();
        }
        $entrega .= $this->entrega_xLgr->getXML();
        $entrega .= $this->entrega_nro->getXML();
        $entrega .= $this->entrega_xCpl->getXML();
        $entrega .= $this->entrega_xBairro->getXML();
        $entrega .= $this->entrega_cMun->getXML();
        $entrega .= $this->entrega_xMun->getXML();
        $entrega .= $this->entrega_UF->getXML();
        $entrega .= '</entrega>';
        if ($entrega != '<entrega></entrega>') {
            $this->XML .= $entrega;
        }

        if ($this->calcTotal) {
            $this->total_ISSQN_vBC->valor = 0.00;
            $this->total_ISSQN_vISS->valor = 0.00;

            for ($i = 0; $i < count($this->Itens); $i++) {
                $item = $this->Itens[$i];
                $this->XML .= $item->getXML();

                $this->total_vBC->valor += $item->vBC->valor;
                $this->total_vICMS->valor += $item->vICMS->valor;
                $this->total_vBCST->valor += $item->vBCST->valor;
                $this->total_vST->valor += $item->vICMSST->valor;
                $this->total_vProd->valor += $item->vProd->valor;
                $this->total_vFrete->valor += $item->vFrete->valor;
                $this->total_vSeg->valor += $item->vSeg->valor;
                $this->total_vDesc->valor += $item->vDesc->valor;
                //$this->total_vII->valor += $item->vII->valor;
                $this->total_vIPI->valor += $item->IPI_vIPI->valor;
                $this->total_vPIS->valor += $item->PIS_vPIS->valor;
                $this->total_vCOFINS->valor += $item->COFINS_vCOFINS->valor;
                $this->total_ISSQN_vServ->valor += $item->ISSQN_vBC->valor;
                $this->total_ISSQN_vBC->valor += $item->ISSQN_vBC->valor;
                $this->total_ISSQN_vISS->valor += $item->ISSQN_vISSQN->valor;
            }
            $this->total_vNF->valor += $this->total_vProd->valor;
            $this->total_vNF->valor += $this->total_vST->valor;
            $this->total_vNF->valor += $this->total_vFrete->valor;
            $this->total_vNF->valor += $this->total_vSeg->valor;
            $this->total_vNF->valor += $this->total_vIPI->valor;
            $this->total_vNF->valor += $this->total_vOutro->valor;
        } else {
            for ($i = 0; $i < count($this->Itens); $i++) {
                $item = $this->Itens[$i];
                $this->XML .= $item->getXML();
            }
        }

        $this->XML .= '<total>';
        $this->XML .= '<ICMSTot>';
        $this->XML .= $this->total_vBC->getXML();
        $this->XML .= $this->total_vICMS->getXML();
        $this->XML .= $this->total_vBCST->getXML();
        $this->XML .= $this->total_vST->getXML();
        $this->XML .= $this->total_vProd->getXML();
        $this->XML .= $this->total_vFrete->getXML();
        $this->XML .= $this->total_vSeg->getXML();
        $this->XML .= $this->total_vDesc->getXML();
        $this->XML .= $this->total_vII->getXML();
        $this->XML .= $this->total_vIPI->getXML();
        $this->XML .= $this->total_vPIS->getXML();
        $this->XML .= $this->total_vCOFINS->getXML();
        $this->XML .= $this->total_vOutro->getXML();
        $this->XML .= $this->total_vNF->getXML();

        $this->XML .= '</ICMSTot>';

        if (!empty($this->total_ISSQN_vServ->valor) OR !empty($this->total_ISSQN_vBC->valor) OR !empty($this->total_ISSQN_vISS->valor) OR !empty($this->total_ISSQN_vPIS->valor) OR !empty($this->total_ISSQN_vCOFINS->valor)) {
            $this->XML .= '<ISSQNtot>';
            $this->XML .= $this->total_ISSQN_vServ->getXML();
            $this->XML .= $this->total_ISSQN_vBC->getXML();
            $this->XML .= $this->total_ISSQN_vISS->getXML();
            $this->XML .= $this->total_ISSQN_vPIS->getXML();
            $this->XML .= $this->total_ISSQN_vCOFINS->getXML();
            $this->XML .= '</ISSQNtot>';
        }

        $this->XML .= '</total>';

        //Transporte
        $this->XML .= '<transp>';
        $this->XML .= $this->transp_modFrete->getXML();

        $transporta = '<transporta>';
        $transporta .= $this->transp_CNPJ->getXML();
        $transporta .= $this->transp_CPF->getXML();
        $transporta .= $this->transp_xNome->getXML();
        $transporta .= $this->transp_IE->getXML();
        $transporta .= $this->transp_xEnder->getXML();
        $transporta .= $this->transp_xMun->getXML();
        $transporta .= $this->transp_UF->getXML();
        $transporta .= '</transporta>';
        if ($transporta != '<transporta></transporta>') {
            $this->XML .= $transporta;
        }

        $veicTransp = '<veicTransp>';
        $veicTransp .= $this->transp_veicTransp_Placa->getXML();
        $veicTransp .= $this->transp_veicTransp_UF->getXML();
        $veicTransp .= '</veicTransp>';
        if ($veicTransp != '<veicTransp></veicTransp>') {
            $this->XML .= $veicTransp;
        }

        $vol = '<vol>';
        $vol .= $this->transp_qVol->getXML();
        $vol .= $this->transp_esp->getXML();
        $vol .= $this->transp_marca->getXML();
        $vol .= $this->transp_nVol->getXML();
        $vol .= $this->transp_pesoL->getXML();
        $vol .= $this->transp_pesoB->getXML();
        $vol .= '</vol>';
        if ($vol != '<vol></vol>') {
            $this->XML .= $vol;
        }

        $this->XML .= '</transp>';

        //cobranca
        $cobr = '<cobr>';

        $fat = '<fat>';
        $fat .= $this->cobr_fat_nFat->getXML();
        $fat .= $this->cobr_fat_vOrig->getXML();
        $fat .= $this->cobr_fat_vDesc->getXML();
        $fat .= $this->cobr_fat_vLiq->getXML();
        $fat .= '</fat>';
        if ($fat != '<fat></fat>') {
            $cobr .= $fat;
        }

        for ($i = 0; $i < count($this->Duplicatas); $i++) {
            $duplicata = $this->Duplicatas[$i];
            $cobr .= $duplicata->getXML();
        }

        $cobr .= '</cobr>';
        if ($cobr != '<cobr></cobr>') {
            $this->XML .= $cobr;
        }

        $infAdic = '<infAdic>';
        $infAdic .= $this->infAdic_infAdFisco->getXML();
        $infAdic .= $this->infAdic_infCpl->getXML();
        $infAdic .= '</infAdic>';
        if ($infAdic != '<infAdic></infAdic>') {
            $this->XML .= $infAdic;
        }

        $exporta = '<exporta>';
        $exporta .= $this->exporta_UFEmbarq->getXML();
        $exporta .= $this->exporta_xLocEmbarq->getXML();
        $exporta .= '</exporta>';
        if ($exporta != '<exporta></exporta>') {
            $this->XML .= $exporta;
        }

        $this->XML .= '</infNFe>';
        $this->XML .= '</NFe>';
    }

    public function addProd($p) {
        $this->qtdeItens++;
        $p->nItem = $this->qtdeItens;
        $this->Itens [] = $p;
    }

    public function countProd() {
        return $this->qtdeItens;
    }

    public function getProd($i) {
        return $this->Itens[$i];
    }

    public function addDup($d) {
        $this->Duplicatas [] = $d;
    }

    public function countDup() {
        return count($this->Duplicatas);
    }

    public function getDup($i) {
        return $this->Duplicatas[$i];
    }

    private function geraId() {
        if ($this->versaoNFe == 1) {
            $ide_nNF = $this->strzero($this->ide_nNF->valor, 9);
            $this->ide_cNF->valor = '9' . substr($ide_nNF, 1, 8);
        } else {
            $ide_nNF = $this->strzero($this->ide_nNF->valor, 9);
            $this->ide_cNF->valor = '9' . substr($ide_nNF, 1, 7);
        }
        $AnoMes = substr($this->ide_dEmi->valor, 2, 2) . substr($this->ide_dEmi->valor, 5, 2);

        $Id = $this->ide_cUF->valor . $AnoMes . $this->emit_CNPJ->valor . $this->ide_mod->valor;
        $Id .= $this->strzero($this->ide_serie->valor, 3) . $ide_nNF . $this->ide_tpEmis->valor . $this->ide_cNF->valor;

        $this->ide_cDV->valor = $this->calcaulaDV($Id);
        $this->Id = $Id . $this->ide_cDV->valor;
    }

    private function strzero($n, $tamanho) {
        $conteudo = (string) $n;
        $diferenca = $tamanho - strlen($conteudo);
        if ($diferenca > 0)
            for ($i = 0; $i < $diferenca; $i++)
                $conteudo = '0' . $conteudo;
        return $conteudo;
    }

    private function inverte($n) {
        $ret = '';
        $s = (string) $n;
        for ($i = strlen($s) - 1; $i >= 0; $i--) {
            $ret .= $s[$i];
        }
        return $ret;
    }

    private function calcaulaDV($n) {
        $dv = 0;
        $s = (string) $n;
        $soma = 0;
        $mult = 2;
        for ($i = strlen($s) - 1; $i >= 0; $i--) {
            $valor = (int) $s[$i];
            $soma += $valor * $mult;
            if ($mult == 9) {
                $mult = 2;
            } else {
                $mult++;
            }
        }

        $resto = $soma % 11;
        if ($resto > 1) {
            $dv = 11 - $resto;
        }

        return $dv;
    }

    public function gravaDadosNFe() {
        $query = "SELECT * FROM nfe_notas WHERE Id = '" . $this->Id . "'";
        $q = mysql_query($query, $this->conMysql);
        if (mysql_num_rows($q) > 0) {
            $query = "DELETE FROM nfe_duplicatas WHERE Id = '" . $this->Id . "'";
            mysql_query($query, $this->conMysql);
            $query = "DELETE FROM nfe_produtos WHERE Id = '" . $this->Id . "'";
            mysql_query($query, $this->conMysql);
            $query = "DELETE FROM nfe_notas WHERE Id = '" . $this->Id . "'";
            mysql_query($query, $this->conMysql);
            $query = "DELETE FROM nfe_di WHERE Id = '" . $this->Id . "'";
            mysql_query($query, $this->conMysql);
            $query = "DELETE FROM nfe_di_adi WHERE Id = '" . $this->Id . "'";
            mysql_query($query, $this->conMysql);
        }

        $query = "INSERT INTO nfe_notas VALUES(";
        $query .= "'" . $this->Id . "', ";
        $query .= "'" . $this->versao . "', ";
        $query .= "" . $this->ide_cUF->getValor() . ", ";
        $query .= "" . $this->ide_cNF->getValor() . ", ";
        $query .= "'" . $this->ide_natOp->getValor() . "', ";
        $query .= "'" . $this->ide_indPag->getValor() . "', ";
        $query .= "'" . $this->ide_mod->getValor() . "', ";
        $query .= "" . $this->ide_serie->getValor() . ", ";
        $query .= "" . $this->ide_nNF->getValor() . ", ";
        $query .= "'" . $this->ide_dEmi->getValor() . "', ";

        $x = $this->ide_dSaiEnt->getValor();
        if (empty($x)) {
            $query .= 'NULL, ';
        } else {
            $query .= "'" . $this->ide_dSaiEnt->getValor() . "', ";
        }

        $query .= "'" . $this->ide_tpNF->getValor() . "', ";

        $x = $this->ide_cMunFG->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->ide_cMunFG->getValor() . ", ";
        }

        $query .= "'" . $this->ide_refNFe->getValor() . "', ";
        $query .= "'" . $this->ide_tpImp->getValor() . "', ";
        $query .= "'" . $this->ide_tpEmis->getValor() . "', ";
        $query .= "" . $this->ide_cDV->getValor() . ", ";
        $query .= "'" . $this->ide_tpAmb->getValor() . "', ";
        $query .= "'" . $this->ide_finNFe->getValor() . "', ";
        $query .= "'" . $this->ide_procEmi->getValor() . "', ";
        $query .= "'" . $this->ide_verProc->getValor() . "', ";
        $query .= "'" . $this->emit_CNPJ->getValor() . "', ";
        $query .= "'" . $this->emit_xNome->getValor() . "', ";
        $query .= "'" . $this->emit_xFant->getValor() . "', ";
        $query .= "'" . $this->enderEmit_xLgr->getValor() . "', ";
        $query .= "'" . $this->enderEmit_nro->getValor() . "', ";
        $query .= "'" . $this->enderEmit_xCpl->getValor() . "', ";
        $query .= "'" . $this->enderEmit_xBairro->getValor() . "', ";

        $x = $this->enderEmit_cMun->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->enderEmit_cMun->getValor() . ", ";
        }

        $query .= "'" . $this->enderEmit_xMun->getValor() . "', ";
        $query .= "'" . $this->enderEmit_UF->getValor() . "', ";
        $query .= "'" . $this->enderEmit_CEP->getValor() . "', ";

        $x = $this->enderEmit_cPais->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->enderEmit_cPais->getValor() . ", ";
        }

        $query .= "'" . $this->enderEmit_xPais->getValor() . "', ";

        $x = $this->enderEmit_fone->getValor();
        if (empty($x)) {
            $query .= "0, ";
        } else {
            $query .= "" . $this->enderEmit_fone->getValor() . ", ";
        }

        $query .= "'" . $this->emit_IE->getValor() . "', ";
        $query .= "'" . $this->emit_IEST->getValor() . "', ";
        $query .= "'" . $this->emit_IM->getValor() . "', ";
        $query .= "'" . $this->emit_CNAE->getValor() . "', ";
        $query .= "'" . (empty($this->dest_CNPJ->valor) ? $this->dest_CPF->getValor() : $this->dest_CNPJ->getValor()) . "', ";
        $query .= "'" . $this->dest_xNome->getValor() . "', ";
        $query .= "'" . $this->enderDest_xLgr->getValor() . "', ";
        $query .= "'" . $this->enderDest_nro->getValor() . "', ";
        $query .= "'" . $this->enderDest_xCpl->getValor() . "', ";
        $query .= "'" . $this->enderDest_xBairro->getValor() . "', ";

        $x = $this->enderDest_cMun->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->enderDest_cMun->getValor() . ", ";
        }

        $query .= "'" . $this->enderDest_xMun->getValor() . "', ";
        $query .= "'" . $this->enderDest_UF->getValor() . "', ";
        $query .= "'" . $this->enderDest_CEP->getValor() . "', ";

        $x = $this->enderDest_cPais->getValor();
        if (empty($x)) {
            $query .= "0, ";
        } else {
            $query .= "" . $this->enderDest_cPais->getValor() . ", ";
        }

        $query .= "'" . $this->enderDest_xPais->getValor() . "', ";

        $x = $this->enderDest_fone->getValor();
        if (empty($x)) {
            $query .= "0, ";
        } else {
            $query .= "" . $this->enderDest_fone->getValor() . ", ";
        }

        $query .= "'" . $this->dest_IE->getValor() . "', ";
        $query .= "'" . $this->dest_ISUF->getValor() . "', ";
        $query .= "'" . $this->retirada_CNPJ->getValor() . "', ";
        $query .= "'" . $this->retirada_xLgr->getValor() . "', ";
        $query .= "'" . $this->retirada_nro->getValor() . "', ";
        $query .= "'" . $this->retirada_xCpl->getValor() . "', ";
        $query .= "'" . $this->retirada_xBairro->getValor() . "', ";

        $x = $this->retirada_cMun->getValor();
        if (empty($x)) {
            $query .= "0, ";
        } else {
            $query .= "" . $this->retirada_cMun->getValor() . ", ";
        }

        $query .= "'" . $this->retirada_xMun->getValor() . "', ";
        $query .= "'" . $this->retirada_UF->getValor() . "', ";
        $query .= "'" . $this->entrega_CNPJ->getValor() . "', ";
        $query .= "'" . $this->entrega_xLgr->getValor() . "', ";
        $query .= "'" . $this->entrega_nro->getValor() . "', ";
        $query .= "'" . $this->entrega_xCpl->getValor() . "', ";
        $query .= "'" . $this->entrega_xBairro->getValor() . "', ";

        $x = $this->entrega_cMun->getValor();
        if (empty($x)) {
            $query .= "0, ";
        } else {
            $query .= "" . $this->entrega_cMun->getValor() . ", ";
        }

        $query .= "'" . $this->entrega_xMun->getValor() . "', ";
        $query .= "'" . $this->entrega_UF->getValor() . "', ";
        $query .= "" . $this->total_vBC->getValor() . ", ";
        $query .= "" . $this->total_vICMS->getValor() . ", ";
        $query .= "" . $this->total_vBCST->getValor() . ", ";
        $query .= "" . $this->total_vST->getValor() . ", ";
        $query .= "" . $this->total_vProd->getValor() . ", ";
        $query .= "" . $this->total_vFrete->getValor() . ", ";
        $query .= "" . $this->total_vSeg->getValor() . ", ";
        $query .= "" . $this->total_vDesc->getValor() . ", ";
        $query .= "" . $this->total_vII->getValor() . ", ";
        $query .= "" . $this->total_vIPI->getValor() . ", ";
        $query .= "" . $this->total_vPIS->getValor() . ", ";
        $query .= "" . $this->total_vCOFINS->getValor() . ", ";
        $query .= "" . $this->total_vOutro->getValor() . ", ";
        $query .= "" . $this->total_vNF->getValor() . ", ";
        $query .= "'" . $this->transp_modFrete->getValor() . "', ";
        $query .= "'" . $this->transp_CNPJ->getValor() . "', ";
        $query .= "'" . $this->transp_xNome->getValor() . "', ";
        $query .= "'" . $this->transp_IE->getValor() . "', ";
        $query .= "'" . $this->transp_xEnder->getValor() . "', ";
        $query .= "'" . $this->transp_xMun->getValor() . "', ";
        $query .= "'" . $this->transp_UF->getValor() . "', ";
        $query .= "'" . $this->transp_veicTransp_Placa->getValor() . "', ";
        $query .= "'" . $this->transp_veicTransp_UF->getValor() . "', ";

        $query .= "" . $this->transp_qVol->getValor() . ", ";
        $query .= "'" . $this->transp_esp->getValor() . "', ";
        $query .= "'" . $this->transp_marca->getValor() . "', ";
        $query .= "'" . $this->transp_nVol->getValor() . "', ";


        $x = $this->transp_pesoL->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->transp_pesoL->getValor() . ", ";
        }

        $x = $this->transp_pesoB->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->transp_pesoB->getValor() . ", ";
        }

        $query .= "'" . $this->cobr_fat_nFat->getValor() . "', ";

        $x = $this->cobr_fat_vOrig->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->cobr_fat_vOrig->getValor() . ", ";
        }

        $x = $this->cobr_fat_vDesc->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->cobr_fat_vDesc->getValor() . ", ";
        }

        $x = $this->cobr_fat_vLiq->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->cobr_fat_vLiq->getValor() . ", ";
        }

        $query .= "'" . $this->infAdic_infAdFisco->getValor() . "', ";
        $query .= "'" . $this->infAdic_infCpl->getValor() . "', ";
        $query .= "'" . $this->status . "', ";
        $query .= "'" . $this->cod_ret . "', ";
        $query .= "'" . $this->msg_erro . "', ";
        $query .= "'" . addslashes($this->XML) . "', ";
        $query .= "" . $this->IdLote . ", ";
        $query .= "" . $this->recibo . ", ";
        $query .= "" . $this->nProt . ", ";
        $query .= "'" . $this->digVal . "', ";
        $query .= "'" . $this->xJust . "', ";
        $query .= "'" . $this->dhRecbto . "', ";
        $query .= "'" . $this->verAplic . "', 'N', ";

        $x = $this->total_ISSQN_vServ->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->total_ISSQN_vServ->getValor() . ", ";
        }

        $x = $this->total_ISSQN_vBC->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->total_ISSQN_vBC->getValor() . ", ";
        }

        $x = $this->total_ISSQN_vISS->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->total_ISSQN_vISS->getValor() . ", ";
        }

        $x = $this->total_ISSQN_vPIS->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->total_ISSQN_vPIS->getValor() . ", ";
        }

        $x = $this->total_ISSQN_vCOFINS->getValor();
        if (empty($x)) {
            $query .= '0, ';
        } else {
            $query .= "" . $this->total_ISSQN_vCOFINS->getValor() . ", ";
        }
        $query .= "'" . $this->exporta_UFEmbarq->getValor() . "', ";
        $query .= "'" . $this->exporta_xLocEmbarq->getValor() . "', ";
        $query .= "" . $this->filial . ", ";
        $query .= "" . $this->pedido . ", ";
        $query .= "" . $this->cliente_cod . ", ";
        $query .= "" . $this->cliente_fil . ", ";
        $query .= "'" . $this->cliente_cf . "', ";
        $query .= "'" . $this->forma_pag_tipo . "', ";
        $query .= "" . $this->forma_pag_cod . ", ";
        $query .= "" . $this->transportadora_cod . ", ";
        $query .= "" . $this->vendedor_cod . ", ";
        $query .= "" . $this->vendedor_fil . ", ";
        $query .= "" . $this->p_comissao . ", ";
        $query .= "" . $this->v_comissao . ", ";
        $query .= "'" . $this->pvenda_pservico . "'";

        if ($this->versaoNFe == 2) {
            $query .= ",";

            $x = $this->ide_hSaiEnt->getValor();
            if (empty($x)) {
                $query .= 'NULL, ';
            } else {
                $query .= "'" . $this->ide_hSaiEnt->getValor() . "', ";
            }

            $query .= "'" . $this->ide_dhCont->getValor() . "', ";
            $query .= "'" . $this->ide_xJust->getValor() . "', ";
            $query .= "'" . $this->emit_CRT->getValor() . "', ";
            $query .= "'" . $this->dest_email->getValor() . "', ";
            $query .= "'" . $this->retirada_CPF->getValor() . "', ";
            $query .= "'" . $this->entrega_CPF->getValor() . "'";
        }

        $query .= ") ";

        if (!mysql_query($query, $this->conMysql)) {
            echo $query . '<br>';
            $this->erros [] = "Ocorreu um erro ao gravar a nota fiscal.";
            $this->erros [] = mysql_error($this->conMysql);
            return false;
        }

        for ($i = 0; $i < $this->countProd(); $i++) {
            $prod = $this->getProd($i);
            $query = "INSERT INTO nfe_produtos VALUES(";
            $query .= "'" . $this->Id . "', ";
            $query .= "" . $prod->nItem . ", ";
            $query .= "'" . $prod->cProd->getValor() . "', ";
            $query .= "'" . $prod->cEAN->getValor() . "', ";
            $query .= "'" . $prod->xProd->getValor() . "', ";
            $query .= "'" . $prod->NCM->getValor() . "', ";
            $query .= "'" . $prod->EXTIPI->getValor() . "', ";
            $query .= "'" . $prod->genero->getValor() . "', ";
            $query .= "'" . $prod->CFOP->getValor() . "', ";
            $query .= "'" . $prod->uCom->getValor() . "', ";

            $x = $prod->qCom->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->qCom->getValor() . ", ";
            }

            $x = $prod->vUnCom->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->vUnCom->getValor() . ", ";
            }

            $x = $prod->vProd->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->vProd->getValor() . ", ";
            }

            $query .= "'" . $prod->cEANTrib->getValor() . "', ";
            $query .= "'" . $prod->uTrib->getValor() . "', ";

            $x = $prod->qTrib->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->qTrib->getValor() . ", ";
            }

            $x = $prod->vUnTrib->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->vUnTrib->getValor() . ", ";
            }

            $x = $prod->vFrete->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->vFrete->getValor() . ", ";
            }

            $x = $prod->vSeg->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->vSeg->getValor() . ", ";
            }

            $x = $prod->vDesc->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->vDesc->getValor() . ", ";
            }

            $query .= "'" . $prod->orig->getValor() . "', ";
            $query .= "'" . $prod->CST->getValor() . "', ";
            $query .= "'" . $prod->modBC->getValor() . "', ";

            $x = $prod->pRedBC->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->pRedBC->getValor() . ", ";
            }

            $x = $prod->vBC->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->vBC->getValor() . ", ";
            }

            $x = $prod->pICMS->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->pICMS->getValor() . ", ";
            }

            $x = $prod->vICMS->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->vICMS->getValor() . ", ";
            }

            $query .= "'" . $prod->modBCST->getValor() . "', ";

            $x = $prod->pMVAST->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->pMVAST->getValor() . ", ";
            }

            $x = $prod->pRedBCST->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->pRedBCST->getValor() . ", ";
            }

            $x = $prod->vBCST->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->vBCST->getValor() . ", ";
            }

            $x = $prod->pICMSST->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->pICMSST->getValor() . ", ";
            }

            $x = $prod->vICMSST->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->vICMSST->getValor() . ", ";
            }

            $query .= "'" . $prod->IPI_clEnq->getValor() . "', ";
            $query .= "'" . $prod->IPI_CNPJProd->getValor() . "', ";
            $query .= "'" . $prod->IPI_cSelo->getValor() . "', ";

            $x = $prod->IPI_qSelo->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->IPI_qSelo->getValor() . ", ";
            }


            $query .= "'" . $prod->IPI_cEnq->getValor() . "', ";
            $query .= "'" . $prod->IPI_CST->getValor() . "', ";

            $x = $prod->IPI_vBC->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->IPI_vBC->getValor() . ", ";
            }

            $x = $prod->IPI_qUnid->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->IPI_qUnid->getValor() . ", ";
            }

            $x = $prod->IPI_vUnid->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->IPI_vUnid->getValor() . ", ";
            }

            $x = $prod->IPI_pIPI->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->IPI_pIPI->getValor() . ", ";
            }

            $x = $prod->IPI_vIPI->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->IPI_vIPI->getValor() . ", ";
            }

            $x = $prod->PIS_CST->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->PIS_CST->getValor() . ", ";
            }

            $x = $prod->PIS_vBC->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->PIS_vBC->getValor() . ", ";
            }

            $x = $prod->PIS_pPIS->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->PIS_pPIS->getValor() . ", ";
            }

            $x = $prod->PIS_vPIS->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->PIS_vPIS->getValor() . ", ";
            }

            $x = $prod->PIS_qBCProd->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->PIS_qBCProd->getValor() . ", ";
            }

            $x = $prod->PIS_vAliqProd->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->PIS_vAliqProd->getValor() . ", ";
            }

            $x = $prod->PISST_vBC->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->PISST_vBC->getValor() . ", ";
            }

            $x = $prod->PISST_pPIS->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->PISST_pPIS->getValor() . ", ";
            }

            $x = $prod->PISST_qBCProd->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->PISST_qBCProd->getValor() . ", ";
            }

            $x = $prod->PISST_vAliqProd->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->PISST_vAliqProd->getValor() . ", ";
            }

            $x = $prod->PISST_vPIS->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->PISST_vPIS->getValor() . ", ";
            }

            $query .= "'" . $prod->COFINS_CST->getValor() . "', ";

            $x = $prod->COFINS_vBC->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->COFINS_vBC->getValor() . ", ";
            }

            $x = $prod->COFINS_pCOFINS->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->COFINS_pCOFINS->getValor() . ", ";
            }

            $x = $prod->COFINS_vCOFINS->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->COFINS_vCOFINS->getValor() . ", ";
            }

            $x = $prod->COFINS_qBCProd->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->COFINS_qBCProd->getValor() . ", ";
            }

            $x = $prod->COFINS_vAliqProd->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->COFINS_vAliqProd->getValor() . ", ";
            }

            $x = $prod->COFINSST_vBC->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->COFINSST_vBC->getValor() . ", ";
            }

            $x = $prod->COFINSST_pCOFINS->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->COFINSST_pCOFINS->getValor() . ", ";
            }

            $x = $prod->COFINSST_vCOFINS->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->COFINSST_vCOFINS->getValor() . ", ";
            }

            $x = $prod->COFINSST_qBCProd->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->COFINSST_qBCProd->getValor() . ", ";
            }

            $x = $prod->COFINSST_vAliqProd->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->COFINSST_vAliqProd->getValor() . ", ";
            }

            $query .= "'" . $prod->infAdProd->getValor() . "',";

            $x = $prod->ISSQN_vBC->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->ISSQN_vBC->getValor() . ", ";
            }

            $x = $prod->ISSQN_vAliq->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->ISSQN_vAliq->getValor() . ", ";
            }

            $x = $prod->ISSQN_vISSQN->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->ISSQN_vISSQN->getValor() . ", ";
            }

            $x = $prod->ISSQN_cMunFG->getValor();
            if (empty($x)) {
                $query .= '0, ';
            } else {
                $query .= "" . $prod->ISSQN_cMunFG->getValor() . ", ";
            }

            $query .= "'" . $prod->ISSQN_cListServ->getValor() . "', ";
            $query .= "" . $prod->produto_cod . ", ";
            $query .= "'" . $prod->prod_serv . "'";

            if ($this->versaoNFe == 2) {
                $query .= ",";

                $x = $prod->vOutro->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->vOutro->getValor() . ", ";
                }

                $query .= "'" . $prod->indTot->getValor() . "', ";

                $x = $prod->vBCSTRet->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->vBCSTRet->getValor() . ", ";
                }

                $x = $prod->vICMSSTRet->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->vICMSSTRet->getValor() . ", ";
                }

                $query .= "'" . $prod->ISSQN_cSitTrib->getValor() . "', ";
                $query .= "'" . $prod->ICMSSN_orig->getValor() . "', ";
                $query .= "'" . $prod->ICMSSN_CSOSN->getValor() . "', ";

                $x = $prod->ICMSSN_pCredSN->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->ICMSSN_pCredSN->getValor() . ", ";
                }

                $x = $prod->ICMSSN_vCredICMSSN->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->ICMSSN_vCredICMSSN->getValor() . ", ";
                }

                $query .= "'" . $prod->ICMSSN_modBCST->getValor() . "', ";

                $x = $prod->ICMSSN_pMVAST->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->ICMSSN_pMVAST->getValor() . ", ";
                }

                $x = $prod->ICMSSN_pRedBCST->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->ICMSSN_pRedBCST->getValor() . ", ";
                }

                $x = $prod->ICMSSN_vBCST->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->ICMSSN_vBCST->getValor() . ", ";
                }

                $x = $prod->ICMSSN_pICMSST->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->ICMSSN_pICMSST->getValor() . ", ";
                }

                $x = $prod->ICMSSN_vICMSST->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->ICMSSN_vICMSST->getValor() . ", ";
                }

                $x = $prod->ICMSSN_vBCSTRet->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->ICMSSN_vBCSTRet->getValor() . ", ";
                }

                $x = $prod->ICMSSN_vICMSSTRet->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->ICMSSN_vICMSSTRet->getValor() . ", ";
                }

                $query .= "'" . $prod->ICMSSN_modBC->getValor() . "', ";

                $x = $prod->ICMSSN_vBC->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->ICMSSN_vBC->getValor() . ", ";
                }

                $x = $prod->ICMSSN_pRedBC->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->ICMSSN_pRedBC->getValor() . ", ";
                }

                $x = $prod->ICMSSN_pICMS->getValor();
                if (empty($x)) {
                    $query .= '0, ';
                } else {
                    $query .= "" . $prod->ICMSSN_pICMS->getValor() . ", ";
                }

                $x = $prod->ICMSSN_vICMS->getValor();
                if (empty($x)) {
                    $query .= '0';
                } else {
                    $query .= "" . $prod->ICMSSN_vICMS->getValor() . "";
                }
            }

            $query .= ")";

            if (!mysql_query($query, $this->conMysql)) {
                //echo $query . '<br>';
                $this->erros [] = "Ocorreu um erro ao gravar os produtos da nota fiscal.";
                $this->erros [] = mysql_error($this->conMysql);
                return false;
            } else {
                for ($j = 0; $j < $prod->countDI(); $j++) {
                    $di = $prod->getDI($j);
                    $query = "INSERT INTO nfe_di VALUES(NULL,";
                    $query .= "'" . $this->Id . "', ";
                    $query .= "" . $prod->nItem . ", ";
                    $query .= "'" . $di->nDI->getValor() . "', ";
                    $query .= "'" . $di->dDI->getValor() . "', ";
                    $query .= "'" . $di->xLocDesemb->getValor() . "', ";
                    $query .= "'" . $di->ufDesemb->getValor() . "', ";
                    $query .= "'" . $di->dDesemb->getValor() . "', ";
                    $query .= "'" . $di->cExportador->getValor() . "')";

                    if (!mysql_query($query, $this->conMysql)) {
                        //echo $query . '<br>';
                        $this->erros [] = "Ocorreu um erro ao gravar os dados da DI.";
                        $this->erros [] = mysql_error($this->conMysql);
                        return false;
                    } else {
                        $query = "SELECT LAST_INSERT_ID()";
                        $q = mysql_query($query, $this->conMysql);
                        $ultID = mysql_result($q, 0, 0);
                        for ($k = 0; $k < $di->countAdi(); $k++) {
                            $adi = $di->getAdi($k);
                            $query = "INSERT INTO nfe_di_adi VALUES(NULL,";
                            $query .= "" . $ultID . ", ";
                            $query .= "'" . $this->Id . "', ";
                            $query .= "'" . $adi->nAdicao->getValor() . "', ";
                            $query .= "'" . $adi->nSeqAdic->getValor() . "', ";
                            $query .= "'" . $adi->cFabricante->getValor() . "', ";
                            $x = $adi->vDescDI->getValor();
                            if (empty($x)) {
                                $query .= '0';
                            } else {
                                $query .= "" . $adi->vDescDI->getValor() . ", ";
                            }
                            $query .= "'" . $adi->xPed->getValor() . "', ";
                            $query .= "'" . $adi->xItemPed->getValor() . "')";
                            if (!mysql_query($query, $this->conMysql)) {
                                $this->erros [] = "Ocorreu um erro ao gravar os dados da Adi.";
                                $this->erros [] = mysql_error($this->conMysql);
                                return false;
                            }
                        }
                    }
                }
            }
        }

        for ($i = 0; $i < $this->countDup(); $i++) {
            $dup = $this->getDup($i);
            $query = "INSERT INTO nfe_duplicatas VALUES(";
            $query .= "'" . $this->Id . "', ";
            $query .= "'" . $dup->cobr_dup_nDup->getValor() . "', ";
            $query .= "'" . $dup->cobr_dup_dVenc->getValor() . "', ";
            $query .= "" . $dup->cobr_dup_vDup->getValor() . ")";
            if (!mysql_query($query, $this->conMysql)) {
                //echo $query . '<br>';
                $this->erros [] = "Ocorreu um erro ao gravar as duplicatas da nota fiscal.";
                $this->erros [] = mysql_error($this->conMysql);
                return false;
            }
        }
    }

    public function geraNumeroLote() {
        $query = "INSERT INTO nfe_lotes(dataEnvio) values (NOW())";

        if (!mysql_query($query, $this->conMysql)) {
            $this->erros [] = "Não foi possível gerar o número do lote.";
            return 0;
        } else {
            return mysql_insert_id($this->conMysql);
        }
    }

    public function getDadosNFe($Id) {
        $query = "SELECT * FROM nfe_notas WHERE Id = '" . $Id . "'";
        $q = mysql_query($query, $this->conMysql);
        $r = mysql_fetch_array($q);

        $this->Id = $r['Id'];
        $this->versao = $r['versao'];
        $this->ide_cUF->valor = $r['ide_cUF'];
        $this->ide_cNF->valor = $r['ide_cNF'];
        $this->ide_natOp->valor = stripslashes($r['ide_natOp']);
        $this->ide_indPag->valor = $r['ide_indPag'];
        $this->ide_mod->valor = $r['ide_mod'];
        $this->ide_serie->valor = $r['ide_serie'];
        $this->ide_nNF->valor = $r['ide_nNF'];
        $this->ide_dEmi->valor = $r['ide_dEmi'];
        $this->ide_dSaiEnt->valor = $r['ide_dSaiEnt'];
        $this->ide_tpNF->valor = $r['ide_tpNF'];
        $this->ide_cMunFG->valor = $r['ide_cMunFG'];
        $this->ide_refNFe->valor = $r['ide_refNFe'];
        $this->ide_tpImp->valor = $r['ide_tpImp'];
        $this->ide_cDV->valor = $r['ide_cDV'];
        $this->ide_tpAmb->valor = $r['ide_tpAmb'];
        $this->ide_finNFe->valor = $r['ide_finNFe'];
        $this->ide_procEmi->valor = $r['ide_procEmi'];
        $this->ide_verProc->valor = $r['ide_verProc'];
        if (strlen($r['emit_CNPJ']) > 11) {
            $this->emit_CNPJ->valor = $r['emit_CNPJ'];
        } else {
            $this->emit_CPF->valor = $r['emit_CNPJ'];
        }
        $this->emit_xNome->valor = stripslashes($r['emit_xNome']);
        $this->emit_xFant->valor = stripslashes($r['emit_xFant']);
        $this->enderEmit_xLgr->valor = stripslashes($r['enderEmit_xLgr']);
        $this->enderEmit_nro->valor = stripslashes($r['enderEmit_nro']);
        $this->enderEmit_xCpl->valor = stripslashes($r['enderEmit_xCpl']);
        $this->enderEmit_xBairro->valor = stripslashes($r['enderEmit_xBairro']);
        $this->enderEmit_cMun->valor = $r['enderEmit_cMun'];
        $this->enderEmit_xMun->valor = stripslashes($r['enderEmit_xMun']);
        $this->enderEmit_UF->valor = $r['enderEmit_UF'];
        $this->enderEmit_CEP->valor = $r['enderEmit_CEP'];
        $this->enderEmit_cPais->valor = $r['enderEmit_cPais'];
        $this->enderEmit_xPais->valor = stripslashes($r['enderEmit_xPais']);
        $this->enderEmit_fone->valor = $r['enderEmit_fone'];
        $this->emit_IE->valor = $r['emit_IE'];
        $this->emit_IEST->valor = $r['emit_IEST'];
        $this->emit_IM->valor = $r['emit_IM'];
        $this->emit_CNAE->valor = $r['emit_CNAE'];
        $this->dest_CNPJ->valor = $r['dest_CNPJ'];
        $this->dest_xNome->valor = stripslashes($r['dest_xNome']);
        $this->enderDest_xLgr->valor = stripslashes($r['enderDest_xLgr']);
        $this->enderDest_nro->valor = stripslashes($r['enderDest_nro']);
        $this->enderDest_xCpl->valor = stripslashes($r['enderDest_xCpl']);
        $this->enderDest_xBairro->valor = stripslashes($r['enderDest_xBairro']);
        $this->enderDest_cMun->valor = $r['enderDest_cMun'];
        $this->enderDest_xMun->valor = stripslashes($r['enderDest_xMun']);
        $this->enderDest_UF->valor = $r['enderDest_UF'];
        $this->enderDest_CEP->valor = $r['enderDest_CEP'];
        $this->enderDest_cPais->valor = $r['enderDest_cPais'];
        $this->enderDest_xPais->valor = stripslashes($r['enderDest_xPais']);
        $this->enderDest_fone->valor = $r['enderDest_fone'];
        $this->dest_IE->valor = $r['dest_IE'];
        $this->dest_ISUF->valor = $r['dest_ISUF'];
        $this->retirada_CNPJ->valor = $r['retirada_CNPJ'];
        $this->retirada_xLgr->valor = stripslashes($r['retirada_xLgr']);
        $this->retirada_nro->valor = stripslashes($r['retirada_nro']);
        $this->retirada_xCpl->valor = stripslashes($r['retirada_xCpl']);
        $this->retirada_xBairro->valor = stripslashes($r['retirada_xBairro']);
        $this->retirada_cMun->valor = $r['retirada_cMun'];
        $this->retirada_xMun->valor = stripslashes($r['retirada_xMun']);
        $this->retirada_UF->valor = $r['retirada_UF'];
        $this->entrega_CNPJ->valor = $r['entrega_CNPJ'];
        $this->entrega_xLgr->valor = stripslashes($r['entrega_xLgr']);
        $this->entrega_nro->valor = stripslashes($r['entrega_nro']);
        $this->entrega_xCpl->valor = stripslashes($r['entrega_xCpl']);
        $this->entrega_xBairro->valor = stripslashes($r['entrega_xBairro']);
        $this->entrega_cMun->valor = $r['entrega_cMun'];

        $this->entrega_xMun->valor = stripslashes($r['entrega_xMun']);
        $this->entrega_UF->valor = $r['entrega_UF'];
        $this->total_vBC->valor = $r['total_vBC'];
        $this->total_vICMS->valor = $r['total_vICMS'];
        $this->total_vBCST->valor = $r['total_vBCST'];
        $this->total_vST->valor = $r['total_vST'];
        $this->total_vProd->valor = $r['total_vProd'];
        $this->total_vFrete->valor = $r['total_vFrete'];
        $this->total_vSeg->valor = $r['total_vSeg'];
        $this->total_vDesc->valor = $r['total_vDesc'];
        $this->total_vII->valor = $r['total_vII'];
        $this->total_vIPI->valor = $r['total_vIPI'];
        $this->total_vPIS->valor = $r['total_vPIS'];
        $this->total_vCOFINS->valor = $r['total_vCOFINS'];
        $this->total_vOutro->valor = $r['total_vOutro'];
        $this->total_vNF->valor = $r['total_vNF'];
        $this->total_ISSQN_vServ->valor = $r['total_ISSQN_vServ'];
        $this->total_ISSQN_vBC->valor = $r['total_ISSQN_vBC'];
        $this->total_ISSQN_vISS->valor = $r['total_ISSQN_vISS'];
        $this->total_ISSQN_vPIS->valor = $r['total_ISSQN_vPIS'];
        $this->total_ISSQN_vCOFINS->valor = $r['total_ISSQN_vCOFINS'];

        $this->transp_modFrete->valor = $r['transp_modFrete'];
        $this->transp_CNPJ->valor = $r['transp_CNPJ'];
        $this->transp_xNome->valor = stripslashes($r['transp_xNome']);
        $this->transp_IE->valor = $r['transp_IE'];
        $this->transp_xEnder->valor = stripslashes($r['transp_xEnder']);
        $this->transp_xMun->valor = stripslashes($r['transp_xMun']);
        $this->transp_UF->valor = $r['transp_UF'];
        $this->transp_veicTransp_Placa->valor = $r['transp_veicTransp_Placa'];
        $this->transp_veicTransp_UF->valor = $r['transp_veicTransp_UF'];

        $this->transp_qVol->valor = $r['transp_qVol'];
        $this->transp_esp->valor = stripslashes($r['transp_esp']);
        $this->transp_marca->valor = stripslashes($r['transp_marca']);
        $this->transp_nVol->valor = stripslashes($r['transp_nVol']);
        $this->transp_pesoL->valor = $r['transp_pesoL'];
        $this->transp_pesoB->valor = $r['transp_pesoB'];

        $this->cobr_fat_nFat->valor = stripslashes($r['cobr_fat_nFat']);
        $this->cobr_fat_vOrig->valor = $r['cobr_fat_vOrig'];
        $this->cobr_fat_vDesc->valor = $r['cobr_fat_vDesc'];
        $this->cobr_fat_vLiq->valor = $r['cobr_fat_vLiq'];

        $this->infAdic_infAdFisco->valor = stripslashes($r['infAdic_infAdFisco']);
        $this->infAdic_infCpl->valor = stripslashes($r['infAdic_infCpl']);

        $this->exporta_UFEmbarq->valor = $r['exporta_UFEmbarq'];
        $this->exporta_xLocEmbarq->valor = $r['exporta_xLocEmbarq'];
        $this->filial = $r['filial'];
        $this->pedido = $r['pedido'];
        $this->cliente_cod = $r['cliente_cod'];
        $this->cliente_fil = $r['cliente_fil'];
        $this->cliente_cf = $r['cliente_cf'];
        $this->forma_pag_tipo = $r['forma_pag_tipo'];
        $this->forma_pag_cod = $r['forma_pag_cod'];
        $this->transportadora_cod = $r['transportadora_cod'];

        $this->status = $r['status'];
        $this->msg_erro = stripslashes($r['msg_erro']);
        $this->XML = stripslashes($r['xml']);
        $this->cod_ret = $r['cod_ret'];

        $this->IdLote = $r['IdLote'];
        $this->recibo = $r['recibo'];
        $this->nProt = $r['nProt'];

        $this->digVal = $r['digVal'];
        $this->dhRecbto = $r['dhRecbto'];
        $this->verAplic = $r['verAplic'];

        $this->filial = $r['filial'];
        $this->pedido = $r['pedido'];
        $this->cliente_cod = $r['cliente_cod'];
        $this->cliente_fil = $r['cliente_fil'];
        $this->cliente_cf = $r['cliente_cf'];
        $this->forma_pag_tipo = $r['forma_pag_tipo'];
        $this->forma_pag_cod = $r['forma_pag_cod'];
        $this->transportadora_cod = $r['transportadora_cod'];
        $this->vendedor_cod = $r['vendedor_cod'];
        $this->vendedor_fil = $r['vendedor_fil'];
        $this->p_comissao = $r['p_comissao'];
        $this->v_comissao = $r['v_comissao'];
        $this->pvenda_pservico = $r['pvenda_pservico'];

        //v2.0
        $this->ide_hSaiEnt->valor = $r['ide_hSaiEnt'];
        $this->ide_dhCont->valor = $r['ide_dhCont'];
        $this->ide_xJust->valor = stripslashes($r['ide_xJust']);
        $this->emit_CRT->valor = $r['emit_CRT'];
        $this->dest_email->valor = stripslashes($r['dest_email']);
        $this->retirada_CPF->valor = $r['retirada_CPF'];
        $this->entrega_CPF->valor = $r['entrega_CPF'];

        $query = "SELECT * FROM nfe_produtos WHERE Id = '" . $Id . "'";
        $q = mysql_query($query, $this->conMysql);

        while ($r = mysql_fetch_array($q)) {
            $prod = new NFe_prod();
            $this->Id = $r['Id'];
            $prod->nItem = $r['nItem'];
            $prod->cProd->valor = $r['cProd'];
            $prod->cEAN->valor = $r['cEAN'];
            $prod->xProd->valor = stripslashes($r['xProd']);
            $prod->NCM->valor = $r['NCM'];
            $prod->EXTIPI->valor = $r['EXTIPI'];
            $prod->genero->valor = $r['genero'];
            $prod->CFOP->valor = $r['CFOP'];
            $prod->uCom->valor = $r['uCom'];
            $prod->qCom->valor = $r['qCom'];
            $prod->vUnCom->valor = $r['vUnCom'];
            $prod->vProd->valor = $r['vProd'];
            $prod->cEANTrib->valor = $r['cEANTrib'];
            $prod->uTrib->valor = $r['uTrib'];
            $prod->qTrib->valor = $r['qTrib'];
            $prod->vUnTrib->valor = $r['vUnTrib'];
            $prod->vFrete->valor = $r['vFrete'];
            $prod->vSeg->valor = $r['vSeg'];
            $prod->vDesc->valor = $r['vDesc'];
            $prod->orig->valor = $r['orig'];
            $prod->CST->valor = $r['CST'];
            $prod->modBC->valor = $r['modBC'];
            $prod->pRedBC->valor = $r['pRedBC'];
            $prod->vBC->valor = $r['vBC'];
            $prod->pICMS->valor = $r['pICMS'];
            $prod->vICMS->valor = $r['vICMS'];
            $prod->modBCST->valor = $r['modBCST'];

            $prod->pMVAST->valor = $r['pMVAST'];
            $prod->pRedBCST->valor = $r['pRedBCST'];
            $prod->vBCST->valor = $r['vBCST'];
            $prod->pICMSST->valor = $r['pICMSST'];
            $prod->vICMSST->valor = $r['vICMSST'];
            $prod->IPI_clEnq->valor = $r['IPI_clEnq'];
            $prod->IPI_CNPJProd->valor = $r['IPI_CNPJProd'];
            $prod->IPI_cSelo->valor = $r['IPI_cSelo'];
            $prod->IPI_qSelo->valor = $r['IPI_qSelo'];
            $prod->IPI_cEnq->valor = $r['IPI_cEnq'];
            $prod->IPI_CST->valor = $r['IPI_CST'];
            $prod->IPI_vBC->valor = $r['IPI_vBC'];
            $prod->IPI_qUnid->valor = $r['IPI_qUnid'];
            $prod->IPI_vUnid->valor = $r['IPI_vUnid'];
            $prod->IPI_pIPI->valor = $r['IPI_pIPI'];
            $prod->IPI_vIPI->valor = $r['IPI_vIPI'];
            $prod->PIS_CST->valor = $r['PIS_CST'];
            $prod->PIS_vBC->valor = $r['PIS_vBC'];
            $prod->PIS_pPIS->valor = $r['PIS_pPIS'];
            $prod->PIS_vPIS->valor = $r['PIS_vPIS'];
            $prod->PIS_qBCProd->valor = $r['PIS_qBCProd'];
            $prod->PIS_vAliqProd->valor = $r['PIS_vAliqProd'];
            $prod->PISST_vBC->valor = $r['PISST_vBC'];
            $prod->PISST_pPIS->valor = $r['PISST_pPIS'];
            $prod->PISST_qBCProd->valor = $r['PISST_qBCProd'];
            $prod->PISST_vAliqProd->valor = $r['PISST_vAliqProd'];
            $prod->PISST_vPIS->valor = $r['PISST_vPIS'];

            $prod->COFINS_CST->valor = $r['COFINS_CST'];
            $prod->COFINS_vBC->valor = $r['COFINS_vBC'];
            $prod->COFINS_pCOFINS->valor = $r['COFINS_pCOFINS'];
            $prod->COFINS_vCOFINS->valor = $r['COFINS_vCOFINS'];
            $prod->COFINS_qBCProd->valor = $r['COFINS_qBCProd'];
            $prod->COFINS_vAliqProd->valor = $r['COFINS_vAliqProd'];
            $prod->COFINSST_vBC->valor = $r['COFINSST_vBC'];
            $prod->COFINSST_pCOFINS->valor = $r['COFINSST_pCOFINS'];
            $prod->COFINSST_vCOFINS->valor = $r['COFINSST_vCOFINS'];
            $prod->COFINSST_qBCProd->valor = $r['COFINSST_qBCProd'];
            $prod->COFINSST_vAliqProd->valor = $r['COFINSST_vAliqProd'];
            $prod->infAdProd->valor = stripslashes($r['infAdProd']);
            $prod->ISSQN_vBC->valor = $r['ISSQN_vBC'];
            $prod->ISSQN_vAliq->valor = $r['ISSQN_vAliq'];
            $prod->ISSQN_vISSQN->valor = $r['ISSQN_vISSQN'];
            $prod->ISSQN_cMunFG->valor = $r['ISSQN_cMunFG'];
            $prod->ISSQN_cListServ->valor = $r['ISSQN_cListServ'];

            //v2.0
            $prod->vOutro->valor = $r['vOutro'];
            $prod->indTot->valor = $r['indTot'];
            $prod->vBCSTRet->valor = $r['vBCSTRet'];
            $prod->vICMSSTRet->valor = $r['vICMSSTRet'];
            $prod->ISSQN_cSitTrib->valor = $r['ISSQN_cSitTrib'];

            $prod->ICMSSN_orig->valor = $r['ICMSSN_orig'];
            $prod->ICMSSN_CSOSN->valor = $r['ICMSSN_CSOSN'];
            $prod->ICMSSN_pCredSN->valor = $r['ICMSSN_pCredSN'];
            $prod->ICMSSN_vCredICMSSN->valor = $r['ICMSSN_vCredICMSSN'];
            $prod->ICMSSN_modBCST->valor = $r['ICMSSN_modBCST'];
            $prod->ICMSSN_pMVAST->valor = $r['ICMSSN_pMVAST'];
            $prod->ICMSSN_pRedBCST->valor = $r['ICMSSN_pRedBCST'];
            $prod->ICMSSN_vBCST->valor = $r['ICMSSN_vBCST'];
            $prod->ICMSSN_pICMSST->valor = $r['ICMSSN_pICMSST'];
            $prod->ICMSSN_vICMSST->valor = $r['ICMSSN_vICMSST'];
            $prod->ICMSSN_vBCSTRet->valor = $r['ICMSSN_vBCSTRet'];
            $prod->ICMSSN_vICMSSTRet->valor = $r['ICMSSN_vICMSSTRet'];
            $prod->ICMSSN_modBC->valor = $r['ICMSSN_modBC'];
            $prod->ICMSSN_vBC->valor = $r['ICMSSN_vBC'];
            $prod->ICMSSN_pRedBC->valor = $r['ICMSSN_vBC'];
            $prod->ICMSSN_pICMS->valor = $r['ICMSSN_pICMS'];
            $prod->ICMSSN_vICMS->valor = $r['ICMSSN_vICMS'];

            $prod->produto_cod = $r['produto_cod'];

            $query = "SELECT * FROM nfe_di WHERE Id = '" . $Id . "'";
            $d = mysql_query($query, $this->conMysql);
            while ($rd = mysql_fetch_array($d)) {
                $di = new NFe_di();
                $di->nDI->valor = $rd['nDI'];
                $di->dDI->valor = $rd['dDI'];
                $di->xLocDesemb->valor = $rd['xLocDesemb'];
                $di->ufDesemb->valor = $rd['ufDesemb'];
                $di->dDesemb->valor = $rd['dDesemb'];
                $di->cExportador->valor = $rd['cExportador'];

                $query = "SELECT * FROM nfe_di_adi WHERE di_ordem = " . $rd['ordem'] . "";
                $do = mysql_query($query, $this->conMysql);
                while ($ro = mysql_fetch_array($do)) {
                    $adi = new NFe_di_adi();
                    $adi->nAdicao->valor = $ro['nAdicao'];
                    $adi->nSeqAdic->valor = $ro['nSeqAdic'];
                    $adi->cFabricante->valor = $ro['cFabricante'];
                    $adi->vDescDI->valor = $ro['vDescDI'];
                    $adi->xPed->valor = $ro['xPed'];
                    $adi->xItemPed->valor = $ro['xItemPed'];

                    $di->addAdi($adi);
                }
                $prod->addDI($di);
            }
            $this->addProd($prod);
        }

        $query = "SELECT * FROM nfe_duplicatas WHERE Id = '" . $Id . "'";
        $q = mysql_query($query, $this->conMysql);

        while ($r = mysql_fetch_array($q)) {
            $dup = new NFe_dup();

            $this->Id = $r['Id'];
            $dup->cobr_dup_nDup->valor = stripslashes($r['cobr_dup_nDup']);
            $dup->cobr_dup_dVenc->valor = $r['cobr_dup_dVenc'];
            $dup->cobr_dup_vDup->valor = $r['cobr_dup_vDup'];
            $this->addDup($dup);
        }
        return true;
    }

    public function temErro() {
        return count($this->erros) > 0;
    }

    public function imprimir($Id, $salvar = false) {
        $this->getDadosNFe($Id);
        $d = new NFe_danfe($this, $salvar);
        $d->geraDANFE();
    }

    public function cancelarNFe($Id, $xJust = '') {
        $this->getDadosNFe($Id);
        if ($this->tools->cancelaNF($this->Id, $this->nProt, $xJust)) {
            $this->cod_ret = $this->tools->cStat;
            $this->msg_erro = $this->tools->xMotivo;
            if ($this->cod_ret == '101') {
                $this->cod_ret = $this->tools->cStat;
                $this->msg_erro = $this->tools->xMotivo;
                $this->nProt = $this->tools->nProt;
                $this->verAplic = $this->tools->verAplic;
                $this->status = CANCELADA;
            } else {
                $this->erros [] = "NFe não foi cancelada.";
                $this->erros [] = $this->tools->xMotivo;
            }
            $sql = "UPDATE nfe_notas SET status = '" . $this->status . "', cod_ret = " . $this->cod_ret . ", msg_erro = '" . $this->msg_erro . "', nProt = " . $this->nProt . ", xJust = '" . $xJust . "' WHERE Id = '" . $this->Id . "'";
            mysql_query($sql, $this->conMysql);
        } else {
            $this->erros [] = "Ocorreu um erro ao cancelar a NFe.";
        }
    }

    public function inutilizaNF($ano, $nfSerie, $modelo, $numIni, $numFim, $CNPJ, $xJust) {
        if (!$this->tools->inutilizaNF($ano, $nfSerie, $modelo, $numIni, $numFim, $CNPJ, $xJust, $this->path)) {
            $this->erros [] = "Erro na inutilização.";
            $this->erros [] = $this->tools->xMotivo;
        }
    }

    public function salvaNFeAprovada() {
        $xmldoc = new DOMDocument();
        $xmldoc->preservWhiteSpace = FALSE; //elimina espaços em branco
        $xmldoc->formatOutput = FALSE;
        $xmldoc->loadXML($this->XML, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
        $node = $xmldoc->getElementsByTagName('NFe')->item(0);

        $xmlFile = $this->tools->aprovadasNF . $this->Id . '-nfe.xml';

        $f = fopen($xmlFile, 'w+');
        fwrite($f, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
        if ($this->versaoNFe == 1) {
            fwrite($f, "<nfeProc xmlns=\"http://www.portalfiscal.inf.br/nfe\" versao=\"1.10\">");
        } else {
            fwrite($f, "<nfeProc xmlns=\"http://www.portalfiscal.inf.br/nfe\" versao=\"2.00\">");
        }
        fwrite($f, $xmldoc->saveXML($node));
        if ($this->versaoNFe == 1) {
            fwrite($f, "<protNFe versao=\"1.10\">");
        } else {
            fwrite($f, "<protNFe versao=\"2.00\">");
        }
        fwrite($f, "<infProt Id=\"ID" . $this->Id . "\">");
        fwrite($f, "<tpAmb>" . $this->ide_tpAmb->valor . "</tpAmb>");
        fwrite($f, "<verAplic>" . $this->verAplic . "</verAplic>");
        fwrite($f, "<chNFe>" . $this->Id . "</chNFe>");
        fwrite($f, "<dhRecbto>" . $this->dhRecbto . "</dhRecbto>");
        fwrite($f, "<nProt>" . $this->nProt . "</nProt>");
        fwrite($f, "<digVal>" . $this->digVal . "</digVal>");
        fwrite($f, "<cStat>" . $this->cod_ret . "</cStat>");
        fwrite($f, "<xMotivo>" . $this->msg_erro . "</xMotivo>");
        fwrite($f, "</infProt>");
        fwrite($f, "</protNFe>");
        fwrite($f, "</nfeProc>");
        fclose($f);
    }

    public function salvarNFeDoBanco($Id) {
        $this->getDadosNFe($Id);
        $this->salvaNFeAprovada();
    }

}

?>