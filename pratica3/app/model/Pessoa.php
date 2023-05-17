<?php

use Adianti\Database\TRecord;

class Pessoa extends TRecord {

    const TABLENAME = 'pessoa';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    private $grupo;

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nome');
        parent::addAttribute('nome_fantasia');
        parent::addAttribute('tipo');
        parent::addAttribute('codigo_nacional');
        parent::addAttribute('codigo_estadual');
        parent::addAttribute('codigo_municipal');
        parent::addAttribute('fone');
        parent::addAttribute('email');
        parent::addAttribute('observacao');
        parent::addAttribute('cep');
        parent::addAttribute('logradouro');
        parent::addAttribute('numero');
        parent::addAttribute('complemento');
        parent::addAttribute('bairro');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('grupo_id');
     
    }

    public function get_grupo(){

        if(empty($this->grupo)){
            $this->grupo = new Grupo($this->id);
        }
       return $this->grupo;
    }
}

?>

