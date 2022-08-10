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
        
        $dataPost = $dadosPost->data;

        $mesPost = substr($dataPost, 3 ,8);

        $dadosAPostar = $descricaoPost . $mesPost;
        
       
        
        //recebe os dados do banco de dados e isola o mes/ano para cada data e armazena estes dados num array
        $repositorioDeReceitas = $this->entityManager->getRepository(Receitas::class);
        $receita = $repositorioDeReceitas->findAll();

        //array que vai armazenar os dados de descricao e data concatenados
        $DescricaoDataBD = [];

        foreach($receita as $receita1){
            $descricao = $receita1->getDescricao("descricao");
            
            $data = $receita1->getData("data");
            
            $dataMes = substr($data, 3, 8);

           
            $dadosBD = $descricao . $dataMes;

            array_push($DescricaoDataBD, $dadosBD);
           
        }

        //verifica se no array ja tem a receita ou despesa inserida com a mesma descricao para o mesmo mes
        if(in_array($dadosAPostar, $DescricaoDataBD)){
            $this->result = false;
        }else{
            $this->result = true;
        }

       
        
    }

}    