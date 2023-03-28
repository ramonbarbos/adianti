<?php

use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;
use Adianti\Database\TTransaction;

class ObjectCreate extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try{
            TTransaction::open('sample');

            Categoria::create([
                'nome' => 'Ramon'
            ]);

            new TMessage('info', 'Produto Gravado');

            TTransaction::close();
             
        }catch (Exception $e){
            new TMessage('error', $e->getMessage());
        }
    }
}