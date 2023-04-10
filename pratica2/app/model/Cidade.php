<?php

use Adianti\Database\TRecord;

class Cidade extends TRecord {

    const TABLENAME = 'cidade';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nm_cidade');
        parent::addAttribute('cep');
        parent::addAttribute('estado_id');
    }
}

?>

