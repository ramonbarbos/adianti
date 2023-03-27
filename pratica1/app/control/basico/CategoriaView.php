<?php
use Adianti\Control\TPage;
use Adianti\Control\TWindow;

class CategoriaView extends TPage{

    public function __construct(){
        parent::__construct();

        $windown = TWindow::create('Categorias Cadastradas', 0.6,null);

        $htmlVis = new THtmlRenderer('app/resources/page-visCategoria.html'); 

        $replaces2=[];

        $htmlVis->enableSection('vizualizar', $replaces2); //HABILITANDO SEÇÃO

        #########################################################
        $html = new THtmlRenderer('app/resources/page-categoria.html'); 
        $replaces=[];
        $html->enableSection('main', $replaces); //HABILITANDO SEÇÃO
        

        $windown->add($htmlVis);
        #$windown->show();

        parent::add($html);

    }

}