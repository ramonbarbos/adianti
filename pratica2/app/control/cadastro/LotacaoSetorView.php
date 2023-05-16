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


class LotacaoSetorView extends TPage
{
    private $form;
    private $datagrid;

    public function __construct(){

        parent::__construct();
        
        $this->form = new BootstrapFormBuilder('form');
        $this->form->setFormTitle('Lotação Setor');

     
      

        $customer_func   = new TDBSeekButton('nu_cpfFunc', 'sample', 'form', 'Funcionario', 'nm_funcionario');
        $customer_name = new TEntry('nm_funcionario');
        #$customer_id->setDisplayMask('{nu_cpfFunc}');
        $customer_func->setDisplayLabel('Nome');
        $customer_func->setAuxiliar($customer_name);
        $customer_name->setEditable(FALSE);
        $customer_func->setSize(100);

        $this->form->addFields( [new TLabel('Funcionario')],   [$customer_func]);
        


      

     
        $subform = new BootstrapFormBuilder;
        $subform->setFieldSizes('100%');
        $subform->setProperty('style', 'border:none');
        $dt_inicio    = new TDate('dt_inicio');

        $subform->appendPage( 'Dados' );


        $customer_orgao   = new TDBSeekButton('cd_orgaoEstru', 'sample', 'form', 'Orgao', 'cd_orgao');
        $customer_nmOrgao = new TEntry('nm_orgao');
        $customer_orgao->setDisplayMask('{cd_orgao} - {nm_orgao}');
        $customer_orgao->setDisplayLabel('Orgão');
        $customer_orgao->setAuxiliar($customer_nmOrgao);
        $customer_nmOrgao->setEditable(FALSE);
        $customer_orgao->setSize(100);
        $dt_inicio->setMask('dd/mm/yyyy');
        $dt_inicio->setDatabaseMask('yyyy-mm-dd');
        $row = $subform->addFields( [new TLabel('Data Inicio')], [$dt_inicio]);
       
        $row->layout = ['col-sm-2', 'col-sm-0', 'col-sm-0'];

        $row = $subform->addFields( [ new TLabel('Orgão'),      $customer_orgao ]);
        $row->layout = ['col-sm-6', 'col-sm-3', 'col-sm-3'];

        $customer_unid   = new TDBSeekButton('cd_unidEstru', 'sample', 'form', 'UnidOrcamentaria', 'cd_unidOrcamentaria');
        $customer_nmUnid = new TEntry('nm_unidOrcamentaria');
        $customer_unid->setDisplayMask('{cd_unidOrcamentaria} - {nm_unidOrcamentaria}');
        $customer_unid->setDisplayLabel('Unid Orca.');
        $customer_unid->setAuxiliar($customer_nmUnid);
        $customer_nmUnid->setEditable(FALSE);
        $customer_unid->setSize(100)
        ;
        $row = $subform->addFields( [ new TLabel('Unid Orca.'),      $customer_unid ]);
        $row->layout = ['col-sm-6', 'col-sm-3', 'col-sm-3'];

        $customer_setor   = new TDBSeekButton('cd_setorEstru', 'sample', 'form', 'Setor', 'sq_setor');
        $customer_nmSetor = new TEntry('nm_setor');
        $customer_setor->setDisplayMask('{sq_setor} - {nm_setor}');
        $customer_setor->setDisplayLabel('Setor.');
        $customer_setor->setAuxiliar($customer_nmSetor);
        $customer_nmSetor->setEditable(FALSE);
        $customer_setor->setSize(100)
        ;
        $row = $subform->addFields( [ new TLabel('Setor'),      $customer_setor ]);
        $row->layout = ['col-sm-6', 'col-sm-3', 'col-sm-3'];

        $this->form->addAction('Salvar', new TAction( [$this, 'onSave'])); //POST
        $this->form->addActionLink('Limpar', new TAction( [$this, 'onClear']));

        $this->form->addContent( [$subform] );
        
        // DataGrid - Listagem
    


        $this->datagrid =  new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';


        $col_cpf = new TDataGridColumn('nu_cpfFunc', 'CPF', 'left', '20%');
        $col_id = new TDataGridColumn('orgao->nm_orgao', 'Orgão', 'left', '20%');
        $col_nome = new TDataGridColumn('unid_orcamentaria->nm_unidOrcamentaria', 'Unid.', 'left', '20%');
        $col_setor = new TDataGridColumn('setor->nm_setor', 'Setor', 'left', '20%');
        $col_date = new TDataGridColumn('dt_inicio', 'Inicio', 'left', '20%');
        $this->datagrid->addColumn($col_cpf);
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        $this->datagrid->addColumn($col_setor);
        $this->datagrid->addColumn($col_date);

          
        // creates two datagrid actions
        $action1 =  new TDataGridAction( ['LotacaoSetorView' , 'onEdit'] , ['key' => '{sq_lotacao}']);
        $action2 =  new TDataGridAction([ $this, 'onDelete'], ['key' => '{sq_lotacao}']) ;
        
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
            $sotacaoSetor = new Lotacao;
            $sotacaoSetor->fromArray( (array) $data );
            $sotacaoSetor->store();

            //Jogar objeto para o formulario
            $this->form->setData($sotacaoSetor);

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

            if(isset($param['sq_lotacao'])){

                $key = $param['sq_lotacao'];
                $lotacao = new Lotacao($key);
                $this->form->setData($lotacao);

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
    public  function onClear($param){

        $this->form->clear(true);
     
    }
      public  function onDelete($param){
        $action =  new TAction( [__CLASS__, 'Delete'] );
        $action->setParameters($param);
       new TQuestion('Deseja ecluir o registro?', $action);
     
    }
    public  function Delete($param){
        try{
            TTransaction::open('sample');

            $key = $param['key'];

            $lotacao =  new Lotacao;
            $lotacao->delete($key);

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

            $repositorio = new TRepository('Lotacao');


            $limite = 5;

            $criterio = new TCriteria;
            $criterio->setProperty('limit', $limite);
            $criterio->setProperties($param);

            $lotacaos = $repositorio->load( $criterio);

            $this->datagrid->clear();
            if($lotacaos){
                foreach($lotacaos as $lotacao){
                    $this->datagrid->addItem($lotacao);
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