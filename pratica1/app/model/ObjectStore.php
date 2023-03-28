<?php

use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;
use Adianti\Database\TTransaction;

class ObjectStore extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try{
            TTransaction::open('sample');

        
            $categoria = new Categoria;
            $categoria->nome = 'Kary';

            TTransaction::close();
             
        }catch (Exception $e){
            new TMessage('error', $e->getMessage());
        }
    }
}