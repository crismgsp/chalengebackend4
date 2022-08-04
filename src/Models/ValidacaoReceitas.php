<?php

namespace App\Models;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\ReceitasController;

class ValidacaoReceitas
{
   

    private $result;
    private $resultBd;
    private $dadoEmJson;

    function getResult()
    {
        return $this->result;
    }

    /** retorna os detalhes do registro */
    function getResultBd()
    {
        return $this->resultBd;
    }

    public function validaReceita($dadoEmJson)
    {
        
        //recebe os dados da tentativa de post e isola a data/mes e o tipo da receita
        $dadosPost = $dadoEmJson;   //este pedaço ta dando erro...irei ver como fazer isso depois...
        //$dadosPostJson = json_decode($dadosPost);

        //var_dump($dadosPost);
        //exit();
        
        $descricaoPost = $dadosPost->descricao;
        $valorPost = $dadosPost->valor;
        $dataPost = $dadosPost->data;

        $mesPost = substr($dataPost, 3 ,8);
        
        var_dump($descricaoPost);
        var_dump($valorPost);
        var_dump($mesPost);
        exit();

        //recebe os dados do banco de dados e isola o mes/ano para cada data e armazena estes dados num array

        // verifica se tem data de mes/anno igual aoo que se quer inserir...caso tenha verifica se ja tem este tipo de despesa

        
    }

}    