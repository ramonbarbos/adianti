<?php

use Adianti\Database\TRecord;

class Produto extends TRecord {

    const TABLENAME = 'produto';
    const PRIMARYKEY = 'sq_produto';
    const IDPOLICY = 'max';

    private $unidade;

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nu_cnpj');
        parent::addAttribute('nm_produto');
        parent::addAttribute('ds_produto');
        parent::addAttribute('cd_grupo');
        parent::addAttribute('sq_unidade');
        parent::addAttribute('dt_cadastro');
        parent::addAttribute('dt_desativacao');
    }

    public function get_unidade(){

        if(empty($this->unidade)){
            $this->unidade = new Unidade($this->sq_unidade);
        }
       return $this->unidade;
    }
}

?>

