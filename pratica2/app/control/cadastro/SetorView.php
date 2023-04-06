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
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Wrapper\BootstrapFormBuilder;


class SetorView extends TPage
{
    private $form;

    public function __construct(){

        parent::__construct();

      

       $this->form = new BootstrapFormBuilder;
       $this->form->setFormTitle('Setor');
       $this->form->setClientValidation(true);

      $sq_setor = new TEntry('sq_setor');
      $nm_setor = new TEntry('nm_setor');
      $ds_endereco = new TEntry('ds_endereco');
      $dt_desativacao = new TDateTime('dt_desativacao');


    
    
      $sq_setor->setEditable(FALSE); 
      $sq_setor->setSize('20%');
      $dt_desativacao->setEditable(FALSE); 

    
      $nm_setor->addValidation('Nome', new TRequiredValidator);
      $ds_endereco->addValidation('Endereço', new TRequiredValidator);

       
       $this->form->addFields( [new TLabel('Numero')], [$sq_setor]);
       $this->form->addFields( [new TLabel('Nome')], [$nm_setor]);
       $this->form->addFields( [new TLabel('Endereço')], [$ds_endereco]);



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

            $setor = new Setor;
            $setor->fromArray( (array) $data );
            $setor->nu_cnpj = '00642856000160'; #date('Y-m-d H:i:s');
            $setor->store();

            //Jogar objeto para o formulario
            $this->form->setData($setor);

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

        AdiantiCoreApplication::loadPage('SetorList');
      
       
     
    }

    //Medoto de edição
    public  function onEdit($param){

        try{
            TTransaction::open('sample');

            if(isset($param['sq_setor'])){

                $key = $param['sq_setor'];
                $setor = new Setor($key);
                $this->form->setData($setor);

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