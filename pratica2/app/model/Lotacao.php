<?php

use Adianti\Database\TRecord;

class Lotacao extends TRecord {

    const TABLENAME = 'locatao_setor';
    const PRIMARYKEY = 'sq_lotacao';
    const IDPOLICY = 'max';

    private $func;
    private $orgao;
    private $unidOrc;
    private $setor;

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nu_cpfFunc');
        parent::addAttribute('cd_orgaoEstru');
        parent::addAttribute('cd_unidEstru');
        parent::addAttribute('cd_setorEstru');
        parent::addAttribute('dt_inicio');
    }

    public function get_func(){

        if(empty($this->func)){
            $this->func = new Funcionario($this->nu_cpfFunc);
        }
       return $this->func;
    }
    public function get_setor(){

        if(empty($this->setor)){
            $this->setor = new Setor($this->cd_setorEstru);
        }
       return $this->setor;
    }
     
    public function get_orgao(){

        if(empty($this->orgao)){
            $this->orgao = new Orgao($this->cd_orgaoEstru);
        }
       return $this->orgao;
    }
    public function get_unid_orcamentaria(){

        if(empty($this->unidOrc)){
            $this->unidOrc = new UnidOrcamentaria($this->cd_unidEstru);
        }
       return $this->unidOrc;
    }
    
}

?>

