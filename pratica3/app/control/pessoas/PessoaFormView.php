<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Core\AdiantiCoreApplication;
use Adianti\Database\TTransaction;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Base\TScript;
use Adianti\Widget\Container\THBox;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TCheckList;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TDateTime;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TFieldList;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TPassword;
use Adianti\Widget\Util\TDropDown;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Widget\Wrapper\TDBSeekButton;
use Adianti\Wrapper\BootstrapFormBuilder;


class PessoaFormView extends TPage
{
    private $form;

    use Adianti\base\AdiantiStandardFormTrait;
    

    public function __construct($param){

        parent::__construct();

        parent::setTargetContainer('adianti_right_panel');
        $this->setAfterSaveAction(new TAction(['PessoaList', 'onReload'], ['register_state'=> 'true']));

        $this->setDatabase('sample');
        $this->setActiveRecord('Pessoa');

        //Criação do formulario
        $this->form = new BootstrapFormBuilder('form_pessoa');
        $this->form->setFormTitle('Pessoa');
        $this->form->setClientValidation(true);
        $this->form->setColumnClasses(2, ['col-sm-5 col-lg-4', 'col-sm-7 col-lf-8]']);

        //Opções
        $drodown = new TDropDown('Opções', 'fa:th');
        $drodown->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        #$drodown->addAction( 'Imprimir', new TAction([$this, 'onPrint'], ['key'=>$param['key'], 'static' => '1']), 'far:file-pdf red');
       # $drodown->addAction('Gerar Etiqueta', new TAction([$this, 'onGeraEtiqueta'], ['key'=>$param['key'],'static'=>'1'] ), 'fa:file-pdf red');
        #$drodown->addAction('Editar', new TAction(['PessoaForm', 'onEdit'], ['key'=>$param['key'],'static'=>'1'] ), 'fa:edit blue');
        $drodown->addAction('Fechar', new TAction([$this, 'onClose']), 'fa:times red');

        $this->form->addHeaderWidget($drodown);

      
           //Criação de fields
           $id = new TEntry('id');
           $uf = new TEntry('uf');
           $nome = new TEntry('nome');
   
           //Add filds na tela
           $this->form->addFields( [new TLabel('Id')], [ $id ] );
           $this->form->addFields( [new TLabel('UF')], [ $uf ] );
           $this->form->addFields( [new TLabel('Nome')], [ $nome ] );
   
           //Tamanho dos fields
           $id->setSize('100%');
           $uf->setSize('100%');
           $nome->setSize('100%');
   
         $nome->addValidation('Nome', new TRequiredValidator);

         $id->setEditable(false);


        $btn =  $this->form->addAction( _t('Save'), new TAction([$this, 'onSave']), 'fa:plus green' );
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('New'), new TAction([$this, 'onEdit']), 'fa:eraser red' );


        //Vertical container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add($this->form);
    
        parent::add($container);

       

    }
    //Metodo fechar
    public static function onClose($param)
    {
        TScript::create("Template.closeRightPanel()");
    }

    
    
}