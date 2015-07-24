<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('NFe_campo.php');

class NFe_di_adi {
    public $nAdicao = null;
    public $nSeqAdic = null;
    public $cFabricante = null;
    public $vDescDI = null;
    public $xPed = null;
    public $xItemPed = null;
    
    public $XML;
    
    public function  __construct() {
        $this->init();
    }

    private function init() {
        $this->nAdicao = new NFe_campo();
        $this->nAdicao->tag = 'nAdicao';
        $this->nAdicao->obrigatorio = true;
        
        $this->nSeqAdic = new NFe_campo();
        $this->nSeqAdic->tag = 'nSeqAdic';
        $this->nSeqAdic->obrigatorio = true;
        
        $this->cFabricante = new NFe_campo();
        $this->cFabricante->tag = 'cFabricante';
        $this->cFabricante->obrigatorio = true;        
        
        $this->vDescDI = new NFe_campo();
        $this->vDescDI->tag = 'vDescDI';
        $this->vDescDI->tipo = NUMERO;
        $this->vDescDI->casas_decimais = 2;      
        
        $this->xPed = new NFe_campo();
        $this->xPed->tag = 'xPed';
        
        $this->xItemPed = new NFe_campo();
        $this->xItemPed->tag = 'xItemPed';
    }
    
    function getXML() {
        $this->XML = '<adi>';
        $this->XML .= $this->nAdicao->getXML();
        $this->XML .= $this->nSeqAdic->getXML();
        $this->XML .= $this->cFabricante->getXML();
        $this->XML .= $this->vDescDI->getXML();
        $this->XML .= $this->xPed->getXML();
        $this->XML .= $this->xItemPed->getXML();
        $this->XML .= '</adi>';
        return $this->XML;
    }
}
?>