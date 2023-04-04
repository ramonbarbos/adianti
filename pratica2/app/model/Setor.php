<?php

use Adianti\Database\TRecord;

class Setor extends TRecord {

    const TABLENAME = 'setor';
    const PRIMARYKEY = 'sq_setor';
    const IDPOLICY = 'max';

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nu_cnpj');
        parent::addAttribute('nm_setor');
        parent::addAttribute('dt_desativacao');
        parent::addAttribute('ds_endereco');
    }
    
}

?>

