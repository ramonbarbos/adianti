<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Container\TPanel;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Dialog\TQuestion;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Control\TWindow;
use Adianti\Core\AdiantiCoreApplication;
use Adianti\Widget\Datagrid\TDataGridActionGroup;

class OrgaoList extends TPage
{
    private $datagrid;
    private $pageNavigation;
    private $loaded;
    private $form;
    
    public function __construct(){

        parent::__construct();



        $this->datagrid =  new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        $this->datagrid->enablePopover('Details', '<b>Code:</b> {cd_orgao} <br> <b>Name:</b> {nm_orgao} <br> <b>Ano/Mes:</b> {dt_anoMes}');

        $col_id = new TDataGridColumn('cd_orgao', 'Código', 'right', '10%');
        $col_nome = new TDataGridColumn('nm_orgao', 'Nome', 'left', '80%');
        $dt_anoMes = new TDataGridColumn('dt_anoMes', 'Ano/Mês', 'center', '10%');
        #$col_estado = new TDataGridColumn('estado->nome', 'Estado', 'center', '30%');

        //Ordenação
        $col_id->setAction( new TAction([$this, 'onReload']), ['order' => 'sq_produto']);
        $col_nome->setAction( new TAction([$this, 'onReload']), ['order' => 'nm_produto']);

        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        #$this->datagrid->addColumn($tp_poder);
        $this->datagrid->addColumn($dt_anoMes);

         // creates two datagrid actions
         $action1 =  new TDataGridAction( ['OrgaoView' , 'onEdit'] , ['key' => '{cd_orgao}']);
         $action2 =  new TDataGridAction([ $this, 'onDelete'], ['key' => '{cd_orgao}']) ;
         
         $action1->setLabel('Editar');
         $action1->setImage('fa:search #7C93CF');
         
         $action2->setLabel('Deletar');
         $action2->setImage('far:trash-alt red');

         
         $action_group = new TDataGridActionGroup('Ações ', 'fa:th');
         
         $action_group->addHeader('Opçoes');
         $action_group->addAction($action1);
         $action_group->addAction($action2);
         #$action_group->addSeparator();
         #$action_group->addHeader('Another Options');
         
         // add the actions to the datagrid
         $this->datagrid->addActionGroup($action_group);

        $this->datagrid->createModel();


        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction( new TAction([$this, 'onReload']));

        #$this->pageNavigation->setAction('Voltar', new TAction( [$this, 'onForm']));


        $panel = new TPanelGroup;
        $panel->add($this->datagrid);
        $panel->add($this->form);
        $panel->addFooter($this->pageNavigation);

       parent::add($panel);

       

    }
      //Cadastro
      public  function onForm($param){

        AdiantiCoreApplication::loadPage('OrgaoView');
      
       
     
    }

     //Limpeza de Formulario
     public  function onDelete($param){
        $action =  new TAction( [__CLASS__, 'Delete'] );
        $action->setParameters($param);
       new TQuestion('Deseja ecluir o registro?', $action);
     
    }

    public  function Delete($param){
        try{
            TTransaction::open('sample');

            $key = $param['key'];

            $orgao =  new Orgao;
            $orgao->delete($key);

            $pos_action = new TAction( [__CLASS__, 'onReload'] );
            
            new TMessage('info', 'Registro Apagado', $pos_action);
            

            TTransaction::close();

        }catch (Exception $e){
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
     
    }
    public  function onReload($param){
        try{
            TTransaction::open('sample');

            $repositorio = new TRepository('Orgao');

            if(empty($param['order'])){
                $param['order'] = 'cd_orgao';
                $param['direction'] = 'asc';
            }

            $limite = 5;

            $criterio = new TCriteria;
            $criterio->setProperty('limit', $limite);
            $criterio->setProperties($param);

            $orgaos = $repositorio->load( $criterio);

            $this->datagrid->clear();
            if($orgaos){
                foreach($orgaos as $orgao){
                    $this->datagrid->addItem($orgao);
                }
            }

            $criterio->resetProperties();
            $count = $repositorio->count($criterio);

            $this->pageNavigation->setCount($count);
            $this->pageNavigation->setProperties($param);
            $this->pageNavigation->setLimit($limite);

            $this->loaded = true;
            TTransaction::close();

        }catch (Exception $e){
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
     
    }

    function show(){
        if(!$this->loaded){
            $this->onReload( func_get_arg(0));
        }
        parent::show();
    }

}