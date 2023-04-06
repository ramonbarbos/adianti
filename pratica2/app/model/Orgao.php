<?php

use Adianti\Database\TRecord;

class Orgao extends TRecord {

    const TABLENAME = 'orgao';
    const PRIMARYKEY = 'cd_orgao';
    const IDPOLICY = 'max';

    private $poder;

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nu_cnpj');
        parent::addAttribute('dt_ano');
        parent::addAttribute('nm_orgao');
        parent::addAttribute('tp_poder');
        parent::addAttribute('nu_telefone');
        parent::addAttribute('ds_email');
        parent::addAttribute('dt_anoMes');
    }

 
     
    
}

?>

