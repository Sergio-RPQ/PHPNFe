<?php

/**
 *
 * NFEtools
 * Copyright (c) 2009 Roberto L. Machado
 *
 * ================================================
 * Assinador funcional 2009-07-04
 * Carga do certificado funcional 2009-07-22
 *
 * ================================================
 * Dependências
 *      module PHP5-cur
 *      module OpenSSL
 *      class NUSoap
 *      class FPDF
 *
 * @author   Roberto L. Machado <roberto.machado@superig.com.br>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  $Id:
 * @access   public
 * */
require_once('./libs/nusoap/nusoap.php');
require_once('./libs/fpdf/fpdf.php');


define('HOMOLOGACAO', '2');
define('PRODUCAO', '1');
define('CONTINGENCIAHOMOLOGACAO', '4');
define('CONTINGENCIAPRODUCAO', '3');

class NFe_tools {
    //*************************
    // Propriedades
    //*************************

    /**
     * Ambiente de conexao com o webservie
     * Esta propriedade deve ser setada na inicialização da classe
     * @var string $ambiente
     * @access public
     */
    var $ambiente = "2"; //homologaçao

    /**
     * Contem os dados para debug do NuSoap
     * @var string $debug_str
     * @access public
     */
    var $debug_str = '';

    /**
     * URLs dos webservice
     * NOTA : Estes dados deve ser dinâmicamente carregados pelo sistema
     * com base em um banco de dados para tornar o sistema mais flexível
     *
     * @var array $aURLwsdl
     * @access public
     */
    var $aURLwsdl = array();

    /**
     * Funçoes do webservice
     * NOTA : Estes dados deve ser dinâmicamente carregados pelo sistema
     * com base em um banco de dados para tornar o sistema mais flexível
     *
     * @var      array
     * @access   public
     * */
    var $aFunctionWdsl = array(
        'ConsultaCadastro' => 'consultaCadastro',
        'NfeRecepcao' => 'nfeRecepcaoLote',
        'NfeRetRecepcao' => 'nfeRetRecepcao',
        'NfeCancelamento' => 'nfeCancelamentoNF',
        'NfeInutilizacao' => 'nfeInutilizacaoNF',
        'NfeStatusServico' => 'nfeStatusServicoNF',
        'NfeConsultaNF' => 'nfeConsultaNF'
    );

    /**
     * Arquivos xsd das funcoes do webservice
     * NOTA : Estes dados deve ser dinâmicamente carregados pelo sistema
     * com base em um banco de dados para tornar o sistema mais flexível
     *
     * @var      array
     * @access   public
     * */
    var $aFxsd = array(
        'ConsultaCadastro' => 'consCad_v1.01.xsd',
        'NfeRecepcao' => 'envNFe_v1.10.xsd',
        'NfeRetRecepcao' => 'retEnviNFe_v1.10.xsd',
        'NfeCancelamento' => 'cancNFe_v1.07.xsd',
        'NfeInutilizacao' => 'inutNFe_v1.07.xsd',
        'NfeStatusServico' => 'consStatServ_v1.07.xsd',
        'NfeConsultaNF' => 'consSitNFe_v1.07.xsd',
        'CabecMsg' => 'cabecMsg_v1.02.xsd'
    );

    /**
     * Versoes dos layouts xsd das funcoes do webservice
     * NOTA : Estes dados deve ser dinâmicamente carregados pelo sistema
     * com base em um banco de dados para tornar o sistema mais flexível
     * @var      array
     * @access   public
     * */
    var $aVerxsd = array(
        'ConsultaCadastro' => '1.01',
        'NfeRecepcao' => '1.10',
        'NfeRetRecepcao' => '1.10',
        'NfeCancelamento' => '1.07',
        'NfeInutilizacao' => '1.07',
        'NfeStatusServico' => '1.07',
        'NfeConsultaNF' => '1.07',
        'CabecMsg' => '1.02'
    );


    /**
     * Variaveis passadas para a operaçao do sistema
     *
     */

    /**
     * Codigo da UF da empresa emitente
     * @var string
     * @access public
     */
    var $UFcod = '';
    //var $UFcod='43';
    /**
     * Id da NFe com 47 digitos NFe83737377377373...
     * @var string
     * @access public
     */
    var $Id = '';

    /**
     * Nome do certificado pfx
     * @var string $nameCert
     * @access public
     */
    var $nameCert = '';

    /**
     * Senha da chave privada
     * @var string $passKey
     * @access public
     */
    var $passKey = '';

    /**
     * Senha de decriptação da chave privada, se houver
     * Normalmente não é usado
     * @var string $passPhrase
     * @access public
     */
    var $passPhrase = '';

    /**
     *  caminhos de acesso aos diretorios de armazenamento das comunicações
     *
     * */

    /**
     * Caminho completo para o diretorio que contêm os certificados,
     * em qualquer formato. Será o local onde serão gerados os certificados
     * em formato pem.
     * @var string $pathCerts
     * @access public
     */
    var $pathCerts = '';

    /**
     * Caminho para os schemas xsd que serão utilizados para a validação
     * das NFe ou de mensagens
     * @var string
     * @access publico
     */
    var $pathXSD = '';

    /**
     * Caminho para o diretorio de arquivos temporarios.
     * Neste diretorio serão colocados arquivos sem necessidade de backup,
     * como  por exemplo as respostas as consultas de status ao SEFAZ
     * @var string
     * @access public
     */
    var $temporarioNF = '';

    /**
     * Caminho onde são postadas as NFe pelo sistema ERP ou as notas manuais, em xml ou txt
     * para serem assinadas, validadas e posteriormnte enviadas ao SEFAZ.
     * @var string
     * @access public
     */
    var $entradasNF = '';

    /**
     * Caminho para onde são movidas as NFe que já foram assinadas.
     * @var string
     * @access public
     */
    var $assinadasNF = '';

    /**
     * Caminho para onde são movidas as NFe assinadas, validadas internamente e já remetidas ao SEFAZ
     * para aprovação.
     * Neste diretorio também srão postadas os retornos do SEFAZ tanto o recibo do envio
     * quanto o retorno da consulta do recibo, que contêm o protocolo de aprovação da NFe
     * @var string
     * @access public
     */
    var $validadasNF = '';

    /**
     * Caminho onde são colocadas as NFe retornadas do SEFAZ como aceitas.
     * Estas NFe podem ser impressas DANFE e preparadas para envio ao destinatário
     * @var string
     * @access public
     */
    var $aprovadasPDF = '';
    var $aprovadasNF = '';

    /**
     * Caminho onde são mantidas as NFe aprovadas, preparadas e já enviadas ao destinatário
     * @var string
     * @access public
     */
    var $enviadasNF = '';

    /**
     * Caminho onde as solicitações de cancelamento e as respostas do cancelamento são armazenadas
     * @var string
     * @access public
     */
    var $canceladasNF = '';

    /**
     * Caminho onde as solicitações e as respostas de inutilização são armazenadas
     * @var string
     * @access public
     */
    var $inutilizadasNF = '';

    /**
     * Caminho onde são colocadas as NFe qunado são recebidas dos fornecedores
     * @var string
     * @access public
     */
    var $recebidasNF = '';

    /**
     * Caminho onde são movidas as NFe recebidas dos fornecedores
     * e já validadas e aprovadas
     * @var string
     * @access public
     */
    var $consultadasNF = '';


    /**
     *  Retornos de erros do sistema
     */

    /**
     * Estado de erro
     * @var boolean
     * @access public
     */
    var $errorStatus = false;

    /**
     * Mensagem de erro
     * @var string
     * @access public
     */
    var $errorMsg = '';

    /**
     * Código do erro
     * @var string
     * @access public
     */
    var $errorCod = '';
    // retornos dos serviços SEFAZ
    /**
     * Código de retorno do serviço retornado da SEFAZ
     * @var string
     * @access public
     */
    var $cStat = '';

    /**
     * Versão do aplicativo retornado da SEFAZ
     * @var string
     * @access public
     */
    var $verAplic = '';

    /**
     * Motivo relacionado ao código de retorno, retornado da SEFAZ
     * @var string
     * @access public
     */
    var $xMotivo = '';

    /**
     * Cbervações retornado da SEFAZ
     * @var string
     * @access public
     */
    var $xObs = '';

    /**
     * Tempo médio de resposta retornado da SEFAZ
     * @var int
     * @access public
     * */
    var $tMed = '1';

    /**
     * Data e hora do retorno da chamada do webservice retornado da SEFAZ
     * @var string
     * @access public
     * */
    var $dhRecbto = '';

    /**
     * Tipo de ambiente da comunicaçao retornado da SEFAZ
     * @var int
     * @access public
     */
    var $tpAmb = '';

    /**
     * Número do recibo da SEFAZ
     * @var string
     * @access public
     */
    var $nRec = '';

    /**
     * Código da UF retornado da SEFAZ
     * @var int
     * @access public
     */
    var $cUF = '';

    /**
     * Sigla da UF retornado da SEFAZ
     * @var string
     * @access public
     */
    var $UF = '';

    /**
     * Dados de retorno das NFe enviadas no lote retornado da SEFAZ
     * @var array
     * @access public
     */
    var $aNFe = array();

    /**
     * Número inicial de NF inutilizada retornado da SEFAZ
     * @var string
     * @access public
     */
    var $nNFIni = '';

    /**
     * Número final de NF inutilizada retornado da SEFAZ
     * @var string
     * @access public
     */
    var $nNFFin = '';

    /**
     * Número do protocolo retornado do SEFAZ
     * @var string
     * @access public
     */
    var $nProt = '';

    /**
     * Número do modelo de NF retornado do SEFAZ
     * @var int
     * @access public
     */
    var $modelo = '';

    /**
     * Número de serie da NF retornado do SEFAZ
     * @var int
     * @access public
     */
    var $serie = '';

    /**
     * Ano da NF retornado do SEFAZ
     * @var int
     * @access public
     */
    var $ano = '';

    /**
     * Número do CNPJ da empresa emitente retornado pelo SEFAZ
     * @var string
     * @access public
     */
    var $CNPJ = '';

    /**
     * Número do CPF da consulta retornado da SEFAZ
     * @var string
     * @access public
     */
    var $CPF = '';

    /**
     * Número da inscriçao estadual retornado da SEFAZ
     *
     * @var string
     * @access public
     */
    var $IE = '';

    /**
     * Número do ID da NFe 44 digitos retornado do SEFAZ
     * @var string
     * @access public
     */
    var $chNFe = '';

    /**
     * Digest da assinatura digital da NFe retornado do SEFAZ
     * @var string
     * @access public
     */
    var $digVal = '';

    /**
     * Data e hora da consulta retornado do SEFAZ
     *
     * @var string
     * @access public
     */
    var $dhCons = '';

    /**
     * Retorno do SEFAZ na consulta de cadastros retornado da SEFAZ
     * NOTA : Pode não haver este retorno
     * @var array
     * @access public
     */
    var $aCad = array();
    // variaveis relativas ao certificado
    /**
     * Número de meses até a expiração do certificado digital
     * @var int
     * @access public
     */
    var $monthsToExpire = 0;

    /**
     * Número de dias até a expiração do certificado digital
     * @var int
     * @access public
     */
    var $daysToExpire = 0;
    var $versaoNFe = '1.10';

    /**
     * Variáveis Privadas
     */

    /**
     * Caminho completo até o arquivo da chave publica
     * em formato pem
     * @var string $pathCert
     * @access private
     */
    private $pathCert = '';

    /**
     * Caminho completo até o arquivo da chave privada
     * em formato pem
     * @var string $pathKey
     * @access private
     */
    private $pathKey = '';

    /**
     * Resource que contêm a chave privada
     * @var resource $rPrivkey
     * @access private
     */
    private $rPrivkey = '';

    /**
     * Resource que contêm a chave publica
     * @var resource $rPubkey
     * @access private
     */
    private $rPubkey = '';

    /**
     * Indicadores de schemas utilizados na construçao das mensagens SOAP
     * e na assinatura digital
     *
     */

    /**
     * $URLxsi
     * @var string
     * @access private
     */
    private $URLxsi = 'http://www.w3.org/2001/XMLSchema-instance';

    /**
     * $URLxsd
     * @var string
     * @access private
     */
    private $URLxsd = 'http://www.w3.org/2001/XMLSchema';

    /**
     * $URLnfe
     * @var string
     * @access private
     */
    private $URLnfe = 'http://www.portalfiscal.inf.br/nfe';

    /**
     * $URLdsig
     * @var string
     * @access private
     */
    private $URLdsig = 'http://www.w3.org/2000/09/xmldsig#';

    /**
     * $URLCanonMeth
     * @var string
     * @access private
     */
    private $URLCanonMeth = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315';

    /**
     * $URLSigMeth
     * @var string
     * @access private
     */
    private $URLSigMeth = 'http://www.w3.org/2000/09/xmldsig#rsa-sha1';

    /**
     * $URLTransfMeth_1
     * @var string
     * @access private
     */
    private $URLTransfMeth_1 = 'http://www.w3.org/2000/09/xmldsig#enveloped-signature';

    /**
     * $URLTransfMeth_2
     * @var string
     * @access private
     */
    private $URLTransfMeth_2 = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315';

    /**
     * $URLDigestMeth
     * @var string
     * @access private
     */
    private $URLDigestMeth = 'http://www.w3.org/2000/09/xmldsig#sha1';

    /**
     * Resposta do webservice
     * @var object $response
     * @access private
     */
    private $response;
    private $certKEY;
    public $soapDebug;

    /**
     * Metodos Publicos
     */
    //construtor
    function __construct($versao = 1) {
        if ($versao == 1) {
            $this->versaoNFe = '1.10';
        } else {
            $this->versaoNFe = '2.00';

            $this->aFxsd = array(
                'ConsultaCadastro' => 'consCad_v2.00.xsd',
                'NfeRecepcao' => 'envNFe_v2.00.xsd',
                'NfeRetRecepcao' => 'retEnviNFe_v2.00.xsd',
                'NfeCancelamento' => 'cancNFe_v2.00.xsd',
                'NfeInutilizacao' => 'inutNFe_v2.00.xsd',
                'NfeStatusServico' => 'consStatServ_v2.00.xsd',
                'NfeConsultaNF' => 'consSitNFe_v2.00.xsd',
                'CabecMsg' => 'cabecMsg_v2.00.xsd'
            );

            $this->aVerxsd = array(
                'ConsultaCadastro' => '2.00',
                'NfeRecepcao' => '2.00',
                'NfeRetRecepcao' => '2.00',
                'NfeCancelamento' => '2.00',
                'NfeInutilizacao' => '2.00',
                'NfeStatusServico' => '2.00',
                'NfeConsultaNF' => '2.00',
                'CabecMsg' => '2.00'
            );

            $this->aFunctionWdsl = array(
                'ConsultaCadastro' => 'consultaCadastro',
                'NfeRecepcao' => 'nfeRecepcaoLote2',
                'NfeRetRecepcao' => 'nfeRetRecepcao2',
                'NfeCancelamento' => 'nfeCancelamentoNF2',
                'NfeInutilizacao' => 'nfeInutilizacaoNF2',
                'NfeStatusServico' => 'nfeStatusServicoNF2',
                'NfeConsultaNF' => 'nfeConsultaNF2'
            );
        }
    }

    //destrutor
    function __destruct() {
        
    }

    /**
     * carregaCert
     * Carrega o certificado pfx e gera as chaves privada e publica no
     * formato pem para uso do SOAP e registra as gvariaveis de ambiente
     * Esta função deve ser invocada enates das outras do sistema que
     * dependam do certificado
     * Resultado
     *  A função irá criar o certificado digital (chaves publicas e privadas)
     *  no formato pem e grava-los no diretorio indicado em $this->pathCerts
     *  com os nomes :
     *     privatekey.pem
     *     publickey.pem
     *  Estes arquivos tabém serão carregados nas variáveis da classe
     *  $this->pathCert (com o caminho completo para o arquivo publickey.pem)
     *  $this->pathKey (com o caminho completo para o arquivo privatekey.pem)
     * Dependencias
     *   $this->pathCerts
     *   $this->nameCert
     *   $this->passKey
     * FUNCIONAL !!
     * @param	none
     * @return	boolean TRUE se o certificado foi carregado e FALSE se nao
     * @access  public
     * */
    public function carregaCert() {
        //verificar se o nome do certificado e
        //o path foram carregados nas variaveis da classe
        if ($this->pathCerts == '' || $this->nameCert == '') {
            $this->errorMsg = 'Um certificado deve ser passado para a classe!!';
            $this->errorCod = 'C1';
            $this->errorStatus = TRUE;
            return FALSE;
        }

        //monta o caminho completo até o certificado pfx
        $pCert = $this->pathCerts . $this->nameCert;
        //verifica se o arquivo existe
        if (!file_exists($pCert)) {
            $this->errorMsg = 'Certificado não encontrado!!';
            $this->errorCod = 'C2';
            $this->errorStatus = TRUE;
            return FALSE;
        }
        //carrega o certificado em um string
        $key = file_get_contents($pCert);
        //carrega os certificados e chaves para um array denominado $x509certdata
        if (!openssl_pkcs12_read($key, $x509certdata, $this->passKey)) {
            $this->errorMsg = 'O certificado não pode ser lido!! Provavelmente corrompido ou com formato inválido!!';
            $this->errorCod = 'C3';
            $this->errorStatus = TRUE;
            return FALSE;
        }
        //verifica sua validade
        if (!$this->validCert($x509certdata['cert'])) {
            $this->errorMsg = 'Certificado invalido!!';
            $this->errorCod = 'C4';
            $this->errorStatus = TRUE;
            return FALSE;
        }
        //carrega a chave privada em um resource para uso do assinador
        $this->rPrivkey = openssl_pkey_get_private($x509certdata['pkey']);
        //carrega o certificado em um resource para uso do assinador
        $this->rPubkey = openssl_pkey_get_public($x509certdata['cert']);
        //monta o path completo com o nome da chave privada
        $filePriv = $this->pathCerts . 'privatekey.pem';
        //verifica se arquivo já existe
        if (file_exists($filePriv)) {
            //se existir verificar se é o mesmo
            $conteudo = file_get_contents($filePriv);
            //comparar os primeiros 30 digitos
            if (!substr($conteudo, 0, 30) == substr($x509certdata['pkey'], 0, 30)) {
                //se diferentes gravar o novo   
                if (!file_put_contents($filePriv, $x509certdata['pkey'])) {
                    $this->errorMsg = 'Impossivel gravar no diretório!!! Permissão negada!!';
                    $this->errorCod = 'F1';
                    $this->errorStatus = TRUE;
                    return FALSE;
                }
            }
        } else {
            //salva a chave privada no formato pem para uso so SOAP
            if (!file_put_contents($filePriv, $x509certdata['pkey'])) {
                $this->errorMsg = 'Impossivel gravar no diretório!!! Permissão negada!!';
                $this->errorCod = 'F1';
                $this->errorStatus = TRUE;
                return FALSE;
            }
        }
        //monta o path completo com o nome da chave prublica
        $filePub = $this->pathCerts . 'publickey.pem';
        $this->certKEY = $this->pathCerts . 'key.pem';
        //verifica se arquivo já existe
        if (file_exists($filePub)) {
            //se existir 
            //se existir verificar se é o mesmo
            $conteudo = file_get_contents($filePub);
            //comparar os primeiros 30 digitos
            if (!substr($conteudo, 0, 30) == substr($x509certdata['cert'], 0, 30)) {
                //se diferentes gravar o novo   
                $n = file_put_contents($filePub, $x509certdata['cert']);
                $n = file_put_contents($this->certKEY, $x509certdata['pkey'] . "\r\n" . $x509certdata['cert']);
            }
        } else {
            //salva a chave prublica no formato pem para uso so SOAP
            $n = file_put_contents($filePub, $x509certdata['cert']);
            $n = file_put_contents($this->certKEY, $x509certdata['pkey'] . "\r\n" . $x509certdata['cert']);
        }
        //verifica que as propriedades do ambinte sejam setadas
        $this->pathCert = $filePub;
        $this->pathKey = $filePriv;
        return TRUE;
    }

    /**
     * Validaçao do cerificado digital, alem de indicar
     * a validade este metodo carrega a propriedade
     * mesesToexpire da classe quer indica o numero de
     * meses que faltam para expirar a validade do certificado
     * esta informacao pode ser utilizada para a gestao dos
     * certificados de forma a garantir que sempre estejam validos
     * FUNCIONAL !!
     * @param	string  $cert Certificado digital no formato pem
     * @return	boolean	True se o certificado estiver dentro do prazo de validade, e False se nao
     * @access  public
     * */
    public function validCert($cert) {
        $flagOK = true;
        $data = openssl_x509_read($cert);
        $cert_data = openssl_x509_parse($data);
        // reformata a data de validade;
        $ano = substr($cert_data['validTo'], 0, 2);
        $mes = substr($cert_data['validTo'], 2, 2);
        $dia = substr($cert_data['validTo'], 4, 2);
        //obtem o timeestamp da data de validade do certificado
        $dValid = gmmktime(0, 0, 0, $mes, $dia, $ano);
        // obtem o timestamp da data de hoje
        $dHoje = gmmktime(0, 0, 0, date("m"), date("d"), date("Y"));
        // compara a data de validade com a data atual
        if ($dValid < $dHoje) {
            $flagOK = false;
            $this->errorStatus = TRUE;
            $this->errorMsg = "Erro Certificado:  A Validade do certificado expirou em [" . $dia . '/' . $mes . '/' . $ano . "] INVALIDO !!";
            $this->errorCod = 'C3';
        } else {
            $flagOK = $flagOK && TRUE;
        }
        //diferença em segundos entre os timestamp
        $diferenca = $dValid - $dHoje;
        // convertendo para dias
        $diferenca = round($diferenca / (60 * 60 * 24), 0);
        //carregando a propriedade
        $this->daysToExpire = $diferenca;
        // convertendo para meses e carregando a propriedade
        $m = ($ano * 12 + $mes);
        $n = (date("y") * 12 + date("m"));
        $this->monthsToExpire = ($m - $n);
        return $flagOK;
    }

    /**
     * Assinador TOTALMENTE baseado em PHP das NFe e xmls
     * este assinador somente utiliza comandos nativos do PHP para assinar
     * FUNCIONAL !!!! resulta em arquivo idêntico ao assinadorRS
     * Resultado
     *      o arquivo xml com a assinatura será salvo em
     *      $outDir ou $this->assinadasNF, nessa ordem  e
     *      também retornada como uma string pela função ao chamador
     *      O arquivo tem sua denominação estabelecida como :
     *      ID-NFe.xml
     *  Onde o ID é o identificador de 44 digitos numéricos da NFe (sem a sigla NFe)
     *          ex. 35090671780456000160550010000000010000000017-NFe.xml
     *
     * Dependência
     *      carregaCert()
     * @param	string $nfe
     * @param   string $tagid TAG que devera ser assinada
     * @return	mixed FALSE se houve erro ou string com o XML assinado
     * @access  public
     * */
    public function assina($docxml, $tagid = '', $outDir = '') {
        if ($tagid == '') {
            $this->errorMsg = 'Uma tag deve ser indicada para que seja assinada!!';
            $this->errorCod = 'A1';
            $this->errorStatus = TRUE;
            return FALSE;
        }

        //carrega o certificado sem as tags de inicio e fim
        $cert = $this->limpaCert();
        // limpeza do xml com a retirada dos CR e LF
        $order = array("\r\n", "\n", "\r");
        $replace = '';
        $docxml = str_replace($order, $replace, $docxml);
        // carrega o documento no DOM
        $xmldoc = new DOMDocument();
        $xmldoc->preservWhiteSpace = FALSE; //elimina espaços em branco
        $xmldoc->formatOutput = FALSE;
        // muito importante deixar ativadas as opçoes para limpar os espacos em branco
        // e as tags vazias
        $xmldoc->loadXML($docxml, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
        $root = $xmldoc->documentElement;
        //extrair a tag com os dados a serem assinados
        $node = $xmldoc->getElementsByTagName($tagid)->item(0);
        $id = trim($node->getAttribute("Id"));
        $idnome = ereg_replace('[^0-9]', '', $id);
        //extrai os dados da tag para uma string
        $dados = $node->C14N(FALSE, FALSE, NULL, NULL);
        //calcular o hash dos dados
        $hashValue = hash('sha1', $dados, TRUE);
        //converte o valor para base64 para serem colocados no xml
        $digValue = base64_encode($hashValue);
        //monta a tag da assinatura digital
        $Signature = $xmldoc->createElementNS($this->URLdsig, 'Signature');
        $root->appendChild($Signature);
        $SignedInfo = $xmldoc->createElement('SignedInfo');
        $Signature->appendChild($SignedInfo);
        //Cannocalization
        $newNode = $xmldoc->createElement('CanonicalizationMethod');
        $SignedInfo->appendChild($newNode);
        $newNode->setAttribute('Algorithm', $this->URLCanonMeth);
        //SignatureMethod
        $newNode = $xmldoc->createElement('SignatureMethod');
        $SignedInfo->appendChild($newNode);
        $newNode->setAttribute('Algorithm', $this->URLSigMeth);
        //Reference
        $Reference = $xmldoc->createElement('Reference');
        $SignedInfo->appendChild($Reference);
        $Reference->setAttribute('URI', '#' . $id);
        //Transforms
        $Transforms = $xmldoc->createElement('Transforms');
        $Reference->appendChild($Transforms);
        //Transform
        $newNode = $xmldoc->createElement('Transform');
        $Transforms->appendChild($newNode);
        $newNode->setAttribute('Algorithm', $this->URLTransfMeth_1);
        //Transform
        $newNode = $xmldoc->createElement('Transform');
        $Transforms->appendChild($newNode);
        $newNode->setAttribute('Algorithm', $this->URLTransfMeth_2);
        //DigestMethod
        $newNode = $xmldoc->createElement('DigestMethod');
        $Reference->appendChild($newNode);
        $newNode->setAttribute('Algorithm', $this->URLDigestMeth);
        //DigestValue
        $newNode = $xmldoc->createElement('DigestValue', $digValue);
        $Reference->appendChild($newNode);
        // extrai os dados a serem assinados para uma string
        $dados = $SignedInfo->C14N(FALSE, FALSE, NULL, NULL);
        //inicializa a variavel que irá receber a assinatura
        $signature = '';
        //executa a assinatura digital usando o resource da chave privada
        $resp = openssl_sign($dados, $signature, $this->rPrivkey);
        //codifica assinatura para o padrao base64
        $signatureValue = base64_encode($signature);
        //SignatureValue
        $newNode = $xmldoc->createElement('SignatureValue', $signatureValue);
        $Signature->appendChild($newNode);
        //KeyInfo
        $KeyInfo = $xmldoc->createElement('KeyInfo');
        $Signature->appendChild($KeyInfo);
        //X509Data
        $X509Data = $xmldoc->createElement('X509Data');
        $KeyInfo->appendChild($X509Data);
        //X509Certificate
        $newNode = $xmldoc->createElement('X509Certificate', $cert);
        $X509Data->appendChild($newNode);
        //grava na string o objeto DOM
        $docxml = $xmldoc->saveXML();
        //se for passado parametro de destino salvar o xml como arquvo
        if ($outDir != '') {
            $outname = $outDir . $idnome . '-NFe.xml';
            $ret = $xmldoc->save($outname);
        } else {
            //verificar a propriedade da classe assinadasNF
            if ($this->assinadasNF != '') {
                $outname = $this->assinadasNF . $idnome . '-NFe.xml';
                $ret = $xmldoc->save($outname);
            }
        }
        return $docxml;
    }

    /*     * ********************************************
     * Verificaçao da NF com base no xsd
     * FUNCIONAL !!
     * @param	string  $xmlfile Path completo para o arquivo xml
     * @param   string  $xsdfile Path completo para o arquivo xsd
     * @return	boolean TRUE se passou ou FALSE se foram detectados erros
     * @access  public
     * ********************************************* */

    public function validaXML($xmlfile, $xsdfile) {

        // Habilita a manipulaçao de erros da libxml
        libxml_use_internal_errors(true);

        // instancia novo objeto DOM
        $xmldoc = new DOMDocument();
        // carrega arquivo xml
        $xml = $xmldoc->loadXML($xmlfile);
        //$xml = $xmldoc->load($xmlfile);
        //$xmldoc->loadXML($xml,LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
        $erromsg = array();

        // valida o xml com o xsd
        if (!$xmldoc->schemaValidate($xsdfile)) {
            /**
             * Se não foi possível validar, você pode capturar
             * todos os erros em um array
             * Cada elemento do array $arrayErrors
             * será um objeto do tipo LibXmlError
             *
             */
            // carrega os erros em um array
            $aIntErrors = libxml_get_errors();
            //libxml_clear_errors();
            $flagOK = FALSE;
            foreach ($aIntErrors as $intError) {
                switch ($intError->level) {
                    case LIBXML_ERR_WARNING:
                        $erromsg [] = " Atençao $intError->code: ";
                        break;
                    case LIBXML_ERR_ERROR:
                        $erromsg [] = " Erro $intError->code: ";
                        break;
                    case LIBXML_ERR_FATAL:
                        $erromsg [] = " Erro Fatal $intError->code: ";
                        break;
                }
                $erromsg [] = $intError->message . ' - Coluna: ' . $intError->column . ' - Linha: ' . $intError->line . ';';
            }
        } else {
            $flagOK = TRUE;
            $this->errorStatus = FALSE;
            $this->errorMsg = array();
        }

        if (!$flagOK) {
            $this->errorStatus = TRUE;
            $this->errorMsg = $erromsg;
        }
        return $flagOK;
    }

    /*     * ********************************************
     * Verifica o status do servico da SEFAZ
     * 
     * Este metodo carrega a variavel
     * $this->cStat = 107 OK
     *        cStat = 108 sitema paralizado momentaneamente, aguardar retorno
     *        cStat = 109 sistema parado sem previsao de retorno, verificar status SCAN
     * se SCAN estiver ativado usar, caso caontrario aguardar pacientemente.
     * 
     *
     * FUNCIONAL !!
     * @param	none
     * @return	boolean True se operacional e False se nao
     * @access  public
     * ********************************************* */

    public function statusServico() {
//        error_reporting(E_ALL);
        //retorno da funçao
        $bRet = FALSE;
        // carga das variaveis da funçao do webservice
        $wsdl = 'NfeStatusServico';
        $cabecXsdfile = $this->aFxsd['CabecMsg'];
        $cabecVer = $this->aVerxsd['CabecMsg'];
        $dataXsdfile = $this->aFxsd[$wsdl];
        $dataVer = $this->aVerxsd[$wsdl];
        // array para comunicaçao soap
//        trigger_error('<consStatServ xmlns:xsi="'.$this->URLxsi.'" xmlns:xsd="'.$this->URLxsd.'" versao="'.$dataVer.'" xmlns="'.$this->URLnfe.'">'.'<tpAmb>'.$this->ambiente.'</tpAmb><cUF>'.$this->UFcod.'</cUF><xServ>STATUS</xServ></consStatServ>', E_USER_ERROR);
        if ($this->versaoNFe == '1.10') {
            $param = array(
                'nfeCabecMsg' => '<?xml version="1.0" encoding="utf-8"?><cabecMsg versao="' . $cabecVer . '" xmlns="' . $this->URLnfe . '"><versaoDados>' . $dataVer . '</versaoDados></cabecMsg>',
                'nfeDadosMsg' => '<consStatServ xmlns:xsi="' . $this->URLxsi . '" xmlns:xsd="' . $this->URLxsd . '" versao="' . $dataVer . '" xmlns="' . $this->URLnfe . '">' . '<tpAmb>' . $this->ambiente . '</tpAmb><cUF>' . $this->UFcod . '</cUF><xServ>STATUS</xServ></consStatServ>'
            );
            //envia o xml para o SOAP
            $retorno = $this->sendSOAP($param, $wsdl);
            $_OK = false;
            if (is_array($retorno)) {
                //pega os dados do array retornado pelo NuSoap
                $_OK = true;
                $xmlresp = utf8_encode($retorno[$this->aFunctionWdsl[$wsdl] . 'Result']);
            }
        } else {
            $namespace = 'http://www.portalfiscal.inf.br/nfe/wsdl/NfeStatusServico2';
            $header = '<nfeCabecMsg xmlns="' . $namespace . '"><cUF>' . $this->UFcod . '</cUF><versaoDados>2.00</versaoDados></nfeCabecMsg>';
            //montagem dos dados da mensagem SOAP
            $dados = '<nfeDadosMsg xmlns="' . $namespace . '"><consStatServ xmlns="http://www.portalfiscal.inf.br/nfe" versao="2.00"><tpAmb>' . $this->ambiente . '</tpAmb><cUF>' . $this->UFcod . '</cUF><xServ>STATUS</xServ></consStatServ></nfeDadosMsg>';
            $retorno = $this->sendSOAP2($dados, $wsdl, $header);
            $_OK = false;
            if ($retorno) {
                //pega os dados do array retornado pelo NuSoap
                $_OK = true;
                $xmlresp = utf8_encode($retorno);
            }
        }
        //verifica o retorno do SOAP
        if ($_OK) {
            //pega os dados do array retornado pelo NuSoap
            if ($xmlresp == '') {
                //houve uma falha na comunicação SOAP
                return FALSE;
            }
            //tratar dados de retorno
            $doc = new DOMDocument(); //cria objeto DOM
            $doc->formatOutput = false;
            $doc->preserveWhiteSpace = false;
            $doc->loadXML($xmlresp, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            // status do serviço
            $this->cStat = $doc->getElementsByTagName('cStat')->item(0)->nodeValue;
            // tempo medio de resposta
            $this->tMed = $doc->getElementsByTagName('tMed')->item(0)->nodeValue;
            // data e hora da mensagem
            $this->dhRecbto = $doc->getElementsByTagName('dhRecbto')->item(0)->nodeValue;
            //converter a informaçao de data hora para timestamp
            $this->dhRecbto = $this->convertTime($this->dhRecbto);
            // motivo da resposta (opcional)
            $this->xMotivo = $doc->getElementsByTagName('xMotivo')->item(0)->nodeValue;
            // obervaçoes opcional
            $this->xObs = $doc->getElementsByTagName('xObs')->item(0)->nodeValue;
            if ($this->cStat == '107') {
                $bRet = TRUE;
            }
            //nome do arquivo de rerono da função SOAP
            $nome = $this->temporarioNF . date('Ymd') . 'T' . date('His') . '-ret_sta.xml';
            //salva o xml retornado na pasta temporarioNF
            $doc->save($nome);
        } else {
            $this->errorStatus = true;
            $this->errorMsg = 'Nao houve retorno do NuSoap!!';
        }
        return $bRet;
    }

    /**
     * Solicita dados de situaçao de Cadastro
     * Não FUNCIONA !! Não sei porque
     * @param	string  $UF
     * @param   string  $IE
     * @param   string  $CNPJ
     * @param   string  $CPF
     * @return	boolean TRUE se sucesso ou FALSE se falha
     * @access  public
     * TODO
     * descobir motivo da falha
     *
     * */
    public function consultaCadastro($UF, $IE = '', $CNPJ = '', $CPF = '') {
        //variavel de retorno do metodo
        $bRet = FALSE;
        //variaveis do webservice
        $wsdl = 'ConsultaCadastro';
        $cabecXsdfile = $this->aFxsd['CabecMsg'];
        $cabecVer = $this->aVerxsd['CabecMsg'];
        $dataXsdfile = $this->aFxsd[$wsdl];
        $dataVer = $this->aVerxsd[$wsdl];

        $flagIE = FALSE;
        $flagCNPJ = FALSE;
        $flagCPF = FALSE;
        $marca = '';

        //selecionar o criterio de filtragem CNPJ ou IE ou CPF
        if ($IE != '') {
            $flagIE = TRUE;
            $marca = 'IE-' . $IE;
            $CNPJ = '';
            $CPF = '';
        }
        if ($CNPJ != '') {
            $flagCNPJ = TRUE;
            $marca = 'CNPJ-' . $CNPJ;
            $CPF = '';
        }
        if ($CFP != '') {
            $flagCPF = TRUE;
            $marca = 'CPF-' . $CPF;
        }
        //se nenhum critério é satisfeito
        if (!($flagIE || $flagCNPJ || $flagCPF)) {
            //erro nao foi passado parametro de filtragem
            $this->errorStatus = TRUE;
            $this->errorMsg = 'Um filtro deve ser indicado CNPJ, CPF ou IE !!!';
            return FALSE;
        }
        //preparação da mensagem SOAP
        $param = array(
            'nfeCabecMsg' => '<?xml version="1.0" encoding="utf-8"?><cabecMsg versao="' . $cabecVer . '" xmlns="' . $this->URLnfe . '"><versaoDados>' . $dataVer . '</versaoDados></cabecMsg>',
            'nfeDadosMsg' => '<consCad><versao>' . $dataVer . '</versao><infCons><xServ>CONS-CAD</xServ><UF>' . $UF . '</UF><IE>' . $IE . '</IE><CNPJ>' . $CNPJ . '</CNPJ><CPF>' . $CPF . '</CPF>' . '</infCons></consCad>'
        );
        //envio da mensagem ao webservice
        $retorno = $this->sendSOAP($param, $wsdl);
        //se houve retorno
        if (is_array($retorno)) {
            //pegar o xml retornado do NuSoap
            $xmlresp = utf8_encode($retorno[$this->aFunctionWdsl[$wsdl] . 'Result']);
            if ($xmlresp == '') {
                //houve uma falha na comunicação SOAP
                return FALSE;
            }
            // tratar dados de retorno
            $doc = new DOMDocument(); //cria objeto DOM
            $doc->formatOutput = false;
            $doc->preserveWhiteSpace = false;
            $doc->loadXML($xmlresp, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            //infCons o xml somente contera um grupo com essa tag
            $this->verAplic = $doc->getElementsByTagName('verAplic')->item(0)->nodeValue;
            $this->cStat = $doc->getElementsByTagName('cStat')->item(0)->nodeValue;
            $this->xMotivo = $doc->getElementsByTagName('xMotivo')->item(0)->nodeValue;
            $this->UF = $doc->getElementsByTagName('UF')->item(0)->nodeValue;
            $this->IE = $doc->getElementsByTagName('IE')->item(0)->nodeValue;
            $this->CNPJ = $doc->getElementsByTagName('CNPJ')->item(0)->nodeValue;
            $this->CPF = $doc->getElementsByTagName('CPF')->item(0)->nodeValue;
            $this->dhCons = $doc->getElementsByTagName('dhCons')->item(0)->nodeValue;
            $this->cUF = $doc->getElementsByTagName('cUF')->item(0)->nodeValue;
            // se foi encontrado cStat = 111 ou 112 com varios estabelecimento com o mesmo IE
            if ($this->cStat == '111' || $this->cStat == '112') {
                $bRet = TRUE;
                $n = 0;
                //pode haver mais de um dado retornado
                $infCad = $doc->getElementsByTagName('infCad');
                foreach ($infCad as $iCad) {
                    $IE = $iCad->getElementsByTagName('IE')->item(0)->nodeValue;
                    $CNPJ = $iCad->getElementsByTagName('CNPJ')->item(0)->nodeValue;
                    $CPF = $iCad->getElementsByTagName('CPF')->item(0)->nodeValue;
                    $UF = $iCad->getElementsByTagName('UF')->item(0)->nodeValue;
                    $cSit = $iCad->getElementsByTagName('cSit')->item(0)->nodeValue;
                    $xNome = $iCad->getElementsByTagName('xNome')->item(0)->nodeValue;
                    $xFant = $iCad->getElementsByTagName('xFant')->item(0)->nodeValue;
                    $xRegApur = $iCad->getElementsByTagName('xRegApur')->item(0)->nodeValue;
                    $CNAE = $iCad->getElementsByTagName('CNAE')->item(0)->nodeValue;
                    $dIniAtiv = $iCad->getElementsByTagName('dIniAtiv')->item(0)->nodeValue;
                    $dUltSit = $iCad->getElementsByTagName('dUltSit')->item(0)->nodeValue;
                    $dBaixa = $iCad->getElementsByTagName('dBaixa')->item(0)->nodeValue;
                    $IEUnica = $iCad->getElementsByTagName('IEUnica')->item(0)->nodeValue;
                    $IEAtual = $iCad->getElementsByTagName('IEAtual')->item(0)->nodeValue;
                    $xLgr = $iCad->getElementsByTagName('xLgr')->item(0)->nodeValue;
                    $nro = $iCad->getElementsByTagName('nro')->item(0)->nodeValue;
                    $xCpl = $iCad->getElementsByTagName('xCpl')->item(0)->nodeValue;
                    $xBairro = $iCad->getElementsByTagName('xBairro')->item(0)->nodeValue;
                    $cMun = $iCad->getElementsByTagName('cMun')->item(0)->nodeValue;
                    $xMun = $iCad->getElementsByTagName('xMun')->item(0)->nodeValue;
                    $CEP = $iCad->getElementsByTagName('CEP')->item(0)->nodeValue;
                    $this->aCad = array($n, array('IE' => $IE, 'CNPJ' => $CNPJ, 'CPF' => $CPF, 'UF' => $UF, 'cSit' => $cSit, 'xNome' => $xNome, 'xFant' => $xFant, 'xRegApur' => $xRegApur, 'CNAE' => $CNAE, 'dIniAtiv' => $dIniAtiv, 'dUltSit' => $dUltSit, 'dBaixa' => $dBaixa, 'IEUnica' => $IEUnica, 'IEAtual' => $IEAtual, 'xLgr' => $xLgr, 'nro' => $nro, 'xCpl' => $xCpl, 'xBairro' => $xBairro, 'cMun' => $cMun, 'xMun' => $xMun, 'CEP' => $CEP));
                    $n++;
                }
            }
            //salvar o xml retornado do SEFAZ
            $nome = $this->temporarioNF . $marca . '.xml';
            $nome = $doc->save($nome);
        } else {
            $this->errorStatus = true;
            $this->errorMsg = 'Nao houve retorno do NuSoap!!';
        }
        return $bRet;
    }

    /*     * ********************************************
     * Envia lote de Notas Fiscais
     * 
     * @param	array   $aNFe notas fiscais em xml uma em cada campo de uma string
     * @param   integer $idLote o id do lote e um numero que deve ser gerado pelo sistema
     *                          a cada envio mesmo que seja de apenas uma NFe usar banco
     *                          de dados
     * @return	boolean	True se aceito o lote ou False de rejeitado
     * @access  public
     * ********************************************** */

    public function enviaNF($aNFe) {
        //variavel de retorno do metodo
        $bRet = false;

        // carga das variaveis da funçao do webservice
        $wsdl = 'NfeRecepcao';
        $cabecXsdfile = $this->aFxsd['CabecMsg'];
        $cabecVer = $this->aVerxsd['CabecMsg'];
        $dataXsdfile = $this->aFxsd[$wsdl];
        $dataVer = $this->aVerxsd[$wsdl];

        // limpa a variavel
        $sNFe = '';

        // monta string com as NFe enviadas
        //$sNFe = implode('',$aNFe);

        $sNFe = $aNFe;

        //remover <?xml version="1.0" encoding=...
        ///$sNFe = str_replace('<?xml version="1.0" encoding="utf-8"?','',$sNFe);
        //ATENÇAO $sNFe nao pode ultrapassar 500kBytes
        if (strlen($sNFe) > 470000) {
            //indicar erro e voltar
            return FALSE;
        }

        /*
          $param = array(
          'nfeCabecMsg'=>'<?xml version="1.0" encoding="utf-8"?><cabecMsg versao="'.$cabecVer.'" xmlns="http://www.portalfiscal.inf.br/nfe"><versaoDados>'.$dataVer.'</versaoDados></cabecMsg>',
          'nfeDadosMsg'=>'<enviNFe  xmlns="'.$this->URLnfe.'" xmlns:ds="'.$this->URLdsig.'" xmlns:xsi="'.$this->URLxsi.' versao="'.$dataVer.'"><idLote>'.$idLote.'</idLote>'.$sNFe
          );
         */

        //retorno e um array contendo a mensagem do SEFAZ
        if ($this->versaoNFe == '1.10') {
            $param = array(
                'nfeCabecMsg' => '<?xml version="1.0" encoding="utf-8"?><cabecMsg versao="' . $cabecVer . '" xmlns="http://www.portalfiscal.inf.br/nfe"><versaoDados>' . $dataVer . '</versaoDados></cabecMsg>',
                'nfeDadosMsg' => $sNFe
            );
            $retorno = $this->sendSOAP($param, $wsdl);
            $_OK = false;
            if (is_array($retorno)) {
                //pega os dados do array retornado pelo NuSoap
                $_OK = true;
                $xmlresp = utf8_encode($retorno[$this->aFunctionWdsl[$wsdl] . 'Result']);
            }
        } else {
            $namespace = 'http://www.portalfiscal.inf.br/nfe/wsdl/NfeRecepcao2';
            $header = '<nfeCabecMsg xmlns="' . $namespace . '"><cUF>' . $this->UFcod . '</cUF><versaoDados>2.00</versaoDados></nfeCabecMsg>';
            //montagem dos dados da mensagem SOAP
            $dados = '<nfeDadosMsg xmlns="' . $namespace . '">' . $sNFe . '</nfeDadosMsg>';
            $retorno = $this->sendSOAP2($dados, $wsdl, $header, 'nfeRecepcaoLote2');
            $_OK = false;
            if ($retorno) {
                //pega os dados do array retornado pelo NuSoap
                $_OK = true;
                $xmlresp = utf8_encode($retorno);
            }
        }

        if ($_OK) {
            if ($xmlresp == '') {
                //houve uma falha na comunicação SOAP
                return FALSE;
            }

            //tratar dados de retorno
            $doc = new DOMDocument(); //cria objeto DOM
            $doc->formatOutput = false;
            $doc->preserveWhiteSpace = false;
            $doc->loadXML($xmlresp, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            $nome = $this->temporarioNF . 'Reposta.xml';
            $doc->save($nome);
            // status do recebimento ou mensagem de erro
            $this->cStat = $doc->getElementsByTagName('cStat')->item(0)->nodeValue;
            //$this->tAmb = $doc->getElementsByTagName('tAmb')->item(0)->nodeValue;
            $this->verAplic = $doc->getElementsByTagName('verAplic')->item(0)->nodeValue;
            $this->xMotivo = $doc->getElementsByTagName('xMotivo')->item(0)->nodeValue;

            // em caso de sucesso  cStat = 103
            if ($this->cStat == '103') {
                // tempo medio de processamento
                $this->tMed = $doc->getElementsByTagName('tMed')->item(0)->nodeValue;
                // data e hora da mensagem
                $this->dhRecbto = $doc->getElementsByTagName('dhRecbto')->item(0)->nodeValue;
                // numero do recibo, se o lote foi aceito
                // guardar o numero do recibo na base de dados pois devera ser usado
                // para verificar o estatus dos Lotes enviados
                $this->nRec = $doc->getElementsByTagName('nRec')->item(0)->nodeValue;
                $bRet = TRUE;
            }
        } else {
            $this->errorStatus = true;
            $this->errorMsg = 'Nao houve retorno do NuSoap!!';
            return false;
        }

        return true;
    }

    /*     * ********************************************
     * Envia lote de CCe
     * 
     * @param	array   $aNFe notas fiscais em xml uma em cada campo de uma string
     * @param   integer $idLote o id do lote e um numero que deve ser gerado pelo sistema
     *                          a cada envio mesmo que seja de apenas uma NFe usar banco
     *                          de dados
     * @return	boolean	True se aceito o lote ou False de rejeitado
     * @access  public
     * ********************************************** */

    public function enviaCC($aCCe) {
        //variavel de retorno do metodo
        $bRet = false;

        // carga das variaveis da funçao do webservice
        $wsdl = 'RecepcaoEvento';
        $cabecXsdfile = $this->aFxsd['CabecMsg'];
        $cabecVer = $this->aVerxsd['CabecMsg'];
        $dataXsdfile = $this->aFxsd[$wsdl];
        $dataVer = $this->aVerxsd[$wsdl];

        // limpa a variavel
        $sCCe = '';

        // monta string com as NFe enviadas
        //$sNFe = implode('',$aNFe);

        $sCCe = $aCCe;

        //remover <?xml version="1.0" encoding=...
        ///$sNFe = str_replace('<?xml version="1.0" encoding="utf-8"?','',$sNFe);
        //ATENÇAO $sNFe nao pode ultrapassar 500kBytes
        if (strlen($sCCe) > 470000) {
            //indicar erro e voltar
            return FALSE;
        }

        /*
          $param = array(
          'nfeCabecMsg'=>'<?xml version="1.0" encoding="utf-8"?><cabecMsg versao="'.$cabecVer.'" xmlns="http://www.portalfiscal.inf.br/nfe"><versaoDados>'.$dataVer.'</versaoDados></cabecMsg>',
          'nfeDadosMsg'=>'<enviNFe  xmlns="'.$this->URLnfe.'" xmlns:ds="'.$this->URLdsig.'" xmlns:xsi="'.$this->URLxsi.' versao="'.$dataVer.'"><idLote>'.$idLote.'</idLote>'.$sNFe
          );
         */

        //retorno e um array contendo a mensagem do SEFAZ

        $namespace = 'http://www.portalfiscal.inf.br/nfe/wsdl/RecepcaoEvento';
        $header = '<nfeCabecMsg xmlns="' . $namespace . '"><cUF>' . $this->UFcod . '</cUF><versaoDados>1.00</versaoDados></nfeCabecMsg>';
        //montagem dos dados da mensagem SOAP
        $dados = '<nfeDadosMsg xmlns="' . $namespace . '">' . $sCCe . '</nfeDadosMsg>';

        $retorno = $this->sendSOAP2($dados, $wsdl, $header, 'nfeRecepcaoEvento');
        $_OK = false;
        if ($retorno) {
            //pega os dados do array retornado pelo NuSoap
            $_OK = true;
            $xmlresp = utf8_encode($retorno);
        }

        if ($_OK) {
            if ($xmlresp == '') {
                //houve uma falha na comunicação SOAP
                return FALSE;
            }

            //tratar dados de retorno
            $doc = new DOMDocument(); //cria objeto DOM
            $doc->formatOutput = false;
            $doc->preserveWhiteSpace = false;
            $doc->loadXML($xmlresp, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            $nome = $this->temporarioNF . 'Reposta.xml';
            $doc->save($nome);
            // status do recebimento ou mensagem de erro
            $this->cStat = $doc->getElementsByTagName('cStat')->item(0)->nodeValue;
            //$this->tAmb = $doc->getElementsByTagName('tAmb')->item(0)->nodeValue;
            $this->verAplic = $doc->getElementsByTagName('verAplic')->item(0)->nodeValue;
            $this->xMotivo = $doc->getElementsByTagName('xMotivo')->item(0)->nodeValue;

            // em caso de sucesso  cStat = 103
            if ($this->cStat == '128') {
                $this->cStat = $doc->getElementsByTagName('cStat')->item(1)->nodeValue;
                $this->xMotivo = $doc->getElementsByTagName('xMotivo')->item(1)->nodeValue;

                if ($this->cStat == '135') {
                    // data e hora da mensagem
                    $this->dhRecbto = $doc->getElementsByTagName('dhRecbto')->item(0)->nodeValue;
                    // numero do recibo, se o lote foi aceito
                    // guardar o numero do recibo na base de dados pois devera ser usado
                    // para verificar o estatus dos Lotes enviados
                    $this->nProt = $doc->getElementsByTagName('nProt')->item(0)->nodeValue;
                    $bRet = TRUE;
                }
            }
        } else {
            $this->errorStatus = true;
            $this->errorMsg = 'Nao houve retorno do NuSoap!!';
            return false;
        }

        return true;
    }

    /*     * ********************************************
     * Solicita resposta do lote de Notas Fiscais
     * FUNCIONAL!!
     * @param	string   $recibo numero do recibo do envio do lote
     * @return	boolean  True se sucesso false se falha
     * @access  public
     * ********************************************** */

    public function retornoNF($recibo) {

        //variavel de retorno do metodo
        $bRet = FALSE;

        // carga das variaveis da funçao do webservice
        $wsdl = 'NfeRetRecepcao';
        $cabecXsdfile = $this->aFxsd['CabecMsg'];
        $cabecVer = $this->aVerxsd['CabecMsg'];
        $dataXsdfile = $this->aFxsd[$wsdl];
        $dataVer = $this->aVerxsd[$wsdl];

        if ($this->versaoNFe == '1.10') {
            $param = array(
                'nfeCabecMsg' => '<?xml version="1.0" encoding="utf-8"?><cabecMsg versao="' . $cabecVer . '" xmlns="' . $this->URLnfe . '"><versaoDados>' . $dataVer . '</versaoDados></cabecMsg>',
                'nfeDadosMsg' => '<consReciNFe xmlns:xsi="' . $this->URLxsi . '" xmlns:xsd="' . $this->URLxsd . '" versao="' . $dataVer . '" xmlns="' . $this->URLnfe . '"><tpAmb>' . $this->ambiente . '</tpAmb><nRec>' . $recibo . '</nRec></consReciNFe>'
            );
            //trigger_error(print_r($param), E_USER_ERROR);
            $retorno = $this->sendSOAP($param, $wsdl);
            $_OK = false;
            if (is_array($retorno)) {
                //pega os dados do array retornado pelo NuSoap
                $_OK = true;
                $xmlresp = utf8_encode($retorno[$this->aFunctionWdsl[$wsdl] . 'Result']);
            }
        } else {
            $namespace = 'http://www.portalfiscal.inf.br/nfe/wsdl/NfeRetRecepcao2';
            $header = '<nfeCabecMsg xmlns="' . $namespace . '"><cUF>' . $this->UFcod . '</cUF><versaoDados>2.00</versaoDados></nfeCabecMsg>';
            //montagem dos dados da mensagem SOAP
            $dados = '<nfeDadosMsg xmlns="' . $namespace . '"><consReciNFe xmlns="http://www.portalfiscal.inf.br/nfe" versao="2.00"><tpAmb>' . $this->ambiente . '</tpAmb><nRec>' . $recibo . '</nRec></consReciNFe></nfeDadosMsg>';
            $retorno = $this->sendSOAP2($dados, $wsdl, $header, 'nfeRetRecepcao2');
            $_OK = false;
            if ($retorno) {
                //pega os dados do array retornado pelo NuSoap
                $_OK = true;
                $xmlresp = utf8_encode($retorno);
            }
        }

        if ($_OK) {
            if ($xmlresp == '') {
                //houve uma falha na comunicação SOAP
                return FALSE;
            }

            // tratar dados de retorno
            $doc = new DOMDocument(); //cria objeto DOM
            $doc->formatOutput = false;
            $doc->preserveWhiteSpace = false;
            $doc->loadXML($xmlresp, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            // status do recebimento ou mensagem de erro
            $nome = $this->temporarioNF . 'Recibo.xml';
            $doc->save($nome);
            $this->cStat = $doc->getElementsByTagName('cStat')->item(0)->nodeValue;
            // motivo do status
            $this->xMotivo = $doc->getElementsByTagName('xMotivo')->item(0)->nodeValue;
            // tipo de ambiente da comunicaçao
            //$this->tpAmb = $doc->getElementsByTagName('tpAmb')->item(0)->nodeValue;
            //versao do aplicativa que processou a mensagem
            $this->verAplic = $doc->getElementsByTagName('verAplic')->item(0)->nodeValue;
            // numero do recibo, consultado
            $this->nRec = $doc->getElementsByTagName('nRec')->item(0)->nodeValue;
            //caso o status da resposta seja 104 pegar os outros dados
            if ($this->cStat == '104') {
                // houve retorno com notas aceitas
                $bRet = TRUE;
                // para controlar as interaçoes
                $n = 0;
                // vai haver um grupo protNFe para cada NF enviada no lote
                $this->aNFe = array();
                $protNFe = $doc->getElementsByTagName('protNFe');
                foreach ($protNFe as $pNFe) {
                    //$versao = $pNFe->getElementsByTagName('versao')->item(0)->nodeValue;
                    $nNFe = $pNFe->getElementsByTagName('infProt')->item(0);
                    //extrai o id da tag
                    $id = trim($nNFe->getAttribute("Id"));
                    //$tpAmb = $pNFe->getElementsByTagName('tpAmb')->item(0);
                    $verAplic = $pNFe->getElementsByTagName('verAplic')->item(0)->nodeValue;
                    $chNFe = $pNFe->getElementsByTagName('chNFe')->item(0)->nodeValue;
                    $dhRecbto = $pNFe->getElementsByTagName('dhRecbto')->item(0)->nodeValue;
                    $digVal = $pNFe->getElementsByTagName('digVal')->item(0)->nodeValue;
                    $cStat = $pNFe->getElementsByTagName('cStat')->item(0)->nodeValue;

                    if ($cStat == '100') {
                        $nProt = $pNFe->getElementsByTagName('nProt')->item(0)->nodeValue;
                    } else {
                        $nProt = '';
                    }

                    $xMotivo = $pNFe->getElementsByTagName('xMotivo')->item(0)->nodeValue;
                    $this->aNFe = array($n, array('chNFe' => $chNFe, 'cStat' => $cStat, 'xMotivo' => $xMotivo, 'nProt' => $nProt, 'digVal' => $digVal, 'dhRecbto' => $dhRecbto, 'Id' => $id));
                    $n++;
                }
            }
            //salvar o xml retornado do SEFAZ
            $nome = $this->validadasNF . $recibo . '-REC.xml';
            $nome = $doc->save($nome);
        } else {
            $this->errorStatus = true;
            $this->errorMsg = 'Nao houve retorno do NuSoap!!';
            return false;
        }
        return true;
    }

    private function strzero($n, $tamanho) {
        $conteudo = (string) $n;
        $diferenca = $tamanho - strlen($conteudo);
        if ($diferenca > 0)
            for ($i = 0; $i < $diferenca; $i++)
                $conteudo = '0' . $conteudo;
        return $conteudo;
    }

    /*     * ********************************************
     * Solicita inutilizaçao de uma serie de numeros de NF
     *
     * @param	string  $ano
     * @param   string  $nfSerie
     * @param   integer $numIni
     * @param   integer $numFim
     * @return	boolean TRUE se sucesso FALSE se falha
     * @access  public
     * ********************************************** */

    public function inutilizaNF($ano, $nfSerie, $modelo, $numIni, $numFim, $CNPJ, $xJust, $path) {
        //variavel de retorno
        $bRet = FALSE;
        // carga das variaveis da funçao do webservice
        //$wsdl='NfeInutilizacao';
        $wsdl = 'NfeInutilizacao';
        $cabecXsdfile = $this->aFxsd['CabecMsg'];
        $cabecVer = $this->aVerxsd['CabecMsg'];
        $dataXsdfile = $this->aFxsd[$wsdl];
        $dataVer = $this->aVerxsd[$wsdl];

        //Identificador da TAG a ser assinada formada
        //com Código da UF + CNPJ + modelo + série +
        //nro inicial e nro final precedida do literal “ID”
        //$id = 'ID'.$this->UFcod.$this->CNPJ.$modelo.$nfSerie.$numIni.$numFim;
        //$id = 'ID'.$this->UFcod.$ano.$CNPJ.$modelo.$nfSerie.$numIni.$numFim;
        $id = 'ID' . $this->UFcod . $ano . $CNPJ . $modelo . $this->strzero($nfSerie, 3) . $this->strzero($numIni, 9) . $this->strzero($numFim, 9);
        //dados da mensagem
        //$nfeDadosMsg = '<inutNFe xmlns="'.$this->URLnfe.'" versao="'.$dataVer.'"><infInut Id="'.$id.'"><tpAmb>'.$this->ambiente.'</tpAmb><xServ>INUTILIZAR</xServ><cUF>'.$this->UFcod.'</cUF><ano>'.$ano.'</ano><CNPJ>'.$CNPJ.'</CNPJ><mod>'.$modelo.'</mod><serie>'.$nfSerie.'</serie><nNFIni>'.$numIni.'</nNFIni><nNFFin>'.$numFim.'</nNFFin><xJust>'.$xJust.'</xJust></infInut></inutNFe>';
        $nfeDadosMsg = '<inutNFe xmlns="' . $this->URLnfe . '" versao="2.00"><infInut Id="' . $id . '"><tpAmb>' . $this->ambiente . '</tpAmb><xServ>INUTILIZAR</xServ><cUF>' . $this->UFcod . '</cUF><ano>' . $ano . '</ano><CNPJ>' . $CNPJ . '</CNPJ><mod>' . $modelo . '</mod><serie>' . $nfSerie . '</serie><nNFIni>' . $numIni . '</nNFIni><nNFFin>' . $numFim . '</nNFFin><xJust>' . $xJust . '</xJust></infInut></inutNFe>';
        $nfeDadosMsg = $this->assina($nfeDadosMsg, 'infInut');
        $nfeDadosMsg = str_replace('<?xml version="1.0"?>', '', $nfeDadosMsg);
        /* $nfeDadosMsg = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>" . $nfeDadosMsg; */


        $xmlFile = $this->temporarioNF . 'inutiliza_teste.xml';
        $f = fopen($xmlFile, 'w+');
        fwrite($f, $nfeDadosMsg);
        fclose($f);


        //$this->validaXML($nfeDadosMsg, 'C:/Fontes/NFe/Schemas/inutNFe_v1.07.xsd');
        $this->validaXML($nfeDadosMsg, $path . '/Schemas/inutNFe_v2.00.xsd');

        if ($this->errorStatus) {
            foreach ($this->errorMsg as $erro) {
                echo $erro . '<br>';
            }
        }
        //trigger_error('', E_USER_ERROR);

        /* $param = array(
          'nfeCabecMsg'=>'<?xml version="1.0" encoding="utf-8"?><cabecMsg versao="1.02" xmlns="http://www.portalfiscal.inf.br/nfe"><versaoDados>'.$dataVer.'</versaoDados></cabecMsg>',
          'nfeDadosMsg'=>$nfeDadosMsg
          );

          $retorno = $this->sendSOAP($param, $wsdl); */

        # Marcio
        //retorno e um array contendo a mensagem do SEFAZ
        if ($this->versaoNFe == '1.10') {
            $param = array(
                'nfeCabecMsg' => '<?xml version="1.0" encoding="utf-8"?><cabecMsg versao="' . $cabecVer . '" xmlns="http://www.portalfiscal.inf.br/nfe"><versaoDados>' . $dataVer . '</versaoDados></cabecMsg>',
                'nfeDadosMsg' => $sNFe
            );
            $retorno = $this->sendSOAP($param, $wsdl);
            $_OK = false;
            if (is_array($retorno)) {
                //pega os dados do array retornado pelo NuSoap
                $_OK = true;
                $xmlresp = utf8_encode($retorno[$this->aFunctionWdsl[$wsdl] . 'Result']);
            }
        } else {
            $namespace = 'http://www.portalfiscal.inf.br/nfe/wsdl/NfeInutilizacao2';
            $header = '<nfeCabecMsg xmlns="' . $namespace . '"><cUF>' . $this->UFcod . '</cUF><versaoDados>2.00</versaoDados></nfeCabecMsg>';
            //montagem dos dados da mensagem SOAP
            $dados = '<nfeDadosMsg xmlns="' . $namespace . '">' . $nfeDadosMsg . '</nfeDadosMsg>';
            $retorno = $this->__sendSOAP2($this->aURLwsdl[$wsdl], $namespace, $header, $dados, 'nfeInutilizacaoNF2', $this->tpAmb);
            //print_r($retorno);

            $xmlFile = $this->temporarioNF . 'Retorno.xml';
            $f = fopen($xmlFile, 'w+');
            fwrite($f, $retorno);
            fclose($f);

            $_OK = false;
            if ($retorno) {
                //pega os dados do array retornado pelo NuSoap
                $_OK = true;
                $xmlresp = utf8_encode($retorno);
                //echo '<pre>'.$xmlresp.'</pre>';
            }
        }
        # Marcio

        if ($_OK) {
            $xmlresp = utf8_encode($retorno[$this->aFunctionWdsl[$wsdl] . 'Result']);
            if ($xmlresp == '') {
                //houve uma falha na comunicação SOAP
                return FALSE;
            }

            // tratar dados de retorno
            $doc = new DOMDocument(); //cria objeto DOM
            $doc->formatOutput = false;
            $doc->preserveWhiteSpace = false;
            $doc->loadXML($xmlresp, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            $nome = $this->temporarioNF . 'Inutiliza.xml';
            $doc->save($nome);
            //$this->versao = $doc->getElementsByTagName('versao')->item(0)->nodeValue;
            $infInut = $doc->getElementsByTagName('infInut');
            //extrai o id da tag
            //$id = trim($infInut->getAttribute("Id"));

            $this->tpAmb = $doc->getElementsByTagName('tpAmb')->item(0)->nodeValue;
            $this->verAplic = $doc->getElementsByTagName('verAplic')->item(0)->nodeValue;
            $this->cStat = $doc->getElementsByTagName('cStat')->item(0)->nodeValue;
            $this->xMotivo = $doc->getElementsByTagName('xMotivo')->item(0)->nodeValue;
            $this->cUF = $doc->getElementsByTagName('cUF')->item(0)->nodeValue;

            if ($this->cStat == '102') {
                $bRet = TRUE;
                $this->ano = $doc->getElementsByTagName('ano')->item(0)->nodeValue;
                $this->CNPJ = $doc->getElementsByTagName('CNPJ')->item(0)->nodeValue;
                $this->modelo = $doc->getElementsByTagName('mod')->item(0)->nodeValue;
                $this->serie = $doc->getElementsByTagName('serie')->item(0)->nodeValue;
                $this->nNFIni = $doc->getElementsByTagName('nNFIni')->item(0)->nodeValue;
                $this->nNFFin = $doc->getElementsByTagName('nNFFin')->item(0)->nodeValue;
                $this->dhRecbto = $doc->getElementsByTagName('dhRecbto')->item(0)->nodeValue;
                $this->nProt = $doc->getElementsByTagName('nProt')->item(0)->nodeValue;
            }
        } else {
            $this->errorStatus = true;
            $this->errorMsg = 'Nao houve retorno do NuSoap!!';
        }
        return $bRet;
    }

    /*     * ********************************************
     * Solicita o cancelamento de NF enviada
     *
     * @param	string  $idNFe ID da NFe com 44 digitos (sem o NFe na frente dos numeros)
     * @param   string  $protId Numero do protocolo de aceitaçao da NFe enviado anteriormente pelo SEFAZ
     * @return	boolean TRUE se sucesso ou FALSE se falha
     * @access  public
     * ********************************************** */

    public function cancelaNF($idNFe, $protId, $xJust) {
        //variavel de retorno
        $bRet = FALSE;
        // carga das variaveis da funçao do webservice
        $wsdl = 'NfeCancelamento';
        $cabecXsdfile = $this->aFxsd['CabecMsg'];
        $cabecVer = $this->aVerxsd['CabecMsg'];
        $dataXsdfile = $this->aFxsd[$wsdl];
        $dataVer = $this->aVerxsd[$wsdl];

        if ($this->versaoNFe == '1.10') {
            $nfeDadosMsg = '<cancNFe xmlns="' . $this->URLnfe . '" versao="' . $dataVer . '"><infCanc Id="ID' . $idNFe . '"><tpAmb>' . $this->ambiente . '</tpAmb><xServ>CANCELAR</xServ><chNFe>' . $idNFe . '</chNFe><nProt>' . $protId . '</nProt><xJust>' . $xJust . '</xJust></infCanc></cancNFe>';
            $nfeDadosMsg = $this->assina($nfeDadosMsg, 'infCanc');
            $nfeDadosMsg = str_replace('<?xml version="1.0"?>', '', $nfeDadosMsg);
            $nfeDadosMsg = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" . $nfeDadosMsg;

            $param = array(
                'nfeCabecMsg' => '<?xml version="1.0" encoding="utf-8"?><cabecMsg versao="1.02" xmlns="http://www.portalfiscal.inf.br/nfe"><versaoDados>' . $dataVer . '</versaoDados></cabecMsg>',
                'nfeDadosMsg' => $nfeDadosMsg
            );

            $retorno = $this->sendSOAP($param, $wsdl);
            $_OK = false;
            if (is_array($retorno)) {
                //pega os dados do array retornado pelo NuSoap
                $_OK = true;
                $xmlresp = utf8_encode($retorno[$this->aFunctionWdsl[$wsdl] . 'Result']);
            }
        } else {
            $namespace = 'http://www.portalfiscal.inf.br/nfe/wsdl/NfeCancelamento2';
            $header = '<nfeCabecMsg xmlns="' . $namespace . '"><cUF>' . $this->UFcod . '</cUF><versaoDados>2.00</versaoDados></nfeCabecMsg>';
            //montagem dos dados da mensagem SOAP
            $dXML = '<infCanc Id="ID' . $idNFe . '"><tpAmb>' . $this->ambiente . '</tpAmb><xServ>CANCELAR</xServ><chNFe>' . $idNFe . '</chNFe><nProt>' . $protId . '</nProt><xJust>' . $xJust . '</xJust></infCanc>';
            $dados = '<cancNFe xmlns="http://www.portalfiscal.inf.br/nfe" versao="2.00">' . $dXML . '</cancNFe>';
            $dados = $this->assina($dados, 'infCanc');
            $dados = str_replace('<?xml version="1.0"?>', '', $dados);
            $dados = '<nfeDadosMsg xmlns="' . $namespace . '">' . $dados . '</nfeDadosMsg>';
            $retorno = $this->sendSOAP2($dados, $wsdl, $header, 'nfeCancelamentoNF2');
            $_OK = false;
            if ($retorno) {
                //pega os dados do array retornado pelo NuSoap
                $_OK = true;
                $xmlresp = utf8_encode($retorno);
            }
        }

        if ($_OK) {
            if ($xmlresp == '') {
                //houve uma falha na comunicação SOAP
                return FALSE;
            }

            // tratar dados de retorno
            $doc = new DOMDocument(); //cria objeto DOM
            $doc->formatOutput = false;
            $doc->preserveWhiteSpace = false;
            $doc->loadXML($xmlresp, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            $nome = $this->canceladasNF . $idNFe . '.xml';
            $doc->save($nome);
            //$this->versao = $doc->getElementsByTagName('versao')->item(0)->nodeValue;
            $infCanc = $doc->getElementsByTagName('infCanc');
            //extrai o id da tag
            //$id = trim($infCanc->getAttribute("Id"));
            //$this->tpAmb = $doc->getElementsByTagName('tpAmb')->item(0)->nodeValue;
            $this->verAplic = $doc->getElementsByTagName('verAplic')->item(0)->nodeValue;
            $this->cStat = $doc->getElementsByTagName('cStat')->item(0)->nodeValue;
            $this->xMotivo = $doc->getElementsByTagName('xMotivo')->item(0)->nodeValue;
            $this->cUF = $doc->getElementsByTagName('cUF')->item(0)->nodeValue;

            if ($this->cStat == '101') {
                $bRet = TRUE;
                $this->chNFe = $doc->getElementsByTagName('chNFe')->item(0)->nodeValue;
                $this->dhRecbto = $doc->getElementsByTagName('dhRecbto')->item(0)->nodeValue;
                $this->nProt = $doc->getElementsByTagName('nProt')->item(0)->nodeValue;
            }
        } else {
            $this->errorStatus = true;
            $this->errorMsg = 'Nao houve retorno do NuSoap!!';
            return false;
        }
        return true;
    }

    /**
     * Solicita dados de situaçao de NF
     * FUNCIONAL !!
     * @param	string   $idNFe numerico com 44 digitos
     * @return	mixed	response from SOAP call
     * @access  public
     * */
    public function consultaNF($idNFe) {
        //variavelde retorno do metodo
        $bRet = FALSE;
        // carga das variaveis da funçao do webservice
        $wsdl = 'NfeConsultaNF';
        $cabecXsdfile = $this->aFxsd['CabecMsg'];
        $cabecVer = $this->aVerxsd['CabecMsg'];
        $dataXsdfile = $this->aFxsd[$wsdl];
        $dataVer = $this->aVerxsd[$wsdl];

        $param = array(
            'nfeCabecMsg' => '<?xml version="1.0" encoding="utf-8"?><cabecMsg versao="' . $cabecVer . '" xmlns="' . $this->URLnfe . '"><versaoDados>' . $dataVer . '</versaoDados></cabecMsg>',
            'nfeDadosMsg' => '<consSitNFe xmlns:xsi="' . $this->URLxsi . '" xmlns:xsd="' . $this->URLxsd . '" versao="' . $dataVer . '" xmlns="' . $this->URLnfe . '"><tpAmb>' . $this->ambiente . '</tpAmb><xServ>CONSULTAR</xServ><chNFe>' . $idNFe . '</chNFe></consSitNFe>'
        );

        $retorno = $this->sendSOAP($param, $wsdl);

        if (is_array($retorno)) {

            $xmlresp = utf8_encode($retorno[$this->aFunctionWdsl[$wsdl] . 'Result']);
            if ($xmlresp == '') {
                //houve uma falha na comunicação SOAP
                return FALSE;
            }

            // tratar dados de retorno
            $doc = new DOMDocument(); //cria objeto DOM
            $doc->formatOutput = false;
            $doc->preserveWhiteSpace = false;
            $doc->loadXML($xmlresp, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);

            //$this->versao = $doc->getElementsByTagName('versao')->item(0)->nodeValue;

            $this->tpAmb = $doc->getElementsByTagName('tpAmb')->item(0)->nodeValue;
            $this->verAplic = $doc->getElementsByTagName('verAplic')->item(0)->nodeValue;
            $this->cStat = $doc->getElementsByTagName('cStat')->item(0)->nodeValue;
            $this->xMotivo = $doc->getElementsByTagName('xMotivo')->item(0)->nodeValue;
            $this->cUF = $doc->getElementsByTagName('cUF')->item(0)->nodeValue;

            if ($this->cStat == '100' || $this->cStat == '101' || $this->cStat == '110') {
                $bRet = TRUE;
                $this->chNFe = $doc->getElementsByTagName('chNFe')->item(0)->nodeValue;
                $this->digVal = $doc->getElementsByTagName('digVal')->item(0)->nodeValue;
                $this->dhRecbto = $doc->getElementsByTagName('dhRecbto')->item(0)->nodeValue;
                $this->nProt = $doc->getElementsByTagName('nProt')->item(0)->nodeValue;
            }
            //salvar o xml retornado do SEFAZ
            $nome = $this->consultadasNF . $idNFe . '-PROT.xml';
            $nome = $doc->save($nome);
        } else {
            $this->errorStatus = true;
            $this->errorMsg = 'Nao houve retorno do NuSoap!!';
        }
        return $bRet;
    }

    /**
     * Gera arquivo pdf para impressao de NF-e
     *
     * @param	string   $idNFe
     * @return
     * @access  public
     *
     * TODO
     * Tudo  quem se habilita?
     * */
    public function imprimeNF($idNFe) {
        
    }

    /**
     * Métodos Privados da Classe
     */

    /**
     * Estabelece comunicaçao com servidor SOAP
     * FUNCIONAL !!! 
     * @param    array   $param Matriz com o cabeçalho e os dados da mensagem soap
     * @param    string  $wsdl Designaçao do Serviço SOAP
     * @return   mixed  Array com a resposta do SOAP ou String do erro ou false
     * @access   private
     * */
    private function sendSOAP($param, $wsdl, $header = null) {
        try {

            //monta a url do serviço
            $URL = $this->aURLwsdl[$wsdl] . '?WSDL';
            //trigger_error($URL, E_USER_ERROR);
            //inicia a conexao SOAP
            $client = new nusoap_client($URL, true);
            $client->authtype = 'certificate';
            $client->soap_defencoding = 'UTF-8';

            //Seta parametros para a conexao segura
            $client->certRequest['sslkeyfile'] = $this->pathKey;
            $client->certRequest['sslcertfile'] = $this->pathCert;
            $client->certRequest['passphrase'] = $this->passPhrase;
            $client->certRequest['verifypeer'] = false;
            $client->certRequest['verifyhost'] = false;
            $client->certRequest['trace'] = 1;
        }

        //em caso de erro retorne o mesmo
        catch (Exception $ex) {
            if (is_bool($client->getError())) {
                $this->errorStatus = False;
                $this->errorMsg = '';
            } else {
                $this->errorStatus = True;
                $this->errorMsg = $client->getError();
            }
        }

        // chama a funçao do webservice, passando os parametros
        if ($header == null) {
            $result = $client->call($this->aFunctionWdsl[$wsdl], $param);
        } else {
            $result = $client->call($this->aFunctionWdsl[$wsdl], $param, 'http://tempuri.org', '', $header);
        }

        $this->debug_str = htmlspecialchars($client->debug_str);
        //echo $this->debug_str;
        //trigger_error('erro', E_USER_ERROR);
        // retorna o resultado da comunicaçao  
        return $result;
    }

    protected function __sendSOAP2($urlsefaz,$namespace,$cabecalho,$dados,$metodo,$ambiente='',$UF=''){
        if ($urlsefaz == ''){
            //não houve retorno
            $this->errMsg = "URL do webservice não disponível.\n";
            $this->errStatus = true;
        }
        if ($ambiente == ''){
            $ambiente = $this->tpAmb;
        }
        $data = '';
        $data .= '<?xml version="1.0" encoding="utf-8"?>';
        $data .= '<soap12:Envelope ';
        $data .= 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
        $data .= 'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ';
        $data .= 'xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">';
        $data .= '<soap12:Header>';
        $data .= $cabecalho;
        $data .= '</soap12:Header>';
        $data .= '<soap12:Body>';
        $data .= $dados;
        $data .= '</soap12:Body>';
        $data .= '</soap12:Envelope>';
        
        $xmlFile = $this->temporarioNF . 'inutiliza_envio.xml';
        $f = fopen($xmlFile, 'w+');
        fwrite($f, $data);
        fclose($f);        
        
        //[Informational 1xx]
        $cCode['100']="Continue";
        $cCode['101']="Switching Protocols";
        //[Successful 2xx]
        $cCode['200']="OK";
        $cCode['201']="Created";
        $cCode['202']="Accepted";
        $cCode['203']="Non-Authoritative Information";
        $cCode['204']="No Content";
        $cCode['205']="Reset Content";
        $cCode['206']="Partial Content";
        //[Redirection 3xx]
        $cCode['300']="Multiple Choices";
        $cCode['301']="Moved Permanently";
        $cCode['302']="Found";
        $cCode['303']="See Other";
        $cCode['304']="Not Modified";
        $cCode['305']="Use Proxy";
        $cCode['306']="(Unused)";
        $cCode['307']="Temporary Redirect";
        //[Client Error 4xx]
        $cCode['400']="Bad Request";
        $cCode['401']="Unauthorized";
        $cCode['402']="Payment Required";
        $cCode['403']="Forbidden";
        $cCode['404']="Not Found";
        $cCode['405']="Method Not Allowed";
        $cCode['406']="Not Acceptable";
        $cCode['407']="Proxy Authentication Required";
        $cCode['408']="Request Timeout";
        $cCode['409']="Conflict";
        $cCode['410']="Gone";
        $cCode['411']="Length Required";
        $cCode['412']="Precondition Failed";
        $cCode['413']="Request Entity Too Large";
        $cCode['414']="Request-URI Too Long";
        $cCode['415']="Unsupported Media Type";
        $cCode['416']="Requested Range Not Satisfiable";
        $cCode['417']="Expectation Failed";
        //[Server Error 5xx]
        $cCode['500']="Internal Server Error";
        $cCode['501']="Not Implemented";
        $cCode['502']="Bad Gateway";
        $cCode['503']="Service Unavailable";
        $cCode['504']="Gateway Timeout";
        $cCode['505']="HTTP Version Not Supported";
        $tamanho = strlen($data);
        $parametros = Array('Content-Type: application/soap+xml;charset=utf-8;action="'.$namespace."/".$metodo.'"','SOAPAction: "'.$metodo.'"',"Content-length: $tamanho");
        $_aspa = '"';
        $oCurl = curl_init();
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($oCurl, CURLOPT_URL, $urlsefaz.'');
        curl_setopt($oCurl, CURLOPT_PORT , 443);
        curl_setopt($oCurl, CURLOPT_VERBOSE, 1);
        curl_setopt($oCurl, CURLOPT_HEADER, 1); //retorna o cabeçalho de resposta
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 3);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($oCurl, CURLOPT_SSLCERT, $this->pathCert);
        curl_setopt($oCurl, CURLOPT_SSLKEY, $this->pathKey);
        curl_setopt($oCurl, CURLOPT_POST, 1);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER,$parametros);
        $__xml = curl_exec($oCurl);
        $info = curl_getinfo($oCurl); //informações da conexão
        $txtInfo ="";
        $txtInfo .= "URL=$info[url]\n";
        $txtInfo .= "Content type=$info[content_type]\n";
        $txtInfo .= "Http Code=$info[http_code]\n";
        $txtInfo .= "Header Size=$info[header_size]\n";
        $txtInfo .= "Request Size=$info[request_size]\n";
        $txtInfo .= "Filetime=$info[filetime]\n";
        $txtInfo .= "SSL Verify Result=$info[ssl_verify_result]\n";
        $txtInfo .= "Redirect Count=$info[redirect_count]\n";
        $txtInfo .= "Total Time=$info[total_time]\n";
        $txtInfo .= "Namelookup=$info[namelookup_time]\n";
        $txtInfo .= "Connect Time=$info[connect_time]\n";
        $txtInfo .= "Pretransfer Time=$info[pretransfer_time]\n";
        $txtInfo .= "Size Upload=$info[size_upload]\n";
        $txtInfo .= "Size Download=$info[size_download]\n";
        $txtInfo .= "Speed Download=$info[speed_download]\n";
        $txtInfo .= "Speed Upload=$info[speed_upload]\n";
        $txtInfo .= "Download Content Length=$info[download_content_length]\n";
        $txtInfo .= "Upload Content Length=$info[upload_content_length]\n";
        $txtInfo .= "Start Transfer Time=$info[starttransfer_time]\n";
        $txtInfo .= "Redirect Time=$info[redirect_time]\n";
        $txtInfo .= "Certinfo=$info[certinfo]\n";
        $n = strlen($__xml);
        $x = stripos($__xml, "<");
        $xml = substr($__xml, $x, $n-$x);
        $this->soapDebug = $data."\n\n".$txtInfo."\n".$__xml;
        if ($__xml === false){
            //não houve retorno
            $this->errMsg = curl_error($oCurl) . $info['http_code'] . $cCode[$info['http_code']]."\n";
            $this->errStatus = true;
        } else {
            //houve retorno mas ainda pode ser uma mensagem de erro do webservice
            $this->errMsg = $info['http_code'] . $cCode[$info['http_code']]."\n";
            $this->errStatus = false;
        }
        curl_close($oCurl);
        return $xml;
    }    
    
    private function sendSOAP2($param, $wsdl, $headerX = null, $metodoX = null) {
        /*
          use_soap_error_handler(true);
          $options = array(
          'encoding'      => 'UTF-8',
          'verifypeer'    => false,
          'verifyhost'    => false,
          'soap_version'  => SOAP_1_2,
          'style'         => SOAP_DOCUMENT,
          'use'           => SOAP_LITERAL,
          'local_cert'    => $this->certKEY,
          'trace'         => true,
          'compression'   => 0,
          'exceptions'    => true,
          'cache_wsdl'    => WSDL_CACHE_NONE
          );
          $URL = $this->aURLwsdl[$wsdl].'?WSDL';
          $this->soapDebug = $this->aURLwsdl[$wsdl];

          $oSoapClient = new NFeSOAP2Client($URL,$options);
          trigger_error($URL, E_USER_ERROR);
          $varCabec = new SoapVar($headerX,XSD_ANYXML);
          $namespace = str_replace(".asmx", "", $this->aURLwsdl[$wsdl]);
          $header = new SoapHeader($namespace,'nfeCabecMsg',$varCabec);
          $varBody = new SoapVar($param,XSD_ANYXML);
          //faz a chamada ao metodo do webservices
          $method = $wsdl . '2';

          $resp = $oSoapClient->__soapCall($method, array($varBody) );
          if (is_soap_fault($resp)) {
          $soapFault = "SOAP Fault: (faultcode: {$resp->faultcode}, faultstring: {$resp->faultstring})";
          }
          $resposta = $oSoapClient->__getLastResponse();
          $this->soapDebug .= "\n" . $soapFault;
          $this->soapDebug .= "\n" . $oSoapClient->__getLastRequestHeaders();
          $this->soapDebug .= "\n" . $oSoapClient->__getLastRequest();
          $this->soapDebug .= "\n" . $oSoapClient->__getLastResponseHeaders();
          $this->soapDebug .= "\n" . $oSoapClient->__getLastResponse();

          return $resposta;

         */

        $data = '';
        $data .= '<?xml version="1.0" encoding="utf-8"?>';
        $data .= '<soap12:Envelope ';
        $data .= 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
        $data .= 'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ';
        $data .= 'xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">';
        $data .= '<soap12:Header>';
        $data .= $headerX;
        $data .= '</soap12:Header>';
        $data .= '<soap12:Body>';
        $data .= $param;
        $data .= '</soap12:Body>';
        $data .= '</soap12:Envelope>';
                     
        //[Informational 1xx]
        $cCode['100'] = "Continue";
        $cCode['101'] = "Switching Protocols";
        //[Successful 2xx]
        $cCode['200'] = "OK";
        $cCode['201'] = "Created";
        $cCode['202'] = "Accepted";
        $cCode['203'] = "Non-Authoritative Information";
        $cCode['204'] = "No Content";
        $cCode['205'] = "Reset Content";
        $cCode['206'] = "Partial Content";
        //[Redirection 3xx]
        $cCode['300'] = "Multiple Choices";
        $cCode['301'] = "Moved Permanently";
        $cCode['302'] = "Found";
        $cCode['303'] = "See Other";
        $cCode['304'] = "Not Modified";
        $cCode['305'] = "Use Proxy";
        $cCode['306'] = "(Unused)";
        $cCode['307'] = "Temporary Redirect";
        //[Client Error 4xx]
        $cCode['400'] = "Bad Request";
        $cCode['401'] = "Unauthorized";
        $cCode['402'] = "Payment Required";
        $cCode['403'] = "Forbidden";
        $cCode['404'] = "Not Found";
        $cCode['405'] = "Method Not Allowed";
        $cCode['406'] = "Not Acceptable";
        $cCode['407'] = "Proxy Authentication Required";
        $cCode['408'] = "Request Timeout";
        $cCode['409'] = "Conflict";
        $cCode['410'] = "Gone";
        $cCode['411'] = "Length Required";
        $cCode['412'] = "Precondition Failed";
        $cCode['413'] = "Request Entity Too Large";
        $cCode['414'] = "Request-URI Too Long";
        $cCode['415'] = "Unsupported Media Type";
        $cCode['416'] = "Requested Range Not Satisfiable";
        $cCode['417'] = "Expectation Failed";
        //[Server Error 5xx]
        $cCode['500'] = "Internal Server Error";
        $cCode['501'] = "Not Implemented";
        $cCode['502'] = "Bad Gateway";
        $cCode['503'] = "Service Unavailable";
        $cCode['504'] = "Gateway Timeout";
        $cCode['505'] = "HTTP Version Not Supported";

        $tamanho = strlen($data);
        $namespace = str_replace(".asmx", "", $this->aURLwsdl[$wsdl]);
        if ($metodoX) {
            $metodo = $metodoX;
        } else {
            $metodo = $wsdl . '2';
        }

        $parametros = Array('Content-Type: application/soap+xml;charset=utf-8;action="' . $namespace . "/" . $metodo . '"', 'SOAPAction: "' . $metodo . '"', "Content-length: $tamanho");
        //$parametros = Array('Content-Type: application/soap+xml;charset=utf-8;action="http://www.portalfiscal.inf.br/nfe/wsdl/NfeInutilizacao2/nfeInutilizacaoNF2"', 'SOAPAction: "' . $metodo . '"', "Content-length: $tamanho");
        $URL = $this->aURLwsdl[$wsdl];
        $_aspa = '"';
        $oCurl = curl_init();
        curl_setopt($oCurl, CURLOPT_URL, $URL . '');
        curl_setopt($oCurl, CURLOPT_PORT, 443);
        curl_setopt($oCurl, CURLOPT_VERBOSE, 1);
        curl_setopt($oCurl, CURLOPT_HEADER, 1); //retorna o cabeçalho de resposta
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 3);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($oCurl, CURLOPT_SSLCERT, $this->pathCert);
        curl_setopt($oCurl, CURLOPT_SSLKEY, $this->pathKey);
        curl_setopt($oCurl, CURLOPT_POST, 1);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $parametros);


        $__xml = curl_exec($oCurl);
        $info = curl_getinfo($oCurl); //informações da conexão

        $txtInfo = "";
        $txtInfo .= "URL=$info[url]\n";
        $txtInfo .= "Content type=$info[content_type]\n";
        $txtInfo .= "Http Code=$info[http_code]\n";
        $txtInfo .= "Header Size=$info[header_size]\n";
        $txtInfo .= "Request Size=$info[request_size]\n";
        $txtInfo .= "Filetime=$info[filetime]\n";
        $txtInfo .= "SSL Verify Result=$info[ssl_verify_result]\n";
        $txtInfo .= "Redirect Count=$info[redirect_count]\n";
        $txtInfo .= "Total Time=$info[total_time]\n";
        $txtInfo .= "Namelookup=$info[namelookup_time]\n";
        $txtInfo .= "Connect Time=$info[connect_time]\n";
        $txtInfo .= "Pretransfer Time=$info[pretransfer_time]\n";
        $txtInfo .= "Size Upload=$info[size_upload]\n";
        $txtInfo .= "Size Download=$info[size_download]\n";
        $txtInfo .= "Speed Download=$info[speed_download]\n";
        $txtInfo .= "Speed Upload=$info[speed_upload]\n";
        $txtInfo .= "Download Content Length=$info[download_content_length]\n";
        $txtInfo .= "Upload Content Length=$info[upload_content_length]\n";
        $txtInfo .= "Start Transfer Time=$info[starttransfer_time]\n";
        $txtInfo .= "Redirect Time=$info[redirect_time]\n";
        $txtInfo .= "Certinfo=$info[certinfo]\n";

        $n = strlen($__xml);
        $x = stripos($__xml, "<");
        $xml = substr($__xml, $x, $n - $x);

        $this->soapDebug = $data . "\n\n" . $txtInfo . "\n" . $__xml;

        if ($__xml === false) {
            //não houve retorno
            $this->errMsg = curl_error($oCurl) . $info['http_code'] . $cCode[$info['http_code']];
            $this->errStatus = true;
        } else {
            //houve retorno mas ainda pode ser uma mensagem de erro do webservice
            $this->errMsg = $info['http_code'] . $cCode[$info['http_code']];
            $this->errStatus = false;
        }
        curl_close($oCurl);
        return $xml;
    }

    /**
     * Converte o campo data time retornado pelo webservice
     * em um timestamp unix
     *
     * @param    string   $DH
     * @return   timestamp
     * @access   private
     * */
    private function convertTime($DH) {
        if ($DH) {
            $aDH = split('T', $DH);
            $adDH = split('-', $aDH[0]);
            $atDH = split(':', $aDH[1]);
            $timestampDH = mktime($atDH[0], $atDH[1], $atDH[2], $adDH[1], $adDH[2], $adDH[0]);
            return $timestampDH;
        }
    }

    /**
     * Retira as chaves de inicio e fim do certificado digital
     * para inclusão do mesno na tag assinaura
     * em um timestamp unix
     *
     * @param    none
     * @return   string contendo a chave digital limpa
     * @access   private
     * */
    private function limpaCert() {
        //carregar a chave publica do arquivo pem
        //trigger_error($this->pathCert, E_USER_ERROR);
        $pubKey = file_get_contents($this->pathCert);
        //inicializa variavel
        $data = '';
        //carrega o certificado em um array usando o LF como referencia
        $arCert = explode("\n", $pubKey);
        foreach ($arCert AS $curData) {
            //remove a tag de inicio e fim do certificado
            if (strncmp($curData, '-----BEGIN CERTIFICATE', 22) != 0 && strncmp($curData, '-----END CERTIFICATE', 20) != 0) {
                //carrega o resultado numa string
                $data .= trim($curData);
            }
        }
        return $data;
    }

    public function getWebServices_teste() {
        if ($this->UFcod == '43') {
            if ($this->ambiente == 1) {
                $this->aURLwsdl = array(
                    'ConsultaCadastro' => 'https://sef.sefaz.rs.gov.br/ws/cadconsultacadastro/cadconsultacadastro.asmx',
                    'NfeRecepcao' => 'https://nfe.sefaz.rs.gov.br/ws/nferecepcao/NfeRecepcao.asmx',
                    'NfeRetRecepcao' => 'https://nfe.sefaz.rs.gov.br/ws/nferetrecepcao/NfeRetRecepcao.asmx',
                    'NfeCancelamento' => 'https://nfe.sefaz.rs.gov.br/ws/nfecancelamento/NfeCancelamento.asmx',
                    'NfeInutilizacao' => 'https://nfe.sefaz.rs.gov.br/ws/nfeinutilizacao/NfeInutilizacao.asmx',
                    'NfeStatusServico' => 'https://nfe.sefaz.rs.gov.br/ws/nfestatusservico/NfeStatusServico.asmx',
                    'NfeConsultaNF' => 'https://nfe.sefaz.rs.gov.br/ws/nfeconsulta/NfeConsulta.asmx'
                );
            } else {
                $this->aURLwsdl = array(
                    'ConsultaCadastro' => 'https://sef.sefaz.rs.gov.br/ws/cadconsultacadastro/cadconsultacadastro.asmx',
                    'NfeRecepcao' => 'https://homologacao.nfe.sefaz.rs.gov.br/ws/nferecepcao/NfeRecepcao.asmx',
                    'NfeRetRecepcao' => 'https://homologacao.nfe.sefaz.rs.gov.br/ws/nferetrecepcao/NfeRetRecepcao.asmx',
                    'NfeCancelamento' => 'https://homologacao.nfe.sefaz.rs.gov.br/ws/nfecancelamento/NfeCancelamento.asmx',
                    'NfeInutilizacao' => 'https://homologacao.nfe.sefaz.rs.gov.br/ws/nfeinutilizacao/nfeinutilizacao.asmx',
                    'NfeStatusServico' => 'https://homologacao.nfe.sefaz.rs.gov.br/ws/nfestatusservico/NfeStatusServico.asmx',
                    'NfeConsultaNF' => 'https://homologacao.nfe.sefaz.rs.gov.br/ws/nfeconsulta/NfeConsulta.asmx'
                );
            }
        } elseif ($this->UFcod == '42') {
            if ($this->ambiente == 1) {
                $this->aURLwsdl = array(
                    'ConsultaCadastro' => '', //'https://sef.sefaz.rs.gov.br/ws/cadconsultacadastro/cadconsultacadastro.asmx',
                    'NfeRecepcao' => 'https://nfe.sefazvirtual.rs.gov.br/ws/nferecepcao/NfeRecepcao.asmx',
                    'NfeRetRecepcao' => 'https://nfe.sefazvirtual.rs.gov.br/ws/nferetrecepcao/NfeRetRecepcao.asmx',
                    'NfeCancelamento' => 'https://nfe.sefazvirtual.rs.gov.br/ws/nfecancelamento/NfeCancelamento.asmx',
                    'NfeInutilizacao' => 'https://nfe.sefazvirtual.rs.gov.br/ws/nfeinutilizacao/NfeInutilizacao.asmx',
                    'NfeStatusServico' => 'https://nfe.sefazvirtual.rs.gov.br/ws/nfestatusservico/NfeStatusServico.asmx', //'https://homologacao.nfe.sefaz.rs.gov.br/ws/nfestatusservico/NfeStatusServico.asmx',
                    'NfeConsultaNF' => ''//'https://homologacao.nfe.sefaz.rs.gov.br/ws/nfeconsulta/NfeConsulta.asmx'
                );
            } else {
                $this->aURLwsdl = array(
                    'ConsultaCadastro' => '', //'https://sef.sefaz.rs.gov.br/ws/cadconsultacadastro/cadconsultacadastro.asmx',
                    'NfeRecepcao' => 'https://homologacao.nfe.sefazvirtual.rs.gov.br/ws/nferecepcao/NfeRecepcao.asmx',
                    'NfeRetRecepcao' => 'https://homologacao.nfe.sefazvirtual.rs.gov.br/ws/nferetrecepcao/NfeRetRecepcao.asmx',
                    'NfeCancelamento' => 'https://homologacao.nfe.sefazvirtual.rs.gov.br/ws/nfecancelamento/NfeCancelamento.asmx',
                    'NfeInutilizacao' => 'https://homologacao.nfe.sefazvirtual.rs.gov.br/ws/nfeinutilizacao/NfeInutilizacao.asmx',
                    'NfeStatusServico' => '', //'https://homologacao.nfe.sefaz.rs.gov.br/ws/nfestatusservico/NfeStatusServico.asmx',
                    'NfeConsultaNF' => ''//'https://homologacao.nfe.sefaz.rs.gov.br/ws/nfeconsulta/NfeConsulta.asmx'
                );
//SVRS	NfeConsultaProtocolo	https://homologacao.nfe.sefazvirtual.rs.gov.br/ws/nfeconsulta/NfeConsulta.asmx
//SVRS	NfeStatusServico	https://homologacao.nfe.sefazvirtual.rs.gov.br/ws/nfestatusservico/NfeStatusServico.asmx
            }
        }
    }

    ///////////////		MÁRCIO		/////////////////////
    public function getWebServices() {
        $sql = "select * from nfe_webservices where cod_estado='$this->UFcod' and ambiente='$this->ambiente' and versao='$this->versaoNFe'";
        $sql = mysql_query($sql);
        $tot = mysql_num_rows($sql);
        $this->aURLwsdl = array();
        for ($i = 0; $i < $tot; $i++) {
            $servico = mysql_result($sql, $i, "servico");
            $url = mysql_result($sql, $i, "url");
            $this->aURLwsdl["$servico"] = "$url";
        }
    }

    ///////////////		MÁRCIO		/////////////////////
}

class NFeSOAP2Client extends SoapClient {

    function __doRequest($request, $location, $action, $version) {
        $request = str_replace(':ns1', '', $request);
        $request = str_replace('ns1:', '', $request);
        $request = str_replace("\n", '', $request);
        $request = str_replace("\r", '', $request);
        return parent::__doRequest($request, $location, $action, $version);
    }

}

?>