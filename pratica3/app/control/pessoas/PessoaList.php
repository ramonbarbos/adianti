<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Registry\TSession;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Util\TDropDown;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Widget\Wrapper\TDBUniqueSearch;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;

class PessoaList extends TPage
{
    private $form;
    private $datagrid;
    private $pageNavigation;
    private $formgrid;
    private $deleteButton;

    use Adianti\base\AdiantiStandardListTrait;
    
    public function __construct(){

        parent::__construct();


        //Conexão com a tabela
        $this->setDatabase('sample');
        $this->setActiveRecord('Pessoa');
        $this->setDefaultOrder('id', 'asc');
        $this->setLimit(10);

        $this->addFilterField('id', '=', 'id');
        $this->addFilterField('nome_fantasia', 'like', 'nome_fantasia');
        $this->addFilterField('fone', 'like', 'fone');
        $this->addFilterField('email', 'like', 'email');
        $this->addFilterField('grupo_id', 'like', 'grupo_id');

        //Criação do formulario 
        $this->form = new BootstrapFormBuilder('formulario pessoa');
        $this->form->setFormTitle('Pessoa');

        //Criação de fields
        $id = new TEntry('id');
        $nome_fantasia = new TEntry('nome_fantasia');
        $fone = new TEntry('fone');
        $email = new TEntry('email');
        $grupo_id = new TDBUniqueSearch('grupo_id', 'sample', 'Grupo','id',  'nome');

        //Add filds na tela
        $this->form->addFields( [new TLabel('Id')], [ $id ] );
        $this->form->addFields( [new TLabel('Nome Fantasia')], [ $nome_fantasia ] );
        $this->form->addFields( [new TLabel('Celular')], [ $fone ] );
        $this->form->addFields( [new TLabel('Emal')], [ $email ] );
        $this->form->addFields( [new TLabel('Grupo')], [ $grupo_id ] );

        //Tamanho dos fields
        $id->setSize('100%');
        $nome_fantasia->setSize('100%');
        $fone->setSize('100%');
        $email->setSize('100%');
        $grupo_id->setSize('100%');

        $this->form->setData( TSession::getValue( __CLASS__.'_filter_data') );

        //Adicionar field de busca
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('New'), new TAction(['CidadeForm', 'onEdit'], ['register_state' => 'false']), 'fa:plus green'  );

        //Criando a data grid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';

        //Criando colunas da datagrid
        $column_id = new TDataGridColumn('id', 'Id', 'center', '10%');
        $column_nome = new TDataGridColumn('nome_fantasia ', 'Nome', 'left');
        $column_fone = new TDataGridColumn('fone', 'Celular', 'left');
        $column_email = new TDataGridColumn('email', 'Email', 'left');
        $column_grupo = new TDataGridColumn('grupo->nome', 'Grupo', 'left');


        $column_fone->enableAutoHide(500);
        $column_email->enableAutoHide(500);
        $column_grupo->enableAutoHide(500);

        //add coluna da datagrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_fone);
        $this->datagrid->addColumn($column_email);
        $this->datagrid->addColumn($column_grupo);

        //Criando ações para o datagrid
        $column_id->setAction(new TAction([$this, 'onReload']), ['order'=> 'id']);
        $column_nome->setAction(new TAction([$this, 'onReload']), ['order'=> 'nome_fantasia']);

        $action1 = new TDataGridAction(['CidadeForm', 'onEdit'], ['id'=> '{id}', 'register_state' => 'false']);
        $action2 = new TDataGridAction([ $this, 'onDelete'], ['id'=> '{id}']);
        $action3 = new TDataGridAction([ 'PessoaFormView', 'onEdit'], ['id'=> '{id}', 'register_state' => 'false']);

        //Adicionando a ação na tela
        $this->datagrid->addAction($action1, _t('Edit'), 'fa:edit blue' );
        $this->datagrid->addAction($action2, _t('Delete'), 'fa:trash-alt red' );
        $this->datagrid->addAction($action3, _t('View'), 'fa:search gray' );


        //Criar datagrid 
        $this->datagrid->createModel();

        //Criação de paginador
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));

      

        //Enviar para tela
        $panel = new TPanelGroup('', 'white');
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);

          //Exportar
          $drodown = new TDropDown('Exportar', 'fa:list');
          $drodown->setPullSide('right');
          $drodown->setButtonClass('btn btn-default waves-effect dropdown-toggle');
          $drodown->addAction(_t('Save as CSV'), new TAction([$this, 'onExportCSV'], ['register_state' => 'false', 'static'=>'1']), 'fa:table green');
          $drodown->addAction(_t('Save as PDF'), new TAction([$this, 'onExportPDF'], ['register_state' => 'false',  'static'=>'1']), 'fa:file-pdf red');
          $panel->addHeaderWidget( $drodown);

        //Vertical container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add($this->form);
        $container->add($panel);
    
        parent::add($container);

       

    }
  
}