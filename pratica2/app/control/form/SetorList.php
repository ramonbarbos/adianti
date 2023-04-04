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

class SetorList extends TPage
{
    private $datagrid;
    private $pageNavigation;
    private $loaded;
    
    public function __construct(){

        parent::__construct();



        $this->datagrid =  new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';

        $col_id = new TDataGridColumn('sq_setor', 'Numero', 'right', '10%');
        $col_nome = new TDataGridColumn('nm_setor', 'Nome', 'left', '40%');
        #$col_responsavel = new TDataGridColumn('sq_unidade', 'UNI', 'left', '40%');
        #$col_estado = new TDataGridColumn('estado->nome', 'Estado', 'center', '30%');

        //Ordenação
        $col_id->setAction( new TAction([$this, 'onReload']), ['order' => 'sq_setor']);
        $col_nome->setAction( new TAction([$this, 'onReload']), ['order' => 'nm_setor']);

        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);

        $action1 =  new TDataGridAction( ['SetorView' , 'onEdit'] , ['key' => '{sq_setor}']);
        $action2 =  new TDataGridAction([ $this, 'onDelete'], ['key' => '{sq_setor}']) ;

      

        $this->datagrid->addAction($action1, 'Editar');
        $this->datagrid->addAction($action2, 'Excluir');

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

        AdiantiCoreApplication::loadPage('SetorView');
      
       
     
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

            $setor =  new Setor;
            $setor->delete($key);

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

            $repositorio = new TRepository('Setor');

            if(empty($param['order'])){
                $param['order'] = 'sq_setor';
                $param['direction'] = 'asc';
            }

            $limite = 5;

            $criterio = new TCriteria;
            $criterio->setProperty('limit', $limite);
            $criterio->setProperties($param);

            $setores = $repositorio->load( $criterio);

            $this->datagrid->clear();
            if($setores){
                foreach($setores as $setor){
                    $this->datagrid->addItem($setor);
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