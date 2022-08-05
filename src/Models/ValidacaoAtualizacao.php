<?php

namespace App\Models;
use App\Entity\Despesas;
use App\Entity\Receitas;


use Doctrine\ORM\EntityManagerInterface;

class ValidacaoAtualizacao
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
    public function validaAtualizacaoD($dadoEmJson)
    {
        
        //recebe os dados da tentativa de post e isola a data/mes e o tipo da receita
        $dadosPost = $dadoEmJson;   

        

        $descricaoPost = $dadosPost->descricao;
        
        
        $dataPost = $dadosPost->data;

        $url = $_SERVER["REQUEST_URI"];

        
        $dataId = substr($url, -1);

        $mesPost = substr($dataPost, 3 ,8);

        $dadosAAtualizar = $descricaoPost . $mesPost . $dataId;

        $repositorioDeDespesas = $this->entityManager->getRepository(Despesas::class);
        $despesa = $repositorioDeDespesas->findAll();

        //var_dump($despesa);

        //array que vai armazenar os dados de descricao e data concatenados
        $AtualizacaoDataBD = [];

        foreach($despesa as $despesa1){
            $descricao = $despesa1->getDescricao("descricao");
            
            $data = $despesa1->getData("data");
            
            $dataMes = substr($data, 3, 8);

            $dadosBD = $descricao . $dataMes . $dataId;

            array_push($AtualizacaoDataBD, $dadosBD);
                      
        }
       
        //var_dump($AtualizacaoDataBD);
        //echo PHP_EOL;
        //var_dump($dadosAAtualizar);
        //exit();
        
        //se tiver este dado de mesmo id...descricao e mes pode retornar true..pois vai poder atualizar
        //mesmmo ja tendo esta despesa neste mes...que no caso é do mesmo id....caso nao ainda passa por outra validacao...
       if(in_array($dadosAAtualizar, $AtualizacaoDataBD)){
        $this->result = true;   
       }else{
        $this->validaDespesa;
       }
    
    }

    public function validaDespesa($dadoEmJson)
    {
        $dadosPost = $dadoEmJson;

        $descricaoPost = $dadosPost->descricao;
        
        $dataPost = $dadosPost->data;

        $mesPost = substr($dataPost, 3 ,8);

        $dadosAPostar = $descricaoPost . $mesPost;
        //var_dump($dadosAPostar);
        
        //recebe os dados do banco de dados e isola o mes/ano para cada data e armazena estes dados num array
        $repositorioDeDespesas = $this->entityManager->getRepository(Despesas::class);
        $despesa = $repositorioDeDespesas->findAll();

        //array que vai armazenar os dados de descricao e data concatenados
        $DescricaoDataBD = [];

        foreach($despesa as $despesa1){
            $descricao = $despesa1->getDescricao("descricao");
            
            $data = $despesa1->getData("data");
            
            $dataMes = substr($data, 3, 8);

           
            $dadosBD = $descricao . $dataMes;

            array_push($DescricaoDataBD, $dadosBD);

                      
        }

             

        //verifica se no array ja tem a  despesa inserida com a mesma descricao para o mesmo mes
        if(in_array($dadosAPostar, $DescricaoDataBD)){
            $this->result = false;
        }else{
            $this->result = true;
        }
    }

}    