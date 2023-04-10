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
use Adianti\Widget\Wrapper\TDBSeekButton;
use Adianti\Wrapper\BootstrapFormBuilder;


class FuncionarioView extends TPage
{
    private $form;

    public function __construct(){

        parent::__construct();

      

       $this->form = new BootstrapFormBuilder('form');
       $this->form->setFormTitle('Funcionario');
       $this->form->setClientValidation(true);

      $nu_cpfFunc = new TEntry('nu_cpfFunc');
      $nu_matricula = new TEntry('nu_matricula');
      $nm_funcionario = new TEntry('nm_funcionario');
      $tp_genero = new TCombo('tp_genero');
      $rua = new TEntry('rua');
      $bairro = new TEntry('bairro');
      $uf =  new TDBCombo('uf', 'sample', 'Estado','id',  'sigla');
      $cidade   = new TDBCombo('cidade_id', 'sample', 'Cidade','id',  'nm_cidade');
      $nu_rg = new TEntry('nu_rg');
      $orgao_emissor = new TEntry('orgao_emissor');
      
    
    
      $nu_cpfFunc->setSize('50%');
      $nu_cpfFunc->setMask('999.999.999-99',true);
      $tp_genero->setSize('20%');
      $tp_genero->addItems( ['F' => 'Feminino', 'M' => 'Masculino'] );
      
      $cidade->enableSearch();

      $nu_rg->setMask('99.999.999-99',true);


      $nm_funcionario->addValidation('Nome', new TRequiredValidator);
      $nu_matricula->addValidation('Matricula', new TRequiredValidator);
      $nu_cpfFunc->addValidation('CPF', new TRequiredValidator);
      $tp_genero->addValidation('Genero', new TRequiredValidator);

      
       
       $this->form->addFields( [new TLabel('CPF')], [$nu_cpfFunc], [new TLabel('Matricula')], [$nu_matricula]);
       $this->form->addFields( [new TLabel('Nome')], [$nm_funcionario]);
       $this->form->addFields( [new TLabel('Genero')], [$tp_genero]);
       #$this->form->addFields( [new TLabel('Endereço')], [$ds_endereco]);

       $subform = new BootstrapFormBuilder;
       $subform->setFieldSizes('100%');
       $subform->setProperty('style', 'border:none');

       $subform->appendPage( 'Endereço' );
       $row = $subform->addFields( [ new TLabel('Rua/Av.'),      $rua ],
                                        [ new TLabel('Bairro'),       $bairro ],
                                        [ new TLabel('Estado'), $uf ]);
       $row->layout = ['col-sm-6', 'col-sm-4', 'col-sm-2'];
       $row = $subform->addFields( [new TLabel('Cidade')],[$cidade] );
       $row->layout = ['col-sm-2', 'col-sm-4', 'col-sm-0'];
    
       $subform->appendPage( 'Dados' );
       $row = $subform->addFields( [ new TLabel('Carteira de Identidade'),      $nu_rg ],
                                    [ new TLabel('Órgão Emissor'),       $orgao_emissor ]);
        $row->layout = ['col-sm-6', 'col-sm-6', ];

       $this->form->addContent( [$subform] );

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

            $func = new Funcionario;
            $func->fromArray( (array) $data );
            $func->store();

            //Jogar objeto para o formulario
            $this->form->setData($func);

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

        AdiantiCoreApplication::loadPage('FuncionarioList');
      
       
     
    }

    //Medoto de edição
    public  function onEdit($param){

        try{
            TTransaction::open('sample');

            if(isset($param['nu_cpfFunc'])){

                $key = $param['nu_cpfFunc'];
                $func = new Funcionario($key);
                $this->form->setData($func);

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