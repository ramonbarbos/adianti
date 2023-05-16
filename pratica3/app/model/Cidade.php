<?php

use Adianti\Database\TRecord;

class Cidade extends TRecord {

    const TABLENAME = 'cidade';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    private $estado;

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nome');
        parent::addAttribute('cod_ibge');
        parent::addAttribute('estado_id');
     
    }

    public function get_estado(){

        if(empty($this->estado)){
            $this->estado = new Estado($this->id);
        }
       return $this->estado;
    }
}

?>

