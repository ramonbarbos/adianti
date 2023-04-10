<?php

use Adianti\Database\TRecord;

class Estado extends TRecord {

    const TABLENAME = 'estado';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nm_estado');
        parent::addAttribute('sigla');
    }
}

?>

