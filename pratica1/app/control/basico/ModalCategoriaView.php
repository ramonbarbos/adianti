<?php

use Adianti\Control\TWindow;
use Adianti\Database\TTransaction;
use Adianti\Widget\Template\THtmlRenderer;

class ModalCategoriaView extends TWindow{

    public function __construct()
    {
        parent::__construct();
        parent::setTitle("Categorias registradas");
        parent::setSize(0.6, null); //Tamanho da janela
        parent::removePadding(); //Remover espaçamento dentro da janela
        #parent::removeTitleBar(); //Tirando o title bar
        #parent::disableEscape(); //Impedir de fechar a janela

             $html = new THtmlRenderer('app/resources/page-visCategoria.html'); 

          
            $conn = TTransaction::open('sample');

            $result = $conn->query('SELECT * FROM `teste`');

            foreach($result as $row){
              echo $id = $row['id'];
              echo  $nome = $row['nome'];

            }

            $replaces = [];
            $replaces['id']  = $id;
            $replaces['nome']  = $nome;

            $html->enableSection('vizualizar', $replaces); //HABILITANDO SEÇÃO

            parent::add($html);

    }
}