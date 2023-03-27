<?php
use Adianti\Control\TPage;
use Adianti\Control\TWindow;
use Adianti\Widget\Template\THtmlRenderer;

class CategoriaView extends TPage{

    public function __construct(){
        parent::__construct();

      

        #########################################################
        $html = new THtmlRenderer('app/resources/page-categoria.html');
     
        $html->enableSection('main'); //HABILITANDO SEÇÃO

        parent::add($html);

    }

}