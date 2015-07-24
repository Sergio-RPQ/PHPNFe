<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NFe_campo
 *
 * @author Marlos
 */
define('INDEFINIDO', 0);
define('NUMERO', 1);
define('TEXTO', 2);
define('DATA', 3);
define('HORA', 4);

class NFe_campo {
    public $descricao = null;
    public $tag = null;
    public $valor = null;
    public $obrigatorio = null;
    public $tipo = null;
    public $casas_decimais = null;
    public $gerarXMLSeVazio = null;
    
    public function __construct() {
        $this->descricao = '';
        $this->tag = '';
        $this->valor = '';
        $this->obrigatorio = false;
        $this->tipo = INDEFINIDO;
        $this->casas_decimais = 0;
        $this->gerarXMLSeVazio = false;
    }

    public function getXML() {
        if ((empty($this->tag) OR empty($this->valor)) AND !$this->gerarXMLSeVazio){
            if ($this->obrigatorio AND !is_numeric($this->valor)) {
                throw new Exception('Campo Obrigatório: ' . $this->tag);
                return '';
            }
            elseif (!$this->obrigatorio) {
                return '';
            }
        }

        if ((($this->tipo == NUMERO) AND !is_numeric($this->valor)) AND !$this->gerarXMLSeVazio) {
            throw new Exception('Campo é númerico: ' . $this->tag);
            return '';
        }
        
        if ($this->tipo == NUMERO) {
            if (empty($this->valor)) $this->valor = 0;
            return '<' . $this->tag . '>' . $this->dotFloat($this->casas_decimais) . '</' . $this->tag . '>';
        }
        elseif ($this->tipo == HORA) {
            return '<' . $this->tag . '>' . $this->hora() . '</' . $this->tag . '>';
        }
        else {
            return '<' . $this->tag . '>' . $this->valor . '</' . $this->tag . '>';
        }
    }

    public function data() {
        if (empty($this->valor)) {
            return '';
        }
        else {
            return substr($this->valor, 8, 2) . '/' . substr($this->valor, 5, 2) . '/' . substr($this->valor, 0, 4);
        }
        //1234-12-12
        //0123456789
    }

    public function hora() {
        if (empty($this->valor)) {
            return '';
        }
        else {
            if (strlen($this->valor) == 5) {
                return substr($this->valor, 0, 2) . ':' . substr($this->valor, 3, 2) . ':00';
            }
            elseif (strlen($this->valor) == 8) {
                return $this->valor;
            }
            else {
                return '00:00:00';
            }
        }
    }

    public function dotFloat($d = 0) {
        return number_format($this->valor, $d, '.', '');
    }

    public function periodFloat($d = 0) {
        return number_format($this->valor, $d, ',', '');
    }

    public function getValor() {
        if ($this->tipo == NUMERO) {
            if (empty($this->valor)) $this->valor = 0;
            return $this->dotFloat($this->casas_decimais);
        }
        elseif($this->tipo == DATA) {
            return $this->valor;
        }
        elseif($this->tipo == HORA) {
            return $this->hora();
        }
        else {
            return addslashes($this->valor);
        }
    }
}
?>