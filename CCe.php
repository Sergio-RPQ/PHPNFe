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
require_once('NFe_tools.php');

define('GERADA', 'G');
define('VALIDADA', 'V');
define('ENVIADA', 'E');
define('APROVADA', 'A');
define('CANCELADA', 'C');
define('NAO_APROVADA', 'N');
define('RECUSADA', 'R');
define('CONTIGENCIA', 'G');

class CCe {
    private $versaoCCe = null;
    private $versao = null;
    public $Id = null;

    public $cOrgao = null;
    public $tpAmb = null;
    public $CNPJ = null;
    public $CPF = null;
    public $chNFe = null;
    public $dhEvento = null;
    public $tpEvento = null;
    public $nSeqEvento = null;
    public $verEvento = null;
    public $descEvento = null;
    public $xCorrecao = null;
    public $xCondUso = null;

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
    public $passKey =  null;

    public $MySQLHost = null;
    public $MySQLUser = null;
    public $MySQLPass = null;
    public $MySQLBD = null;
    private $conMysql = null;
    public $erros = null;

    public $ambiente = null;
    public $UFcod = null;

    public $logo = null;

    public $pathCerts = null;

    public function  __construct($versao = 1) {
        $this->versaoCCe = $versao;
        $this->init();
    }

    private function init() {

        $this->versao = "1.00";
        $this->Id = "";

        $this->cOrgao = new NFe_campo();
        $this->cOrgao->tag = 'cOrgao';
        
        $this->tpAmb = new NFe_campo();
        $this->tpAmb->tag = 'tpAmb';
        
        $this->CNPJ = new NFe_campo();
        $this->CNPJ->tag = 'CNPJ';
        
        $this->CPF = new NFe_campo();
        $this->CPF->tag = 'CPF';
        
        $this->chNFe = new NFe_campo();
        $this->chNFe->tag = 'chNFe';
        
        $this->dhEvento = new NFe_campo();
        $this->dhEvento->tag = 'dhEvento';
        
        $this->tpEvento = new NFe_campo();
        $this->tpEvento->tag = 'tpEvento';
        
        $this->nSeqEvento = new NFe_campo();
        $this->nSeqEvento->tag = 'nSeqEvento';
        
        $this->verEvento = new NFe_campo();
        $this->verEvento->tag = 'verEvento';
                      
        $this->descEvento = new NFe_campo();
        $this->descEvento->tag = 'descEvento';
        
        $this->xCorrecao = new NFe_campo();
        $this->xCorrecao->tag = 'xCorrecao';
        
        $this->xCondUso = new NFe_campo();
        $this->xCondUso->tag = 'xCondUso';
        
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

        $this->erros = array();

        $this->ambiente = 2;
        $this->UFcod = '43';
       
        $this->tools = new NFe_tools(2);
    }

    public function inicializa() {
        $this->conMysql = mysql_connect($this->MySQLHost, $this->MySQLUser, $this->MySQLPass);
        if (!$this->conMysql) {
            $this->erros [] = "Não foi possível conectar ao servidor de banco de dados.";
        }

        if (!mysql_select_db($this->MySQLBD, $this->conMysql)) {
            $this->erros [] = "Banco de dados não encontrado.";
        }
        
        $this->tools->UFcod         =   $this->UFcod;
        $this->tools->ambiente      =   $this->ambiente;
        if ($this->pathCerts == null) {
            $this->tools->pathCerts     = $this->path . '/certs/';
        }
        else {
            $this->tools->pathCerts     = $this->pathCerts;
        }
        $this->tools->nameCert      =   $this->nameCert;
        $this->tools->passKey       =   $this->passKey;
        $this->tools->passPhrase    =   $this->passKey;

        $this->tools->entradasNF     =   $this->path . '/cces/entradas/';
        $this->tools->assinadasNF    =   $this->path . '/cces/assinadas/';
        $this->tools->validadasNF    =   $this->path . '/cces/validadas/';
        $this->tools->aprovadasNF    =   $this->path . '/cces/aprovadas/';
        $this->tools->enviadasNF     =   $this->path . '/cces/enviadas/';
        $this->tools->canceladasNF   =   $this->path . '/cces/canceladas/';
        $this->tools->inutilizadasNF =   $this->path . '/cces/inutilizadas/';
        $this->tools->temporarioNF   =   $this->path . '/cces/temporario/';
        $this->tools->recebidasNF    =   $this->path . '/cces/recebidas/';
        $this->tools->consultadasNF  =   $this->path . '/cces/consultadas/';
        $this->tools->aprovadasPDF   =   $this->path . '/cces/pdf_aprovadas/';

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
        $this->XML = $this->tools->assina($this->XML, 'infEvento');
        $this->XML = str_replace('<?xml version="1.0"?>','',$this->XML);

        $xmlAprovada = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" . $this->XML;

        if ($this->versaoNFe == 1) {
            $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
            $xml .= "<evento  xmlns=\"http://www.portalfiscal.inf.br/nfe\" xmlns:ds=\"http://www.w3.org/2000/09/xmldsig#\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" versao=\"1.00\">";
        }
        else {
            //$xml = "<evento  xmlns=\"http://www.portalfiscal.inf.br/nfe\" versao=\"1.00\">";
        }
        $xml = '<envEvento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">';
        $xml .= '<idLote>1</idLote>';
        $xml .= trim($this->XML);
        $xml .= "</envEvento>";
        
        $this->XML = $xml;
        if ($this->versaoNFe ==  1) {
            $this->tools->validaXML($this->XML, $this->path . '/Schemas/CCe_NT2011.003/CCe_v1.00a/envCCe_v1.00.xsd');
        }
        else {
            $this->tools->validaXML($this->XML, $this->path . '/Schemas/CCe_NT2011.003/CCe_v1.00a/envCCe_v1.00.xsd');
        }
        if ($this->tools->errorStatus) {
			$erros__ = $this->tools->errorMsg;
			array_pop($erros__);
			$erro__ = array();
		
			if(count($erro__) > 0)
			{
				$this->erros[] = 'Erro na validação do XML';
				$this->erros = array_merge($this->erros, $erro__);
			}
        }

        if (!$this->temErro()) {
            $this->IdLote = $this->geraNumeroLote();
        }

        if (!$this->temErro()) {
            $this->XML = str_replace('<idLote>1</idLote>','<idLote>'.$this->IdLote.'</idLote>',$this->XML);

            $xmlFile = $this->tools->temporarioNF . $this->strzero($this->IdLote, 15) . '-env-lot.xml';
            $f = fopen($xmlFile, 'w+');
            fwrite($f, $this->XML);
            fclose($f);
        }

        if (!$this->temErro()) {
            $this->status = VALIDADA;
            $this->gravaDadosCCe();
        }

        if (!$this->temErro()) {
            $this->enviaCCe();
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

    public function enviaCCe() {
        if ($this->tools->enviaCC($this->XML)) {
            $this->cod_ret = $this->tools->cStat;
            $this->msg_erro = $this->tools->xMotivo;
            $this->verAplic = $this->tools->verAplic;
            if ($this->cod_ret == '135') {
                $this->nProt = $this->tools->nProt;
                $this->dhRecbto = $this->tools->dhRecbto;
                $this->status = ENVIADA;
            }
            else {
                $this->erros [] = "NFe não foi aceita.";
                $this->erros [] = $this->tools->xMotivo;
                $this->status = RECUSADA;
            }
            $sql = "UPDATE nfe_notas SET status = '".$this->status."', cod_ret = " . $this->cod_ret . ", msg_erro = '" . $this->msg_erro . "', recibo = ".$this->recibo.", dhRecbto = '".$this->dhRecbto."', verAplic = '".$this->verAplic."' WHERE Id = '" . $this->Id . "'";
            mysql_query($sql, $this->conMysql);

            $sql = "UPDATE nfe_lotes SET recibo = " . $this->recibo . " WHERE IdLote = " . $this->IdLote;
            mysql_query($sql, $this->conMysql);
        }
        else {
            $this->erros [] = "Falha no envio da NFe.";
            echo '<pre>' . htmlspecialchars( $this->tools->debug_str ) . '</pre>';
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
                }
                else {
                    $this->erros [] = "NFe não foi aprovada.";
                    $this->erros [] = $this->msg_erro;
                    $this->status = NAO_APROVADA;
                }
            }
            else {
                $this->erros [] = "NFe não foi aprovada.";
                $this->erros [] = $this->tools->xMotivo;
                $this->status = NAO_APROVADA;
            }
            $sql = "UPDATE nfe_notas SET status = '".$this->status."', cod_ret = " . $this->cod_ret . ", msg_erro = '" . $this->msg_erro . "', nProt = " . $this->nProt . ", digVal = '" . $this->digVal . "', dhRecbto = '".$this->dhRecbto."' WHERE Id = '" . $this->Id . "'";
            mysql_query($sql, $this->conMysql);
        }
        else {
            $this->erros [] = "Ocorreu um erro ao consultar a situação da NFe.";
        }
        
        if ($this->status == APROVADA) {
            $this->salvaNFeAprovada();
        }
    }

    public function geraXML() {
        $this->geraId();
        $this->XML = sprintf('<evento versao="%s" xmlns="http://www.portalfiscal.inf.br/nfe">', $this->versao);
        $this->XML .= sprintf('<infEvento Id="%s">', $this->Id);

        $this->XML .= $this->cOrgao->getXML();
        $this->XML .= $this->tpAmb->getXML();
        $this->XML .= $this->CNPJ->getXML();
        $this->XML .= $this->CPF->getXML();
        $this->XML .= $this->chNFe->getXML();
        $this->XML .= $this->dhEvento->getXML();
        $this->XML .= $this->tpEvento->getXML();
        $this->XML .= $this->nSeqEvento->getXML();
        $this->XML .= $this->verEvento->getXML();
        $this->XML .= sprintf('<detEvento versao="%s">', $this->versao);
        $this->XML .= $this->descEvento->getXML();
        $this->XML .= $this->xCorrecao->getXML();
        $this->XML .= $this->xCondUso->getXML();
        $this->XML .= '</detEvento>';
        
        $this->XML .= '</infEvento>';
        $this->XML .= '</evento>';
    }

    private function geraId() {
        $this->Id = 'ID' . $this->tpEvento->valor . $this->chNFe->valor . $this->strzero($this->nSeqEvento->valor, 2);
    }

    private function strzero($n, $tamanho) {
        $conteudo = (string) $n;
        $diferenca = $tamanho - strlen($conteudo);
        if ($diferenca>0) for($i=0;$i<$diferenca;$i++) $conteudo = '0'.$conteudo;
        return $conteudo;
    }

    private function inverte($n) {
        $ret = '';
        $s = (string) $n;
        for($i=strlen($s)-1;$i>=0;$i--) {
            $ret .= $s[$i];
        }
        return $ret;
    }

    private function calcaulaDV($n) {
        $dv = 0;
        $s = (string) $n;
        $soma = 0;
        $mult = 2;
        for($i=strlen($s)-1;$i>=0;$i--) {
            $valor = (int) $s[$i];
            $soma += $valor * $mult;
            if ($mult == 9) {
                $mult = 2;
            }
            else {
                $mult++;
            }
        }

        $resto = $soma % 11;
        if ($resto > 1) {
            $dv = 11 - $resto;
        }

        return $dv;
    }

    public function gravaDadosCCe() {
        $query = "SELECT * FROM cce WHERE Id = '".$this->Id."'";
        $q = mysql_query($query, $this->conMysql);
        if (mysql_num_rows($q) > 0) {
            $query = "DELETE FROM cce WHERE Id = '".$this->Id."'";
            mysql_query($query, $this->conMysql);           
        }

        $query  = "INSERT INTO cce VALUES(";
        $query .= "'".$this->Id."', ";
        $query .= "".$this->cOrgao->getValor().", ";
        $query .= "".$this->tpAmb->getValor().", ";
        $query .= "'".$this->CNPJ->getValor()."', ";
        $query .= "'".$this->CPF->getValor()."', ";
        $query .= "'".$this->chNFe->getValor()."', ";
        $query .= "'".$this->dhEvento->getValor()."', ";
        $query .= "".$this->tpEvento->getValor().", ";
        $query .= "'".$this->nSeqEvento->getValor()."', ";
        $query .= "'".$this->versao."', ";
        $query .= "'".addslashes($this->descEvento->getValor())."', ";
        $query .= "'".addslashes($this->xCorrecao->getValor())."', ";
        $query .= "'".addslashes($this->xCondUso->getValor())."' ";
        $query .= ") ";
		
	if (!mysql_query($query, $this->conMysql)) {
            echo $query . '<br>';
            $this->erros [] = "Ocorreu um erro ao gravar a nota fiscal.";
            $this->erros [] = mysql_error($this->conMysql);
            return false;
        }


    }

    public function geraNumeroLote() {
        $query = "INSERT INTO cce_lotes(dataEnvio) values (NOW())";

        if (!mysql_query($query, $this->conMysql)) {
            $this->erros [] = "Não foi possível gerar o número do lote.";
            return 0;
        }
        else {
            return mysql_insert_id($this->conMysql);
        }
    }

    public function getDadosCCe($Id) {
        $query = "SELECT * FROM cce WHERE Id = '".$Id."'";
        $q = mysql_query($query, $this->conMysql);
        $r = mysql_fetch_array($q);

        $this->Id = $r['Id'];
        $this->cOrgao->valor = $r['cOrgao'];
        $this->tpAmb->valor = $r['tpAmb'];
        $this->CNPJ->valor = $r['CNPJ'];
        $this->CPF->valor = $r['CPF'];
        $this->chNFe->valor = $r['chNFe'];
        $this->dhEvento->valor = $r['dhEvento'];
        $this->tpEvento->valor = $r['tpEvento'];
        $this->nSeqEvento->valor = $r['nSeqEvento'];
        $this->versao = $r['versao'];
        $this->descEvento->valor = stripslashes($r['descEvento']);
        $this->xCorrecao->valor = stripslashes($r['xCorrecao']);
        $this->xCondUso->valor = stripslashes($r['xCondUso']);
        return true;
    }

    public function temErro() {
        return count($this->erros) > 0;
    }

    public function imprimir($Id, $salvar = false) {
        //$this->getDadosNFe($Id);
        //$d = new NFe_danfe($this, $salvar);
        //$d->geraDANFE();
    }

    public function salvaNFeAprovada() {
        $xmldoc = new DOMDocument();
        $xmldoc->preservWhiteSpace = FALSE; //elimina espaços em branco
        $xmldoc->formatOutput = FALSE;
        $xmldoc->loadXML($this->XML,LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
        $node = $xmldoc->getElementsByTagName('NFe')->item(0);

        $xmlFile = $this->tools->aprovadasNF . $this->Id . '-nfe.xml';
        
        $f = fopen($xmlFile, 'w+');
        fwrite($f, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
        if ($this->versaoNFe == 1) {
            fwrite($f, "<nfeProc xmlns=\"http://www.portalfiscal.inf.br/nfe\" versao=\"1.10\">");
        }
        else {
            fwrite($f, "<nfeProc xmlns=\"http://www.portalfiscal.inf.br/nfe\" versao=\"2.00\">");
        }
        fwrite($f, $xmldoc->saveXML($node));
        if ($this->versaoNFe == 1) {
            fwrite($f, "<protNFe versao=\"1.10\">");
        }
        else {
            fwrite($f, "<protNFe versao=\"2.00\">");
        }
        fwrite($f, "<infProt Id=\"".$this->Id."\">");
        fwrite($f, "<tpAmb>".$this->ide_tpAmb->valor."</tpAmb>");
        fwrite($f, "<verAplic>".$this->verAplic."</verAplic>");
        fwrite($f, "<chNFe>".$this->Id."</chNFe>");
        fwrite($f, "<dhRecbto>".$this->dhRecbto."</dhRecbto>");
        fwrite($f, "<nProt>".$this->nProt."</nProt>");
        fwrite($f, "<digVal>".$this->digVal."</digVal>");
        fwrite($f, "<cStat>".$this->cod_ret."</cStat>");
        fwrite($f, "<xMotivo>".$this->msg_erro."</xMotivo>");
        fwrite($f, "</infProt>");
        fwrite($f, "</protNFe>");
        fwrite($f, "</nfeProc>");
        fclose($f);

        /*
        $sig = $xmldoc->getElementsByTagName('Signature')->item(0);
        $node->removeChild("Signature");

        $xml = new DOMDocument("1.0", "UTF-8");
        $xml->preservWhiteSpace = FALSE; //elimina espaços em branco
        $xml->formatOutput = FALSE;
        $node2 = $xml->createElement('nfeProc');
        $node2->setAttribute("xmlns", "http://www.portalfiscal.inf.br/nfe");
        $node2->setAttribute("versao", "1.10");
        $xnode = $xml->importNode($node, true);
        $node2->appendChild($xnode);

        $prot = $xml->createElement('protNFe');
        $prot->setAttribute("versao", "1.10");

        $inf = $xml->createElement('infProt');
        $inf->setAttribute("Id", "ID" . $this->Id);
        $tpAmb = $xml->createElement("tpAmb", $this->ide_tpAmb->valor);
        $verAplic = $xml->createElement("verAplic", $this->verAplic);
        $chNFe = $xml->createElement("chNFe", $this->Id);
        $dhRecbto = $xml->createElement("dhRecbto", $this->dhRecbto);
        $nProt = $xml->createElement("nProt", $this->nProt);
        $digVal = $xml->createElement("digVal", $this->digVal);
        $cStat = $xml->createElement("cStat", $this->cod_ret);
        $xMotivo = $xml->createElement("xMotivo", $this->msg_erro);
        $inf->appendChild($tpAmb);
        $inf->appendChild($verAplic);
        $inf->appendChild($chNFe);
        $inf->appendChild($dhRecbto);
        $inf->appendChild($nProt);
        $inf->appendChild($digVal);
        $inf->appendChild($cStat);
        $inf->appendChild($xMotivo);
        $prot->appendChild($inf);
        $node2->appendChild($prot);
        $xml->appendChild($node2);
        
        $xmlFile = $this->tools->aprovadasNF . $this->Id . '-nfe.xml';
        //$this->tools->validaXML($xml->saveXML(), $this->path . '/Schemas/procNFe_v1.10.xsd');
        //if ($this->tools->errorStatus) {
        //    $this->erros [] = 'Erro na validação do XML';
        //    $this->erros = array_merge($this->erros, $this->tools->errorMsg);
       // }
        $xmlAss = $this->tools->assina($xml->saveXML(), 'infNFe');
        $f = fopen($xmlFile, 'w+');
        fwrite($f, $xmlAss);
        fclose($f);
       //$xml->save($xmlFile); */
    }

    public function salvarNFeDoBanco($Id) {
        $this->getDadosNFe($Id);
        $this->salvaNFeAprovada();
    }
}

?>