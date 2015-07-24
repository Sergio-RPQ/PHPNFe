<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('NFe_campo.php');
require_once('NFe_di_adi.php');

class NFe_di {
    public $nDI = null;
    public $dDI = null;
    public $xLocDesemb = null;
    public $ufDesemb = null;
    public $dDesemb = null;
    public $cExportador = null;
    
    public $XML = null;
    
    private $Adi = array();
    
    public function  __construct() {
        $this->init();
    }

    private function init() {
        $this->nDI = new NFe_campo();
        $this->nDI->tag = 'nDI';
        $this->nDI->obrigatorio = true;
        
        $this->dDI = new NFe_campo();
        $this->dDI->tag = 'dDI';
        $this->dDI->obrigatorio = true;
        $this->dDI->tipo = DATA;
        
        $this->xLocDesemb = new NFe_campo();
        $this->xLocDesemb->tag = 'xLocDesemb';
        $this->xLocDesemb->obrigatorio = true;
        
        $this->ufDesemb = new NFe_campo();
        $this->ufDesemb->tag = 'UFDesemb';
        $this->ufDesemb->obrigatorio = true;        
        
        $this->dDesemb = new NFe_campo();
        $this->dDesemb->tag = 'dDesemb';
        $this->dDesemb->obrigatorio = true;
        $this->dDesemb->tipo = DATA;
        
        $this->cExportador = new NFe_campo();
        $this->cExportador->tag = 'cExportador';
        $this->cExportador->obrigatorio = true;        
        
        $this->Adi = array();
    }    
    
    
    public function addAdi($a) {
        $this->Adi [] = $a;
    }

    public function countAdi() {
        return count($this->Adi);
    }

    public function getAdi($i) {
        return $this->Adi[$i];
    }
    
    public function getXML() {
        $this->XML = '<DI>';
        $this->XML .= $this->nDI->getXML();
        $this->XML .= $this->dDI->getXML();
        $this->XML .= $this->xLocDesemb->getXML();
        $this->XML .= $this->ufDesemb->getXML();
        $this->XML .= $this->dDesemb->getXML();
        $this->XML .= $this->cExportador->getXML();        
        for ($j=0;$j<count($this->Adi);$j++) {
            $adi = $this->Adi[$j];
            $this->XML .= $adi->getXML();
        }        
        $this->XML .= '</DI>';
        
        return $this->XML;
    }
}
?>