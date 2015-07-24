<?php
require_once('NFe_tools.php');
mysql_connect("localhost", "root", "");
mysql_select_db("nfe");
$nfe = new NFe_tools(2);
$nfe->ambiente      =   2;
$nfe->pathCerts     =   'C:/Fontes/NFe/certs/';
$nfe->nameCert      =   'certificado.pfx';
$nfe->passKey       =   'senhadocertificado';
$nfe->passPhrase    =   'senhadocertificado';
$nfe->MySQLHost = 'localhost';
$nfe->MySQLUser = 'root';
$nfe->MySQLPass = '';
$nfe->MySQLBD = 'nfe';
$nfe->UFcod = "43";

$nfe->entradasNF     =   'C:/Fontes/NFe/notas/entradas/';
$nfe->assinadasNF    =   'C:/Fontes/NFe/notas/assinadas/';
$nfe->validadasNF    =   'C:/Fontes/NFe/notas/validadas/';
$nfe->aprovadasNF    =   'C:/Fontes/NFe/notas/aprovadas/';
$nfe->enviadasNF     =   'C:/Fontes/NFe/notas/enviadas/';
$nfe->canceladasNF   =   'C:/Fontes/NFe/notas/canceladas/';
$nfe->inutilizadasNF =   'C:/Fontes/NFe/notas/inutilizadas/';
$nfe->temporarioNF   =   'C:/Fontes/NFe/notas/temporario/';
$nfe->recebidasNF    =   'C:/Fontes/NFe/notas/recebidas/';
$nfe->consultadasNF  =   'C:/Fontes/NFe/notas/consultadas/';
$nfe->getWebServices();
if ( $nfe->carregaCert() ){
    $retorno = $nfe->statusServico();
    echo $retorno;
    echo '<br><br><br>';
    if ($retorno) {
        echo "Serviço ON line <BR>";
        echo "Tempo Medio de Resposta : ".$nfe->tMed.' s<BR>';
        echo "Verificado em : ".date('d/m/Y H:i:s',$nfe->dhRecbto).'<BR>';
    } else {
        echo "OFF LINE .... Serviço PARADO!!!<BR>";
        echo "Verificado em : ".date('d/m/Y H:i:s',$nfe->dhRecbto).'<BR>';
        echo "Codigo  : ".$nfe->cStat.'<BR>';
        echo "Motivo : ".$nfe->xMotivo.'<BR>';
        echo "Obs : ".$nfe->xObs.'<BR>';
        echo '<pre>' . htmlspecialchars( $nfe->soapDebug ) . '</pre>';
    }
} else {
    //houve erro com o certificado
    echo $nfe->errorCod.' :  '.$nfe->errorMsg.'<BR>';
}

?>