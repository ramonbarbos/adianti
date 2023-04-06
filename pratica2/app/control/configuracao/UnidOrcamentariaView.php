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


class UnidOrcamentariaView extends TPage
{
    private $form;

    public function __construct(){

        parent::__construct();
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Unidade Orçamentaria');
        $this->form->setClientValidation(true);

       $cd_unidOrcamentaria = new TEntry('cd_unidOrcamentaria');
       $nm_unidOrcamentaria = new TEntry('nm_unidOrcamentaria');
       $nu_telefone = new TEntry('nu_telefone');
       $ds_email = new TEntry('ds_email');
       
       $this->form->addFields( [new TLabel('Codigo')], [$cd_unidOrcamentaria],[new TLabel('Celular')], [$nu_telefone]);
       $this->form->addFields( [new TLabel('Nome')], [$nm_unidOrcamentaria]);
       $this->form->addFields( [new TLabel('Email')], [$ds_email]);

       $cd_unidOrcamentaria->addValidation('Codigo', new TRequiredValidator);
       $nm_unidOrcamentaria->addValidation('Nome', new TRequiredValidator);


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

            $unidOrcamentaria = new UnidOrcamentaria;
            $unidOrcamentaria->fromArray( (array) $data );
            $unidOrcamentaria->dt_ano = date('Y');
            $ano = date('Y');
            $mes =date('m');
            $unidOrcamentaria->dt_anoMes = $ano. $mes;
            $unidOrcamentaria->nu_cnpj = '00642856000160'; #date('Y-m-d H:i:s');
            $unidOrcamentaria->store();

            //Jogar objeto para o formulario
            $this->form->setData($unidOrcamentaria);

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

        AdiantiCoreApplication::loadPage('UnidOrcamentariaList');
      
       
     
    }

    //Medoto de edição
    public  function onEdit($param){

        try{
            TTransaction::open('sample');

            if(isset($param['cd_unidOrcamentaria'])){

                $key = $param['cd_unidOrcamentaria'];
                $UnidOrcamentaria = new UnidOrcamentaria($key);
                $this->form->setData($UnidOrcamentaria);

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