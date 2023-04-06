<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Core\AdiantiCoreApplication;
use Adianti\Database\TTransaction;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Container\THBox;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TCheckList;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TDateTime;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TFieldList;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TPassword;
use Adianti\Widget\Form\TText;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Wrapper\BootstrapFormBuilder;


class OrgaoView extends TPage
{
    private $form;

    public function __construct(){

        parent::__construct();
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Orgao');
        $this->form->setClientValidation(true);

       $cd_orgao = new TEntry('cd_orgao');
       $nm_orgao = new TEntry('nm_orgao');
       $tp_poder        = new TCombo('tp_poder');
       $nu_telefone = new TEntry('nu_telefone');
       $ds_email = new TEntry('ds_email');
       
       $tp_poder->setSize('40%');
       $tp_poder->addItems( ['1' => 'Legislativo', '2' => 'Executivo', '3' => 'Judiciario'] );
       $this->form->addFields( [new TLabel('Codigo')], [$cd_orgao],[new TLabel('Celular')], [$nu_telefone]);
       $this->form->addFields( [new TLabel('Nome')], [$nm_orgao], [new TLabel('Poder')], [$tp_poder]);
       $this->form->addFields( [new TLabel('Email')], [$ds_email]);

       $cd_orgao->addValidation('Codigo', new TRequiredValidator);
       $nm_orgao->addValidation('Nome', new TRequiredValidator);
       $tp_poder->addValidation('Poder', new TRequiredValidator);


       $this->form->addAction('Salvar', new TAction( [$this, 'onSave'])); //POST
       $this->form->addActionLink('Limpar', new TAction( [$this, 'onClear']));
       $this->form->addActionLink('Listar', new TAction( [$this, 'onList']));

    

       parent::add($this->form);

       

    }
    //Inclusão de Registros
    public  function onSave($param){

   
        try{
            TTransaction::open('sample');

            $this->form->validate();

            $data = $this->form->getData();

            $orgao = new Orgao;
            $orgao->fromArray( (array) $data );
            $orgao->dt_ano = date('Y');
            $ano = date('Y');
            $mes =date('m');
            $orgao->dt_anoMes = $ano. $mes;
            $orgao->nu_cnpj = '00642856000160'; #date('Y-m-d H:i:s');
            $orgao->store();

            //Jogar objeto para o formulario
            $this->form->setData($orgao);

            new TMessage('info', 'Registro salvo com sucesso');


            TTransaction::close();

        }catch (Exception $e){
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }

    //Limpeza de Formulario
    public  function onClear($param){

        $this->form->clear(true);
     
    }
     //Lista
     public  function onList($param){

        AdiantiCoreApplication::loadPage('OrgaoList');
      
       
     
    }

    //Medoto de edição
    public  function onEdit($param){

        try{
            TTransaction::open('sample');

            if(isset($param['cd_orgao'])){

                $key = $param['cd_orgao'];
                $orgao = new Orgao($key);
                $this->form->setData($orgao);

            }else{
                $this->form->clear(true);

            }
           


            TTransaction::close();

        }catch (Exception $e){
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
     
    }

    
}