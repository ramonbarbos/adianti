<?php

use Adianti\Database\TRecord;

class UnidOrcamentaria extends TRecord {

    const TABLENAME = 'unid_orcamentaria';
    const PRIMARYKEY = 'cd_unidOrcamentaria';
    const IDPOLICY = 'max';

    private $poder;

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nu_cnpj');
        parent::addAttribute('dt_ano');
        parent::addAttribute('nm_unidOrcamentaria');
        parent::addAttribute('nu_telefone');
        parent::addAttribute('ds_email');
        parent::addAttribute('dt_anoMes');
    }

 
     
    
}

?>

