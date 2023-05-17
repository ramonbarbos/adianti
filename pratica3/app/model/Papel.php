<?php

use Adianti\Database\TRecord;

class Papel extends TRecord {

    const TABLENAME = 'papel';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nome');
     
    }

    
}

?>

