<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NFe_prod
 *
 * @author Marlos
 */
require_once('NFe_campo.php');
require_once('NFe_di.php');

class NFe_prod {
    private $versaoNFe = null;
    public $nItem = null;
    public $cProd = null;
    public $cEAN = null;
    public $xProd = null;
    public $NCM = null;
    public $EXTIPI = null;
    public $genero = null;
    public $CFOP = null;
    public $uCom = null;
    public $qCom = null;
    public $vUnCom = null;
    public $vProd = null;
    public $cEANTrib = null;
    public $uTrib = null;
    public $qTrib = null;
    public $vUnTrib = null;
    public $vFrete = null;
    public $vSeg = null;
    public $vDesc = null;
    public $vOutro = null; //v2.0
    public $indTot = null; //v2.0
    //ICMS
    public $orig = null;
    public $CST = null;
    public $modBC = null;
    public $pRedBC = null;
    public $vBC = null;
    public $pICMS = null;
    public $vICMS = null;
    //ST
    public $modBCST = null;
    public $pMVAST = null;
    public $pRedBCST = null;
    public $vBCST = null;
    public $pICMSST = null;
    public $vICMSST = null;
    public $vBCSTRet = null; //v2.0
    public $vICMSSTRet = null; //v2.0
    //IPI
    public $IPI_clEnq = null;
    public $IPI_CNPJProd = null;
    public $IPI_cSelo = null;
    public $IPI_qSelo = null;
    public $IPI_cEnq = null;
    public $IPI_CST = null;
    public $IPI_vBC = null;
    public $IPI_qUnid = null;
    public $IPI_vUnid = null;
    public $IPI_pIPI = null;
    public $IPI_vIPI = null;
    //PIS
    public $PIS_CST = null;
    public $PIS_vBC = null;
    public $PIS_pPIS = null;
    public $PIS_vPIS = null;
    public $PIS_qBCProd = null;
    public $PIS_vAliqProd = null;
    //PIS ST
    public $PISST_vBC = null;
    public $PISST_pPIS = null;
    public $PISST_qBCProd = null;
    public $PISST_vAliqProd = null;
    public $PISST_vPIS = null;
    //COFINS
    public $COFINS_CST = null;
    public $COFINS_vBC = null;
    public $COFINS_pCOFINS = null;
    public $COFINS_vCOFINS = null;
    public $COFINS_qBCProd = null;
    public $COFINS_vAliqProd = null;
    //COFINS ST
    public $COFINSST_vBC = null;
    public $COFINSST_pCOFINS = null;
    public $COFINSST_vCOFINS = null;
    public $COFINSST_qBCProd = null;
    public $COFINSST_vAliqProd = null;
    //ISSQN
    public $ISSQN_vBC = null;
    public $ISSQN_vAliq = null;
    public $ISSQN_vISSQN = null;
    public $ISSQN_cMunFG = null;
    public $ISSQN_cListServ = null;
    public $ISSQN_cSitTrib = null; //v2.0
    
    //ICMS SIMPLES v2.0
    public $ICMSSN_orig = null;
    public $ICMSSN_CSOSN = null;
    public $ICMSSN_pCredSN = null;
    public $ICMSSN_vCredICMSSN = null;
    public $ICMSSN_modBCST = null;
    public $ICMSSN_pMVAST = null;
    public $ICMSSN_pRedBCST = null;
    public $ICMSSN_vBCST = null;
    public $ICMSSN_pICMSST = null;
    public $ICMSSN_vICMSST = null;
    public $ICMSSN_vBCSTRet = null;
    public $ICMSSN_vICMSSTRet = null;
    public $ICMSSN_modBC = null;
    public $ICMSSN_vBC = null;
    public $ICMSSN_pRedBC = null;
    public $ICMSSN_pICMS = null;
    public $ICMSSN_vICMS = null;    
    
    public $II_vBC = null;
	public $II_vDespAdu = null;
	public $II_vII = null;
	public $II_vIOF = null;
	
	
    public $infAdProd = null;

    private $DI = array();
    //v2.0

    

    public $XML = null;

    public $produto_cod = null;
    public $prod_serv = null;

    public function  __construct($versao = 1) {
        $this->versaoNFe = $versao;
        $this->init();
    }

    private function init() {
        $this->nItem = 0;
        
        $this->cProd = new NFe_campo();
        $this->cProd->tag = 'cProd';
        $this->cProd->obrigatorio = true;

        $this->cEAN = new NFe_campo();
        $this->cEAN->tag = 'cEAN';

        $this->xProd = new NFe_campo();
        $this->xProd->tag = 'xProd';
        $this->xProd->obrigatorio = true;

        $this->NCM = new NFe_campo();
        $this->NCM->tag = 'NCM';
        //$this->cProd->obrigatorio = true;

        $this->EXTIPI = new NFe_campo();
        $this->EXTIPI->tag = 'EXTIPI';

        $this->genero = new NFe_campo();
        $this->genero->tag = 'genero';
        
        $this->CFOP = new NFe_campo();
        $this->CFOP->tag = 'CFOP';
        $this->CFOP->obrigatorio = true;

        $this->uCom = new NFe_campo();
        $this->uCom->tag = 'uCom';
        $this->uCom->obrigatorio = true;

        $this->qCom = new NFe_campo();
        $this->qCom->tag = 'qCom';
        $this->qCom->obrigatorio = true;
        $this->qCom->tipo = NUMERO;
        $this->qCom->casas_decimais = 4;

        $this->vUnCom = new NFe_campo();
        $this->vUnCom->tag = 'vUnCom';
        $this->vUnCom->obrigatorio = true;
        $this->vUnCom->tipo = NUMERO;
        $this->vUnCom->casas_decimais = 6;

        $this->vProd = new NFe_campo();
        $this->vProd->tag = 'vProd';
        $this->vProd->valor = 0;
        $this->vProd->obrigatorio = true;
        $this->vProd->tipo = NUMERO;
        $this->vProd->casas_decimais = 2;

        $this->cEANTrib = new NFe_campo();
        $this->cEANTrib->tag = 'cEANTrib';

        $this->uTrib = new NFe_campo();
        $this->uTrib->tag = 'uTrib';
        $this->uTrib->obrigatorio = true;

        $this->qTrib = new NFe_campo();
        $this->qTrib->tag = 'qTrib';
        $this->qTrib->obrigatorio = true;
        $this->qTrib->tipo = NUMERO;
        $this->qTrib->casas_decimais = 4;

        $this->vUnTrib = new NFe_campo();
        $this->vUnTrib->tag = 'vUnTrib';
        $this->vUnTrib->tipo = NUMERO;
        $this->vUnTrib->casas_decimais = 6;

        $this->vFrete = new NFe_campo();
        $this->vFrete->tag = 'vFrete';
        $this->vFrete->valor = 0;
        $this->vFrete->tipo = NUMERO;
        $this->vFrete->casas_decimais = 2;

        $this->vSeg = new NFe_campo();
        $this->vSeg->tag = 'vSeg';
        $this->vSeg->valor = 0;
        $this->vSeg->tipo = NUMERO;
        $this->vSeg->casas_decimais = 2;

        $this->vDesc = new NFe_campo();
        $this->vDesc->tag = 'vDesc';
        $this->vDesc->valor = 0;
        $this->vDesc->tipo = NUMERO;
        $this->vDesc->casas_decimais = 2;

        //ICMS
        $this->orig = new NFe_campo();
        $this->orig->tag = 'orig';
        $this->orig->obrigatorio = true;

        $this->CST = new NFe_campo();
        $this->CST->tag = 'CST';
        $this->CST->obrigatorio = true;

        $this->modBC = new NFe_campo();
        $this->modBC->tag = 'modBC';
        $this->modBC->obrigatorio = true;

        $this->pRedBC = new NFe_campo();
        $this->pRedBC->tag = 'pRedBC';
        $this->pRedBC->tipo = NUMERO;
        $this->pRedBC->casas_decimais = 2;

        $this->vBC = new NFe_campo();
        $this->vBC->tag = 'vBC';
        $this->vBC->valor = 0;
        $this->vBC->obrigatorio = true;
        $this->vBC->tipo = NUMERO;
        $this->vBC->casas_decimais = 2;

        $this->pICMS = new NFe_campo();
        $this->pICMS->tag = 'pICMS';
        $this->pICMS->obrigatorio = true;
        $this->pICMS->tipo = NUMERO;
        $this->pICMS->casas_decimais = 2;

        $this->vICMS = new NFe_campo();
        $this->vICMS->tag = 'vICMS';
        $this->vICMS->valor = 0;
        $this->vICMS->obrigatorio = true;
        $this->vICMS->tipo = NUMERO;
        $this->vICMS->casas_decimais = 2;

        //ST
        $this->modBCST = new NFe_campo();
        $this->modBCST->tag = 'modBCST';

        $this->pMVAST = new NFe_campo();
        $this->pMVAST->tag = 'pMVAST';
        $this->pMVAST->tipo = NUMERO;
        $this->pMVAST->casas_decimais = 2;

        $this->pRedBCST = new NFe_campo();
        $this->pRedBCST->tag = 'pRedBCST';
        $this->pRedBCST->tipo = NUMERO;
        $this->pRedBCST->casas_decimais = 2;

        $this->vBCST = new NFe_campo();
        $this->vBCST->tag = 'vBCST';
        $this->vBCST->valor = 0;
        $this->vBCST->tipo = NUMERO;
        $this->vBCST->casas_decimais = 2;

        $this->pICMSST = new NFe_campo();
        $this->pICMSST->tag = 'pICMSST';
        $this->pICMSST->tipo = NUMERO;
        $this->pICMSST->casas_decimais = 2;

        $this->vICMSST = new NFe_campo();
        $this->vICMSST->tag = 'vICMSST';
        $this->vICMSST->valor = 0;
        $this->vICMSST->tipo = NUMERO;
        $this->vICMSST->casas_decimais = 2;
        //IPI
        $this->IPI_clEnq = new NFe_campo();
        $this->IPI_clEnq->tag = 'clEnq';

        $this->IPI_CNPJProd = new NFe_campo();
        $this->IPI_CNPJProd->tag = 'CNPJProd';

        $this->IPI_cSelo = new NFe_campo();
        $this->IPI_cSelo->tag = 'cSelo';

        $this->IPI_qSelo = new NFe_campo();
        $this->IPI_qSelo->tag = 'qSelo';

        $this->IPI_cEnq = new NFe_campo();
        $this->IPI_cEnq->tag = 'cEnq';

        $this->IPI_CST = new NFe_campo();
        $this->IPI_CST->tag = 'CST';

        $this->IPI_vBC = new NFe_campo();
        $this->IPI_vBC->tag = 'vBC';
        $this->IPI_vBC->tipo = NUMERO;
        $this->IPI_vBC->casas_decimais = 2;

        $this->IPI_qUnid = new NFe_campo();
        $this->IPI_qUnid->tag = 'qUnid';
        $this->IPI_qUnid->tipo = NUMERO;
        $this->IPI_qUnid->casas_decimais = 4;

        $this->IPI_vUnid = new NFe_campo();
        $this->IPI_vUnid->tag = 'vUnid';
        $this->IPI_vUnid->tipo = NUMERO;
        $this->IPI_vUnid->casas_decimais = 4;

        $this->IPI_pIPI = new NFe_campo();
        $this->IPI_pIPI->tag = 'pIPI';
        $this->IPI_pIPI->tipo = NUMERO;
        $this->IPI_pIPI->casas_decimais = 2;

        $this->IPI_vIPI = new NFe_campo();
        $this->IPI_vIPI->tag = 'vIPI';
        $this->IPI_vIPI->tipo = NUMERO;
        $this->IPI_vIPI->casas_decimais = 2;

        //PIS
        $this->PIS_CST = new NFe_campo();
        $this->PIS_CST->tag = 'CST';
        $this->PIS_CST->obrigatorio = true;

        $this->PIS_vBC = new NFe_campo();
        $this->PIS_vBC->tag = 'vBC';
        $this->PIS_vBC->tipo = NUMERO;
        $this->PIS_vBC->casas_decimais = 2;

        $this->PIS_pPIS = new NFe_campo();
        $this->PIS_pPIS->tag = 'pPIS';
        $this->PIS_pPIS->tipo = NUMERO;
        $this->PIS_pPIS->casas_decimais = 2;

        $this->PIS_vPIS = new NFe_campo();
        $this->PIS_vPIS->tag = 'vPIS';
        $this->PIS_vPIS->valor = 0;
        $this->PIS_vPIS->tipo = NUMERO;
        $this->PIS_vPIS->casas_decimais = 2;

        $this->PIS_qBCProd = new NFe_campo();
        $this->PIS_qBCProd->tag = 'qBCProd';
        $this->PIS_qBCProd->tipo = NUMERO;
        $this->PIS_qBCProd->casas_decimais = 4;

        $this->PIS_vAliqProd = new NFe_campo();
        $this->PIS_vAliqProd->tag = 'vAliqProd';
        $this->PIS_vAliqProd->tipo = NUMERO;
        $this->PIS_vAliqProd->casas_decimais = 4;

        //PIS ST
        $this->PISST_vBC = new NFe_campo();
        $this->PISST_vBC->tag = 'vBC';
        $this->PISST_vBC->tipo = NUMERO;
        $this->PISST_vBC->casas_decimais = 2;

        $this->PISST_pPIS = new NFe_campo();
        $this->PISST_pPIS->tag = 'pPIS';
        $this->PISST_pPIS->tipo = NUMERO;
        $this->PISST_pPIS->casas_decimais = 2;

        $this->PISST_qBCProd = new NFe_campo();
        $this->PISST_qBCProd->tag = 'qBCProd';
        $this->PISST_qBCProd->tipo = NUMERO;
        $this->PISST_qBCProd->casas_decimais = 4;

        $this->PISST_vAliqProd = new NFe_campo();
        $this->PISST_vAliqProd->tag = 'vAliqProd';
        $this->PISST_vAliqProd->tipo = NUMERO;
        $this->PISST_vAliqProd->casas_decimais = 4;

        $this->PISST_vPIS = new NFe_campo();
        $this->PISST_vPIS->tag = 'vPIS';
        $this->PISST_vPIS->tipo = NUMERO;
        $this->PISST_vPIS->casas_decimais = 2;

        //COFINS
        $this->COFINS_CST = new NFe_campo();
        $this->COFINS_CST->tag = 'CST';
        $this->COFINS_CST->obrigatorio = true;

        $this->COFINS_vBC = new NFe_campo();
        $this->COFINS_vBC->tag = 'vBC';
        $this->COFINS_vBC->tipo = NUMERO;
        $this->COFINS_vBC->casas_decimais = 2;

        $this->COFINS_pCOFINS = new NFe_campo();
        $this->COFINS_pCOFINS->tag = 'pCOFINS';
        $this->COFINS_pCOFINS->tipo = NUMERO;
        $this->COFINS_pCOFINS->casas_decimais = 2;

        $this->COFINS_vCOFINS = new NFe_campo();
        $this->COFINS_vCOFINS->tag = 'vCOFINS';
        $this->COFINS_vCOFINS->valor = 0;
        $this->COFINS_vCOFINS->tipo = NUMERO;
        $this->COFINS_vCOFINS->casas_decimais = 2;

        $this->COFINS_qBCProd = new NFe_campo();
        $this->COFINS_qBCProd->tag = 'qBCProd';
        $this->COFINS_qBCProd->tipo = NUMERO;
        $this->COFINS_qBCProd->casas_decimais = 4;

        $this->COFINS_vAliqProd = new NFe_campo();
        $this->COFINS_vAliqProd->tag = 'vAliqProd';
        $this->COFINS_vAliqProd->tipo = NUMERO;
        $this->COFINS_vAliqProd->casas_decimais = 4;

        //COFINS ST
        $this->COFINSST_vBC = new NFe_campo();
        $this->COFINSST_vBC->tag = 'vBC';
        $this->COFINSST_vBC->tipo = NUMERO;
        $this->COFINSST_vBC->casas_decimais = 2;

        $this->COFINSST_pCOFINS = new NFe_campo();
        $this->COFINSST_pCOFINS->tag = 'pCOFINS';
        $this->COFINSST_pCOFINS->tipo = NUMERO;
        $this->COFINSST_pCOFINS->casas_decimais = 2;
        
        $this->COFINSST_vCOFINS = new NFe_campo();
        $this->COFINSST_vCOFINS->tag = 'vCOFINS';
        $this->COFINSST_vCOFINS->tipo = NUMERO;
        $this->COFINSST_vCOFINS->casas_decimais = 2;

        $this->COFINSST_qBCProd = new NFe_campo();
        $this->COFINSST_qBCProd->tag = 'qBCProd';
        $this->COFINSST_qBCProd->tipo = NUMERO;
        $this->COFINSST_qBCProd->casas_decimais = 4;

        $this->COFINSST_vAliqProd = new NFe_campo();
        $this->COFINSST_vAliqProd->tag = 'vAliqProd';
        $this->COFINSST_vAliqProd->tipo = NUMERO;
        $this->COFINSST_vAliqProd->casas_decimais = 4;

        $this->ISSQN_vBC = new NFe_campo();
        $this->ISSQN_vBC->tag = 'vBC';
        $this->ISSQN_vBC->tipo = NUMERO;
        $this->ISSQN_vBC->casas_decimais = 2;
        
        $this->ISSQN_vAliq = new NFe_campo();
        $this->ISSQN_vAliq->tag = 'vAliq';
        $this->ISSQN_vAliq->tipo = NUMERO;
        $this->ISSQN_vAliq->casas_decimais = 2;

        $this->ISSQN_vISSQN = new NFe_campo();
        $this->ISSQN_vISSQN->tag = 'vISSQN';
        $this->ISSQN_vISSQN->tipo = NUMERO;
        $this->ISSQN_vISSQN->casas_decimais = 2;

        $this->ISSQN_cMunFG = new NFe_campo();
        $this->ISSQN_cMunFG->tag = 'cMunFG';

        $this->ISSQN_cListServ = new NFe_campo();
        $this->ISSQN_cListServ->tag = 'cListServ';

        $this->infAdProd = new NFe_campo();
        $this->infAdProd->tag = 'infAdProd';

        //v2.0
        $this->vOutro = new NFe_campo();
        $this->vOutro->tag = 'vOutro';
        $this->ISSQN_vISSQN->tipo = NUMERO;
        $this->ISSQN_vISSQN->casas_decimais = 2;

        $this->indTot = new NFe_campo();
        $this->indTot->tag = 'indTot';
        $this->indTot->gerarXMLSeVazio = true;
        
        $this->vBCSTRet = new NFe_campo();
        $this->vBCSTRet->tag = 'vBCSTRet';
        $this->vBCSTRet->tipo = NUMERO;
        $this->vBCSTRet->casas_decimais = 2;

        $this->vICMSSTRet = new NFe_campo();
        $this->vICMSSTRet->tag = 'vICMSSTRet';
        $this->vICMSSTRet->tipo = NUMERO;
        $this->vICMSSTRet->casas_decimais = 2;

        $this->ISSQN_cSitTrib = new NFe_campo();
        $this->ISSQN_cSitTrib->tag = 'cSitTrib';

        $this->ICMSSN_orig = new NFe_campo();
        $this->ICMSSN_orig->tag = 'orig';
        $this->ICMSSN_orig->gerarXMLSeVazio = true;
        
        $this->ICMSSN_CSOSN = new NFe_campo();        
        $this->ICMSSN_CSOSN->tag = 'CSOSN';
        
        $this->ICMSSN_pCredSN = new NFe_campo();
        $this->ICMSSN_pCredSN->tag = 'pCredSN';
        $this->ICMSSN_pCredSN->casas_decimais = 2;
        
        $this->ICMSSN_vCredICMSSN = new NFe_campo();
        $this->ICMSSN_vCredICMSSN->tag = 'vCredICMSSN';
        $this->ICMSSN_vCredICMSSN->casas_decimais = 2;
        
        $this->ICMSSN_modBCST = new NFe_campo();
        $this->ICMSSN_modBCST->tag = 'modBCST';
                
        $this->ICMSSN_pMVAST = new NFe_campo();
        $this->ICMSSN_pMVAST->tag = 'pMVAST';
        $this->ICMSSN_pMVAST->casas_decimais = 2;
                
        $this->ICMSSN_pRedBCST = new NFe_campo();
        $this->ICMSSN_pRedBCST->tag = 'pRedBCST';
        $this->ICMSSN_pRedBCST->casas_decimais = 2;
                
        $this->ICMSSN_vBCST = new NFe_campo();
        $this->ICMSSN_vBCST->tag = 'vBCST';
        $this->ICMSSN_vBCST->casas_decimais = 2;
        
        $this->ICMSSN_pICMSST = new NFe_campo();
        $this->ICMSSN_pICMSST->tag = 'pICMSST';
        $this->ICMSSN_pICMSST->casas_decimais = 2;
        
        $this->ICMSSN_vICMSST = new NFe_campo();
        $this->ICMSSN_vICMSST->tag = 'vICMSST';
        $this->ICMSSN_vICMSST->casas_decimais = 2;
                
        $this->ICMSSN_vBCSTRet = new NFe_campo();
        $this->ICMSSN_vBCSTRet->tag = 'vBCSTRet';
        $this->ICMSSN_vBCSTRet->casas_decimais = 2;
        
        $this->ICMSSN_vICMSSTRet = new NFe_campo();
        $this->ICMSSN_vICMSSTRet->tag = 'vICMSSTRet';
        $this->ICMSSN_vICMSSTRet->casas_decimais = 2;
        
        $this->ICMSSN_modBC = new NFe_campo();
        $this->ICMSSN_modBC->tag = 'modBC';
        
        $this->ICMSSN_vBC = new NFe_campo();
        $this->ICMSSN_vBC->tag = 'vBC';
        $this->ICMSSN_vBC->casas_decimais = 2;
        
        $this->ICMSSN_pRedBC = new NFe_campo();
        $this->ICMSSN_pRedBC->tag = 'pRedBC';
        $this->ICMSSN_pRedBC->casas_decimais = 2;
        
        $this->ICMSSN_pICMS = new NFe_campo();
        $this->ICMSSN_pICMS->tag = 'pICMS';
        $this->ICMSSN_pICMS->casas_decimais = 2;
        
        $this->ICMSSN_vICMS = new NFe_campo();        
        $this->ICMSSN_vICMS->tag = 'vICMS';
        $this->ICMSSN_vICMS->casas_decimais = 2;
        
		// II
		$this->II_vBC = new NFe_campo();
		$this->II_vBC->tag = 'vBC';
        $this->II_vBC->casas_decimais = 2;
		
		$this->II_vDespAdu = new NFe_campo();
		$this->II_vDespAdu->tag = 'vDespAdu';
        $this->II_vDespAdu->casas_decimais = 2;
		
		$this->II_vII = new NFe_campo();
		$this->II_vII->tag = 'vII';
        $this->II_vII->casas_decimais = 2;
		
		$this->II_vIOF = new NFe_campo();
		$this->II_vIOF->tag = 'vIOF';
        $this->II_vIOF->casas_decimais = 2;
		// II
		
        $this->XML = null;

        $this->produto_cod = 0;
        $this->prod_serv = '';
        
        $this->DI = array();
    }

    public function getXML() {
        $this->XML = '';

        $this->XML .= sprintf('<det nItem="%s">', $this->nItem);

        $this->XML .= '<prod>';

        $this->XML .= $this->cProd->getXML();
        if (empty($this->cEAN->valor)) {
            $this->XML .= '<cEAN></cEAN>';
        }
        else {
            $this->XML .= $this->cEAN->getXML();
        }
        $this->XML .= $this->xProd->getXML();
        $this->XML .= $this->NCM->getXML();
        $this->XML .= $this->EXTIPI->getXML();
        $this->XML .= $this->genero->getXML();
        $this->XML .= $this->CFOP->getXML();
        $this->XML .= $this->uCom->getXML();
        $this->XML .= $this->qCom->getXML();
        $this->XML .= $this->vUnCom->getXML();
        $this->XML .= $this->vProd->getXML();
        if (empty($this->cEANTrib->valor)) {
            $this->XML .= '<cEANTrib></cEANTrib>';
        }
        else {
            $this->XML .= $this->cEANTrib->getXML();
        }
        $this->XML .= $this->uTrib->getXML();
        $this->XML .= $this->qTrib->getXML();
        $this->XML .= $this->vUnTrib->getXML();
        $this->XML .= $this->vFrete->getXML();
        $this->XML .= $this->vSeg->getXML();
        $this->XML .= $this->vDesc->getXML();

        if ($this->versaoNFe == 2) {
            $this->XML .= $this->vOutro->getXML();
            $this->XML .= $this->indTot->getXML();
        }
        
        for ($i=0;$i<count($this->DI);$i++) {
            $di = $this->DI[$i];
            $this->XML .= $di->getXML();
        }
        
        $this->XML .= '</prod>';


        $this->XML .= '<imposto>';

        $ICMS = '<ICMS>';
        if ($this->CST->valor) {
            switch ($this->CST->valor) {
                case '00':
                    $ICMS .= '<ICMS00>';
                    $ICMS .= $this->orig->getXML();
                    $ICMS .= $this->CST->getXML();
                    $ICMS .= $this->modBC->getXML();
                    $ICMS .= $this->vBC->getXML();
                    $ICMS .= $this->pICMS->getXML();
                    $ICMS .= $this->vICMS->getXML();
                    $ICMS .= '</ICMS00>';
                    break;

                case '10':
                    $ICMS .= '<ICMS10>';
                    $ICMS .= $this->orig->getXML();
                    $ICMS .= $this->CST->getXML();
                    $ICMS .= $this->modBC->getXML();
                    $ICMS .= $this->vBC->getXML();
                    $ICMS .= $this->pICMS->getXML();
                    $ICMS .= $this->vICMS->getXML();
                    $ICMS .= $this->modBCST->getXML();
                    $ICMS .= $this->pMVAST->getXML();
                    $ICMS .= $this->pRedBCST->getXML();
                    $ICMS .= $this->vBCST->getXML();
                    $ICMS .= $this->pICMSST->getXML();
                    $ICMS .= $this->vICMSST->getXML();
                    $ICMS .= '</ICMS10>';
                    break;

                case '20':
                    $ICMS .= '<ICMS20>';
                    $ICMS .= $this->orig->getXML();
                    $ICMS .= $this->CST->getXML();
                    $ICMS .= $this->modBC->getXML();
                    $ICMS .= $this->pRedBC->getXML();
                    $ICMS .= $this->vBC->getXML();
                    $ICMS .= $this->pICMS->getXML();
                    $ICMS .= $this->vICMS->getXML();
                    $ICMS .= '</ICMS20>';
                    break;

                case '30':
                    $ICMS .= '<ICMS30>';
                    $ICMS .= $this->orig->getXML();
                    $ICMS .= $this->CST->getXML();
                    $ICMS .= $this->modBC->getXML();
                    $ICMS .= $this->modBCST->getXML();
                    $ICMS .= $this->pMVAST->getXML();
                    $ICMS .= $this->pRedBCST->getXML();
                    $ICMS .= $this->vBCST->getXML();
                    $ICMS .= $this->pICMSST->getXML();
                    $ICMS .= $this->vICMSST->getXML();
                    $ICMS .= '</ICMS30>';
                    break;

                case '40':
                case '41':
                case '50':
                    $ICMS .= '<ICMS40>';
                    $ICMS .= $this->orig->getXML();
                    $ICMS .= $this->CST->getXML();
                    $ICMS .= '</ICMS40>';
                    break;

                case '51':
                    $ICMS .= '<ICMS51>';
                    $ICMS .= $this->orig->getXML();
                    $ICMS .= $this->CST->getXML();
                    $ICMS .= $this->modBC->getXML();
                    $ICMS .= $this->pRedBC->getXML();
                    $ICMS .= $this->vBC->getXML();
                    $ICMS .= $this->pICMS->getXML();
                    $ICMS .= $this->vICMS->getXML();
                    $ICMS .= '</ICMS51>';
                    break;

                case '60':
                    $ICMS .= '<ICMS60>';
                    $ICMS .= $this->orig->getXML();
                    $ICMS .= $this->CST->getXML();
                    if ($this->versaoNFe == 1) {
                        $ICMS .= $this->vBCST->getXML();
                        $ICMS .= $this->vICMSST->getXML();
                    }
                    else {
                        $ICMS .= $this->vBCSTRet->getXML();
                        $ICMS .= $this->vICMSSTRet->getXML();
                    }
                    $ICMS .= '</ICMS60>';
                    break;

                case '70':
                    $ICMS .= '<ICMS70>';
                    $ICMS .= $this->orig->getXML();
                    $ICMS .= $this->CST->getXML();
                    $ICMS .= $this->modBC->getXML();
                    $ICMS .= $this->pRedBC->getXML();
                    $ICMS .= $this->vBC->getXML();
                    $ICMS .= $this->pICMS->getXML();
                    $ICMS .= $this->vICMS->getXML();
                    $ICMS .= $this->modBCST->getXML();
                    $ICMS .= $this->pMVAST->getXML();
                    $ICMS .= $this->pRedBCST->getXML();
                    $ICMS .= $this->vBCST->getXML();
                    $ICMS .= $this->pICMSST->getXML();
                    $ICMS .= $this->vICMSST->getXML();
                    $ICMS .= '</ICMS70>';
                    break;

                case '90':
                    $ICMS .= '<ICMS90>';
                    $ICMS .= $this->orig->getXML();
                    $ICMS .= $this->CST->getXML();
                    $ICMS .= $this->modBC->getXML();
                    $ICMS .= $this->vBC->getXML();
                    $ICMS .= $this->pRedBC->getXML();
                    $ICMS .= $this->pICMS->getXML();
                    $ICMS .= $this->vICMS->getXML();
                    $ICMS .= $this->modBCST->getXML();
                    $ICMS .= $this->pMVAST->getXML();
                    $ICMS .= $this->pRedBCST->getXML();
                    $ICMS .= $this->vBCST->getXML();
                    $ICMS .= $this->pICMSST->getXML();
                    $ICMS .= $this->vICMSST->getXML();
                    $ICMS .= '</ICMS90>';
                    break;
            }
        }
        else { //CST SIMPLES
            switch ($this->ICMSSN_CSOSN->valor) {
                case '101':
                    $ICMS .= '<ICMSSN101>';
                    $ICMS .= $this->ICMSSN_orig->getXML();
                    $ICMS .= $this->ICMSSN_CSOSN->getXML();
                    $ICMS .= $this->ICMSSN_pCredSN->getXML();
                    $ICMS .= $this->ICMSSN_vCredICMSSN->getXML();
                    $ICMS .= '</ICMSSN101>';
                    break;
                
                case '102':
                case '103':
                case '300':
                case '400':
                    $ICMS .= '<ICMSSN102>';
                    $ICMS .= $this->ICMSSN_orig->getXML();
                    $ICMS .= $this->ICMSSN_CSOSN->getXML();
                    $ICMS .= '</ICMSSN102>';
                    break;
                
                case '201':
                    $ICMS .= '<ICMSSN201>';
                    $ICMS .= $this->ICMSSN_orig->getXML();
                    $ICMS .= $this->ICMSSN_CSOSN->getXML();
                    $ICMS .= $this->ICMSSN_modBCST->getXML();
                    $ICMS .= $this->ICMSSN_pMVAST->getXML();
                    $ICMS .= $this->ICMSSN_pRedBCST->getXML();
                    $ICMS .= $this->ICMSSN_vBCST->getXML();
                    $ICMS .= $this->ICMSSN_pICMSST->getXML();
                    $ICMS .= $this->ICMSSN_vICMSST->getXML();
                    $ICMS .= $this->ICMSSN_pCredSN->getXML();
                    $ICMS .= $this->ICMSSN_vCredICMSSN->getXML();
                    $ICMS .= '</ICMSSN201>';
                    break;

                case '202':
                case '203':
                    $ICMS .= '<ICMSSN202>';
                    $ICMS .= $this->ICMSSN_orig->getXML();
                    $ICMS .= $this->ICMSSN_CSOSN->getXML();
                    $ICMS .= $this->ICMSSN_modBCST->getXML();
                    $ICMS .= $this->ICMSSN_pMVAST->getXML();
                    $ICMS .= $this->ICMSSN_pRedBCST->getXML();
                    $ICMS .= $this->ICMSSN_vBCST->getXML();
                    $ICMS .= $this->ICMSSN_pICMSST->getXML();
                    $ICMS .= $this->ICMSSN_vICMSST->getXML();
                    $ICMS .= '</ICMSSN202>';
                    break;                
                
                case '500':
                    $ICMS .= '<ICMSSN500>';
                    $ICMS .= $this->ICMSSN_orig->getXML();
                    $ICMS .= $this->ICMSSN_CSOSN->getXML();
                    $ICMS .= $this->ICMSSN_vBCSTRet->getXML();
                    $ICMS .= $this->ICMSSN_vICMSSTRet->getXML();
                    $ICMS .= '</ICMSSN500>';
                    break;                
                
                case '900':
                    $ICMS .= '<ICMSSN900>';
                    $ICMS .= $this->ICMSSN_orig->getXML();
                    $ICMS .= $this->ICMSSN_CSOSN->getXML();
                    $ICMS .= $this->ICMSSN_modBC->getXML();
                    $ICMS .= $this->ICMSSN_vBC->getXML();
                    $ICMS .= $this->ICMSSN_pRedBC->getXML();
                    $ICMS .= $this->ICMSSN_pICMS->getXML();
                    $ICMS .= $this->ICMSSN_vICMS->getXML();
                    $ICMS .= $this->ICMSSN_modBCST->getXML();
                    $ICMS .= $this->ICMSSN_pMVAST->getXML();
                    $ICMS .= $this->ICMSSN_pRedBCST->getXML();
                    $ICMS .= $this->ICMSSN_vBCST->getXML();
                    $ICMS .= $this->ICMSSN_pICMSST->getXML();
                    $ICMS .= $this->ICMSSN_vICMSST->getXML();
                    $ICMS .= $this->ICMSSN_pCredSN->getXML();
                    $ICMS .= $this->ICMSSN_vCredICMSSN->getXML();
                    $ICMS .= '</ICMSSN900>';
                    break;                
            }
        }
        $ICMS .= '</ICMS>';

        if ($ICMS != '<ICMS></ICMS>') {
            $this->XML .= $ICMS;
        }

        $IPI  = '<IPI>';        
        $IPI .= $this->IPI_clEnq->getXML();
        $IPI .= $this->IPI_CNPJProd->getXML();
        $IPI .= $this->IPI_cSelo->getXML();
        $IPI .= $this->IPI_qSelo->getXML();
        $IPI .= $this->IPI_cEnq->getXML();
        switch ($this->IPI_CST->valor) {
            case "00":
            case "49":
            case "50":
            case "99":
                $IPI  .= '<IPITrib>';
                $IPI .= $this->IPI_CST->getXML();
                $IPI .= $this->IPI_vBC->getXML();
                $IPI .= $this->IPI_qUnid->getXML();
                $IPI .= $this->IPI_vUnid->getXML();
                $IPI .= $this->IPI_pIPI->getXML();
                $IPI .= $this->IPI_vIPI->getXML();
                $IPI  .= '</IPITrib>';
                break;
            case "01":
            case "02":
            case "03":
            case "04":
            case "51":
            case "52":
            case "53":
            case "54":
            case "55":
                $IPI  .= '<IPINT>';
                $IPI .= $this->IPI_CST->getXML();
                $IPI  .= '</IPINT>';
                break;
        }
        $IPI .= '</IPI>';
        if ($IPI != '<IPI></IPI>') {
            $this->XML .= $IPI;
        }
		
		$II = '<II>';
		$II .=  $this->II_vBC->getXML();
		$II .=  $this->II_vDespAdu->getXML();
		$II .=  $this->II_vII->getXML();
		$II .=  $this->II_vIOF->getXML();
		$II .= '</II>';
		
		if ($II != '<II></II>') {
            $this->XML .= $II;
        }

        $ISSQN = '<ISSQN>';
        $ISSQN .= $this->ISSQN_vBC->getXML();
        $ISSQN .= $this->ISSQN_vAliq->getXML();
        $ISSQN .= $this->ISSQN_vISSQN->getXML();
        $ISSQN .= $this->ISSQN_cMunFG->getXML();
        $ISSQN .= $this->ISSQN_cListServ->getXML();
        if ($this->versaoNFe == 2) {
            $ISSQN .= $this->ISSQN_cSitTrib->getXML();
        }
        $ISSQN .= '</ISSQN>';

        if (($this->versaoNFe == 2) AND ($ISSQN != '<ISSQN></ISSQN>')) {
            $this->XML .= $ISSQN;
        }

        $this->XML .= '<PIS>';
        switch ($this->PIS_CST->valor) {
            case "01":
            case "02":
                $this->XML .= '<PISAliq>';
                $this->XML .= $this->PIS_CST->getXML();
                $this->XML .= $this->PIS_vBC->getXML();
                $this->XML .= $this->PIS_pPIS->getXML();
                $this->XML .= $this->PIS_vPIS->getXML();
                $this->XML .= '</PISAliq>';
                break;
            case "03":
                $this->XML .= '<PISQtde>';
                $this->XML .= $this->PIS_CST->getXML();
                $this->XML .= $this->PIS_qBCProd->getXML();
                $this->XML .= $this->PIS_vAliqProd->getXML();
                $this->XML .= $this->PIS_vPIS->getXML();
                $this->XML .= '</PISQtde>';
                break;
            case "04":
            case "06":
            case "07":
            case "08":
            case "09":
                $this->XML .= '<PISNT>';
                $this->XML .= $this->PIS_CST->getXML();
                $this->XML .= '</PISNT>';
                break;
            case "99":
                $this->XML .= '<PISOutr>';
                $this->XML .= $this->PIS_CST->getXML();
                $this->XML .= $this->PIS_vBC->getXML();
                $this->XML .= $this->PIS_pPIS->getXML();
                $this->XML .= $this->PIS_qBCProd->getXML();
                $this->XML .= $this->PIS_vAliqProd->getXML();
                $this->XML .= $this->PIS_vPIS->getXML();
                $this->XML .= '</PISOutr>';
                break;
        }
        $this->XML .= '</PIS>';

        $PISST = '<PISST>';
        $PISST .= $this->PISST_vBC->getXML();
        $PISST .= $this->PISST_pPIS->getXML();
        $PISST .= $this->PISST_qBCProd->getXML();
        $PISST .= $this->PISST_vAliqProd->getXML();
        $PISST .= $this->PISST_vPIS->getXML();
        $PISST .= '</PISST>';
        if ($PISST != '<PISST></PISST>') {
            $this->XML .= $PISST;
        }

        $this->XML .= '<COFINS>';
        switch ($this->COFINS_CST->valor) {
            case "01":
            case "02":
                $this->XML .= '<COFINSAliq>';
                $this->XML .= $this->COFINS_CST->getXML();
                $this->XML .= $this->COFINS_vBC->getXML();
                $this->XML .= $this->COFINS_pCOFINS->getXML();
                $this->XML .= $this->COFINS_vCOFINS->getXML();
                $this->XML .= '</COFINSAliq>';
                break;

            case "03":
                $this->XML .= '<COFINSQtde>';
                $this->XML .= $this->COFINS_CST->getXML();
                $this->XML .= $this->COFINS_qBCProd->getXML();
                $this->XML .= $this->COFINS_vAliqProd->getXML();
                $this->XML .= $this->COFINS_vCOFINS->getXML();
                $this->XML .= '</COFINSQtde>';
                break;

            case "04":
            case "06":
            case "07":
            case "08":
            case "09":
                $this->XML .= '<COFINSNT>';
                $this->XML .= $this->COFINS_CST->getXML();
                $this->XML .= '</COFINSNT>';
                break;

            case "99":
                $this->XML .= '<COFINSOutr>';
                $this->XML .= $this->COFINS_CST->getXML();
                $this->XML .= $this->COFINS_vBC->getXML();
                $this->XML .= $this->COFINS_pCOFINS->getXML();
                $this->XML .= $this->COFINS_qBCProd->getXML();
                $this->XML .= $this->COFINS_vAliqProd->getXML();
                $this->XML .= $this->COFINS_vCOFINS->getXML();
                $this->XML .= '</COFINSOutr>';
                break;

        }
        $this->XML .= '</COFINS>';

        $COFINSST = '<COFINSST>';
        $COFINSST .= $this->COFINSST_vBC->getXML();
        $COFINSST .= $this->COFINSST_pCOFINS->getXML();
        $COFINSST .= $this->COFINSST_qBCProd->getXML();
        $COFINSST .= $this->COFINSST_vAliqProd->getXML();
        $COFINSST .= $this->COFINSST_vCOFINS->getXML();
        $COFINSST .= '</COFINSST>';
        if ($COFINSST != '<COFINSST></COFINSST>') {
            $this->XML .= $COFINSST;
        }
      
        if (($this->versaoNFe == 1) AND ($ISSQN != '<ISSQN></ISSQN>')) {
            $this->XML .= $ISSQN;
        }
		
        $this->XML .= '</imposto>';

        $this->XML .= $this->infAdProd->getXML();

        $this->XML .= '</det>';

        return $this->XML;
    }
    
    public function addDI($a) {
        $this->DI [] = $a;
    }

    public function countDI() {
        return count($this->DI);
    }

    public function getDI($i) {
        return $this->DI[$i];
    }
}
?>