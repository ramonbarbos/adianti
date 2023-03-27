<?php

use Adianti\Control\TWindow;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;

class ModalWindowView extends TWindow{

    public function __construct()
    {
        parent::__construct();
        #parent::setTitle("Titulo da Jenela");
        parent::setSize(0.6, null); //Tamanho da janela
        parent::removePadding(); //Remover espaçamento dentro da janela
        parent::removeTitleBar(); //Tirando o title bar
        parent::disableEscape(); //Impedir de fechar a janela

             $html = new THtmlRenderer('app/resources/page-visCategoria.html'); 

            $replaces = [];
          

            $html->enableSection('vizualizar', $replaces); //HABILITANDO SEÇÃO

            parent::add($html);

    }
}