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

class FuncionarioList extends TPage
{
    private $datagrid;
    private $pageNavigation;
    private $loaded;
    private $form;
    
    public function __construct(){

        parent::__construct();



        $this->datagrid =  new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';

        $col_id = new TDataGridColumn('nu_cpfFunc', 'CPF', 'left', '20%');
        $col_matric = new TDataGridColumn('nu_matricula', 'Matricula', 'left', '20%');
        $col_nome = new TDataGridColumn('nm_funcionario', 'Nome', 'left', '60%');

        //Ordenação
        $col_id->setAction( new TAction([$this, 'onReload']), ['order' => 'nu_cpfFunc']);
        $col_nome->setAction( new TAction([$this, 'onReload']), ['order' => 'nm_funcionario']);

        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_matric);
        $this->datagrid->addColumn($col_nome);

        
        // creates two datagrid actions
        $action1 =  new TDataGridAction( ['FuncionarioView' , 'onEdit'] , ['key' => '{nu_cpfFunc}']);
        $action2 =  new TDataGridAction([ $this, 'onDelete'], ['key' => '{nu_cpfFunc}']) ;
        
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

        AdiantiCoreApplication::loadPage('FuncionarioView');
      
       
     
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

            $func =  new Funcionario;
            $func->delete($key);

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

            $repositorio = new TRepository('Funcionario');

            if(empty($param['order'])){
                $param['order'] = 'nu_cpfFunc';
                $param['direction'] = 'asc';
            }

            $limite = 5;

            $criterio = new TCriteria;
            $criterio->setProperty('limit', $limite);
            $criterio->setProperties($param);

            $funcionarios = $repositorio->load( $criterio);

            $this->datagrid->clear();
            if($funcionarios){
                foreach($funcionarios as $funcionario){
                    $this->datagrid->addItem($funcionario);
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