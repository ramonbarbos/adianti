<?php
use Adianti\Control\TPage;

class CategoriaView extends TPage{

    public function __construct(){
        parent::__construct();


        $html = new THtmlRenderer('app/resources/page-categoria.html'); 

        $replaces=[];
        $html->enableSection('main', $replaces); //HABILITANDO SEÇÃO
        

        parent::add($html);

    }

}