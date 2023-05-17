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

class CidadeList extends TPage
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
        $this->setActiveRecord('Cidade');
        $this->setDefaultOrder('id', 'asc');
        $this->setLimit(10);

        $this->addFilterField('id', '=', 'id');
        $this->addFilterField('nome', 'like', 'nome');
        $this->addFilterField('cod_ibge', 'like', 'cod_ibge');
        $this->addFilterField('estado', 'like', 'estado');

        //Criação do formulario 
        $this->form = new BootstrapFormBuilder('formulario estado');
        $this->form->setFormTitle('Cidade');

        //Criação de fields
        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $cod_ibge = new TEntry('cod_ibge');
        $estado = new TDBUniqueSearch('estado_id', 'sample', 'Estado','id',  'nome');

        //Add filds na tela
        $this->form->addFields( [new TLabel('Id')], [ $id ] );
        $this->form->addFields( [new TLabel('Nome')], [ $nome ] );
        $this->form->addFields( [new TLabel('Codigo IBGE')], [ $cod_ibge ] );
        $this->form->addFields( [new TLabel('Estado')], [ $estado ] );

        //Tamanho dos fields
        $id->setSize('100%');
        $nome->setSize('100%');
        $cod_ibge->setSize('100%');
        $estado->setSize('100%');

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
        $column_ibge = new TDataGridColumn('cod_ibge ', 'IBGE', 'left');
        $column_nome = new TDataGridColumn('nome', 'Nome', 'left');
        $column_estado = new TDataGridColumn('estado->uf', 'Estado', 'left');

        //add coluna da datagrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_ibge);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_estado);

        //Criando ações para o datagrid
        $column_id->setAction(new TAction([$this, 'onReload']), ['order'=> 'id']);
        $column_nome->setAction(new TAction([$this, 'onReload']), ['order'=> 'nome']);

        $action1 = new TDataGridAction(['CidadeForm', 'onEdit'], ['id'=> '{id}', 'register_state' => 'false']);
        $action2 = new TDataGridAction([ $this, 'onDelete'], ['id'=> '{id}']);

        //Adicionando a ação na tela
        $this->datagrid->addAction($action1, _t('Edit'), 'fa:edit blue' );
        $this->datagrid->addAction($action2, _t('Delete'), 'fa:trash-alt red' );


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