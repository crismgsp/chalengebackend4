<?php

namespace App\Models;
use App\Entity\Despesas;
use App\Entity\Receitas;

use Doctrine\ORM\EntityManagerInterface;

class ResumoMes
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
    public function resumoMes($mesano)
    {
        
        $repositorioDeDespesas = $this->entityManager->getRepository(Despesas::class);
        $despesa = $repositorioDeDespesas->findBy(['mesano' => $mesano]);

        $repositorioDeReceitas = $this->entityManager->getRepository(Receitas::class);
        $receita = $repositorioDeReceitas->findBy(['mesano' => $mesano]);

        var_dump($despesa);
        var_dump($receita);
        exit();

        //array que vai armazenar os dados de descricao e data concatenados
        /*$DescricaoDataBD = [];

        foreach($receita as $receita1){
            $descricao = $receita1->getDescricao("descricao");
            
            $data = $receita1->getData("data");
            
            $dataMes = substr($data, 3, 8);

           
            $dadosBD = $descricao . $dataMes;

            array_push($DescricaoDataBD, $dadosBD);
           
        } */

       
       
        
    }

}    