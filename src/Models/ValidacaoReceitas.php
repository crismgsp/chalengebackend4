<?php

namespace App\Models;
use App\Entity\Receitas;


use Doctrine\ORM\EntityManagerInterface;

class ValidacaoReceitas
{
   

    private $result;
    private $resultBd;
    private $dadoEmJson;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        
    }

    function getResult()
    {
        return $this->result;
    }

    /** retorna os detalhes do registro */
    function getResultBd()
    {
        return $this->resultBd;
    }

    //vai receber este $dadoEmJson la no controller 
    public function validaReceita($dadoEmJson)
    {
        
        //recebe os dados da tentativa de post e isola a data/mes e o tipo da receita
        $dadosPost = $dadoEmJson;   
       
        
        $descricaoPost = $dadosPost->descricao;
        $valorPost = $dadosPost->valor;
        $dataPost = $dadosPost->data;

        $mesPost = substr($dataPost, 3 ,8);
        
        //recebe os dados do banco de dados e isola o mes/ano para cada data e armazena estes dados num array
        $repositorioDeReceitas = $this->entityManager->getRepository(Receitas::class);
        $receita = $repositorioDeReceitas->findAll();

        var_dump($receita);  

        

        //var_dump($datasreceita);

        //neste var_dump recebi um array de objetos...      
        //preciso isolar as datas e fazer um foreach pra 
        //formatar cada data  com o substr($dataPost, 3 ,8) e armazenar num array..ai uso um in_array pra verificar se ja tem a data
        //igual a ser inserida..caso tenha verifico se pra esta data ja tem a descricao igual a que vai ser inserida



        // verifica se tem data de mes/anno igual aoo que se quer inserir...caso tenha verifica se ja tem este tipo de despesa

        
    }

}    