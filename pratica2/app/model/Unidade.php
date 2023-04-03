<?php

use Adianti\Database\TRecord;

class Unidade extends TRecord {

    const TABLENAME = 'unidade';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nome_unidade');
        parent::addAttribute('sigla');
    }
}

?>

