<?php

use Adianti\Database\TRecord;

class Funcionario extends TRecord {

    const TABLENAME = 'funcionario';
    const PRIMARYKEY = 'nu_cpfFunc';
    const IDPOLICY = 'max';

    private $cidade;

    public function __contructor($id = null, $callObjectLoad = true){
        parent::__contructor($id, $callObjectLoad);

        parent::addAttribute('nm_funcionario');
        parent::addAttribute('nu_matricula');
        parent::addAttribute('tp_genero');
        parent::addAttribute('rua');
        parent::addAttribute('bairro');
        parent::addAttribute('uf');
        parent::addAttribute('cidade_id');
        parent::addAttribute('nu_rg');
        parent::addAttribute('orgao_emissor');
    }

    public function get_cidade(){

        if(empty($this->cidade)){
            $this->cidade = new Cidade($this->id);
        }
       return $this->cidade;
    }
}

?>

