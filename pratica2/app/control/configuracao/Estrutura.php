<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Core\AdiantiCoreApplication;
use Adianti\Database\TCriteria;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Container\THBox;
use Adianti\Widget\Container\TNotebook;
use Adianti\Widget\Container\TPanel;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TTable;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridActionGroup;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Dialog\TQuestion;
use Adianti\Widget\Form\TCheckList;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TDateTime;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TFieldList;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TPassword;
use Adianti\Widget\Form\TText;
use Adianti\Widget\Util\TXMLBreadCrumb;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Widget\Wrapper\TDBSeekButton;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;


class Estrutura extends TPage
{
    private $form;
    private $datagrid;

    public function __construct(){

        parent::__construct();
        
        $this->form = new BootstrapFormBuilder('form');
        $this->form->setFormTitle('Estrutura');

     
       $id = new TEntry('id');
       $id->setEditable(FALSE);
       $id->setSize('10%');

        $customer_id   = new TDBSeekButton('cd_orgao', 'sample', 'form', 'Orgao', 'nm_orgao');
        $customer_name = new TEntry('nm_orgao');
       # $customer_id->setDisplayMask('{nm_orgao}');
        $customer_id->setDisplayLabel('Orgão');
        $customer_id->setAuxiliar($customer_name);
        $customer_name->setEditable(FALSE);
        $customer_id->setSize(80);

        $customer_id2   = new TDBSeekButton('cd_unidOrcamentaria', 'sample', 'form', 'UnidOrcamentaria', 'nm_unidOrcamentaria');
        $customer_name2 = new TEntry('nm_unidOrcamentaria');
       # $customer_id->setDisplayMask('{nm_orgao}');
        $customer_id2->setDisplayLabel('Unid. Orcm');
        $customer_id2->setAuxiliar($customer_name2);
        $customer_name2->setEditable(FALSE);
        $customer_id2->setSize(80);

        $customer_id3   = new TDBSeekButton('sq_setor', 'sample', 'form', 'Setor', 'nm_setor');
        $customer_name3 = new TEntry('nm_setor');
       # $customer_id->setDisplayMask('{nm_orgao} - [cd_orgao]');
        $customer_id3->setDisplayLabel('Setor');
        $customer_id3->setAuxiliar($customer_name3);
        $customer_name3->setEditable(FALSE);
        $customer_id3->setSize(80);

        $this->form->addFields( [new TLabel('Id')], [$id]);
        $this->form->addFields( [new TLabel('Orgão')],   [$customer_id]);
        $this->form->addFields( [new TLabel('Unid. Orcam')],   [$customer_id2]);
        $this->form->addFields( [new TLabel('Setor')],   [$customer_id3]);

        #$this->form->addAction('Save', new TAction(array($this, 'onSave')), 'fa:save');
        $this->form->addAction('Salvar', new TAction( [$this, 'onSave'])); //POST

     
        
        // DataGrid
     

        $this->datagrid =  new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';

        $col_id = new TDataGridColumn('orgao->nm_orgao', 'Orgão', 'right', '33%');
        $col_nome = new TDataGridColumn('unid_orcamentaria->nm_unidOrcamentaria', 'Unid.', 'left', '33%');
        $dt_anoMes = new TDataGridColumn('setor->nm_setor', 'Setor', 'center', '33%');

        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        #$this->datagrid->addColumn($tp_poder);
        $this->datagrid->addColumn($dt_anoMes);

          
        // creates two datagrid actions
        $action1 =  new TDataGridAction( ['Estrutura' , 'onEdit'] , ['key' => '{id}']);
        $action2 =  new TDataGridAction([ $this, 'onDelete'], ['key' => '{id}']) ;
        
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


        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add($this->form);
        $vbox->add(TPanelGroup::pack('', $this->datagrid));
        
        parent::add($vbox);

       

    }
     //Inclusão de Registros
     public  function onSave($param){

   
        try{
            TTransaction::open('sample');

            $this->form->validate();

            $data = $this->form->getData();
            //Orgão
            $setorOrgUnid = new SetorOrgaoUnid;
            $setorOrgUnid->fromArray( (array) $data );
            $setorOrgUnid->dt_ano = date('Y');
            $setorOrgUnid->nu_cnpj = '00642856000160'; #date('Y-m-d H:i:s');
            $setorOrgUnid->store();

            //Jogar objeto para o formulario
            $this->form->setData($setorOrgUnid);

            new TMessage('info', 'Registro salvo com sucesso');


            TTransaction::close();

        }catch (Exception $e){
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    //Medoto de edição
    public  function onEdit($param){

        try{
            TTransaction::open('sample');

            if(isset($param['id'])){

                $key = $param['id'];
                $sou = new SetorOrgaoUnid($key);
                $this->form->setData($sou);

            }else{
                $this->form->clear(true);

            }
           


            TTransaction::close();

        }catch (Exception $e){
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
     
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

            $sou =  new SetorOrgaoUnid;
            $sou->delete($key);

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

            $repositorio = new TRepository('SetorOrgaoUnid');


            $limite = 5;

            $criterio = new TCriteria;
            $criterio->setProperty('limit', $limite);
            $criterio->setProperties($param);

            $estruturas = $repositorio->load( $criterio);

            $this->datagrid->clear();
            if($estruturas){
                foreach($estruturas as $estrutura){
                    $this->datagrid->addItem($estrutura);
                }
            }

            $criterio->resetProperties();
            $count = $repositorio->count($criterio);

          

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