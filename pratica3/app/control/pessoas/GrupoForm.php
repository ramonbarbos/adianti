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
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Widget\Wrapper\TDBSeekButton;
use Adianti\Wrapper\BootstrapFormBuilder;


class GrupoForm extends TPage
{
    private $form;

    use Adianti\base\AdiantiStandardFormTrait;

    public function __construct(){

        parent::__construct();

        parent::setTargetContainer('adianti_right_panel');
        $this->setAfterSaveAction(new TAction(['GrupoList', 'onReload'], ['register_state'=> 'true']));

        $this->setDatabase('sample');
        $this->setActiveRecord('Grupo');

        //Criação do formulario
        $this->form = new BootstrapFormBuilder('form_grupo');
        $this->form->setFormTitle('Grupo');
        $this->form->setClientValidation(true);
        $this->form->setColumnClasses(2, ['col-sm-5 col-lg-4', 'col-sm-7 col-lf-8]']);

        //criar fields para o form
         //Criação de fields
         $id = new TEntry('id');
         $nome = new TEntry('nome');
 
         //Add filds na tela
         $this->form->addFields( [new TLabel('Id')], [ $id ] );
         $this->form->addFields( [new TLabel('Nome')], [ $nome ] );

         $nome->addValidation('Nome', new TRequiredValidator);

         $id->setEditable(false);

         //Tamanho dos fields
        $id->setSize('100%');
        $nome->setSize('100%');

        $btn =  $this->form->addAction( _t('Save'), new TAction([$this, 'onSave']), 'fa:plus green' );
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('New'), new TAction([$this, 'onEdit']), 'fa:edit blue' );

        $this->form->addHeaderActionLink( _t('Close'), new TAction([$this, 'onClose']), 'fa:times red' );

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