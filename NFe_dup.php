<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('NFe_campo.php');

class NFe_dup {

    public $cobr_dup_nDup = null;
    public $cobr_dup_dVenc = null;
    public $cobr_dup_vDup = null;

    public $XML = null;

    public function  __construct() {
        $this->init();
    }

    private function init() {
        $this->cobr_dup_nDup = new NFe_campo();
        $this->cobr_dup_nDup->tag = 'nDup';

        $this->cobr_dup_dVenc = new NFe_campo();
        $this->cobr_dup_dVenc->tag = 'dVenc';
        $this->cobr_dup_dVenc->tipo = DATA;
        
        $this->cobr_dup_vDup = new NFe_campo();
        $this->cobr_dup_vDup->tag = 'vDup';
        $this->cobr_dup_vDup->tipo = NUMERO;
        $this->cobr_dup_vDup->casas_decimais = 2;

    }

    public function getXML() {
        $this->XML = '';

        $this->XML .= '<dup>';
        $this->XML .= $this->cobr_dup_nDup->getXML();
        $this->XML .= $this->cobr_dup_dVenc->getXML();
        $this->XML .= $this->cobr_dup_vDup->getXML();
        $this->XML .= '</dup>';

        if ($this->XML == '<dup></dup>') {
            $this->XML = '';
        }

        return $this->XML;
    }
}
?>