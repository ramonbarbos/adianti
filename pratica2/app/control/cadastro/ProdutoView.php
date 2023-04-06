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


class ProdutoView extends TPage
{
    private $form;

    public function __construct(){

        parent::__construct();
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Produto/Serviços');
        $this->form->setClientValidation(true);

       $sq_produto = new TEntry('sq_produto');
       $nm_produto = new TEntry('nm_produto');
       $ds_produto = new TText('ds_produto');
       $cd_grupo = new TDBCombo('cd_grupo', 'sample', 'Grupo','cd_grupo',  'nm_grupo');
       $sq_unidade = new TDBCombo('sq_unidade', 'sample', 'Unidade','id',  'nome_unidade');
       $dt_cadastro = new TDateTime('dt_cadastro');
       $dt_desativacao = new TDateTime('dt_desativacao');
       
       $sq_produto->setEditable(FALSE); 
       $sq_produto->setSize('50%');

       $this->form->addFields( [new TLabel('Codigo')], [$sq_produto], [new TLabel('UND')], [$sq_unidade]);
       $this->form->addFields( [new TLabel('Grupo')], [$cd_grupo]);
       $this->form->addFields( [new TLabel('Nome')], [$nm_produto]);
       $this->form->addFields( [new TLabel('Descrição')], [$ds_produto]);

       $nm_produto->addValidation('Nome', new TRequiredValidator);
       $nm_produto->addValidation('Grupo', new TRequiredValidator);
       $nm_produto->addValidation('UND', new TRequiredValidator);


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

            $produto = new Produto;
            $produto->fromArray( (array) $data );
            $produto->dt_cadastro = date('Y-m-d H:i:s');
            $produto->store();

            //Jogar objeto para o formulario
            $this->form->setData($produto);

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

        AdiantiCoreApplication::loadPage('ProdutoList');
      
       
     
    }

    //Medoto de edição
    public  function onEdit($param){

        try{
            TTransaction::open('sample');

            if(isset($param['sq_produto'])){

                $key = $param['sq_produto'];
                $produto = new Produto($key);
                $this->form->setData($produto);

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