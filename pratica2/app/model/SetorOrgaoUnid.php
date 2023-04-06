<?php

use Adianti\Database\TRecord;

class SetorOrgaoUnid extends TRecord {

    const TABLENAME = 'setor_orgao_unid';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    private $orgao;
    private $unidOrc;
    private $setor;

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nu_cnpj');
        parent::addAttribute('sq_setor');
        parent::addAttribute('dt_ano');
        parent::addAttribute('cd_orgao');
        parent::addAttribute('cd_unidOrcamentaria');
    }

    public function get_setor(){

        if(empty($this->setor)){
            $this->setor = new Setor($this->sq_setor);
        }
       return $this->setor;
    }
     
    public function get_orgao(){

        if(empty($this->orgao)){
            $this->orgao = new Orgao($this->cd_orgao);
        }
       return $this->orgao;
    }
    public function get_unid_orcamentaria(){

        if(empty($this->unidOrc)){
            $this->unidOrc = new UnidOrcamentaria($this->cd_unidOrcamentaria);
        }
       return $this->unidOrc;
    }
    
}

?>

