<?php

use Adianti\Database\TRecord;

class Grupo extends TRecord {

    const TABLENAME = 'grupo';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nome');
     
    }
}

?>

