<?php
class Categoria extends TRecord {

    const TABLENAME = 'categoria';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nome');
    }
}

?>