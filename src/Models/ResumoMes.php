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

       
        $valoresReceita = [];

        foreach($receita as $receita1){
            $descricao = $receita1->getDescricao("descricao");
      

            $valor = $receita1->getValor("valor");

            array_push($valoresReceita, $valor ); 
   
        } 

        $somaValoresReceita = array_sum($valoresReceita);
        
       
        // tentar fazer um select agrupando por categoria...groupby 'categoria'

        $repositorioDeDespesas = $this->entityManager->getRepository(Despesas::class);
        $qb = $repositorioDeDespesas->createQueryBuilder('q');
        $query = $qb 
            ->select('q.categoria, SUM(q.valor), q.mesano')
			//fiz uma alteração aqui pois fui testar o resumo e estava vindo incompleto
            ->groupBy('q.categoria', 'q.mesano')
            ->getQuery()->getResult();

        $valoresDespesas = [];
            
        foreach($despesa as $despesa1){
            $descricao = $despesa1->getDescricao("descricao");
            
            $valor = $despesa1->getValor("valor");
                       
            array_push($valoresDespesas, $valor);
           
           
        } 

        $somaValoresDespesa = array_sum($valoresDespesas);

        $saldofinal = ($somaValoresReceita - $somaValoresDespesa);

       
        echo "O valor total das receitas do mês é " . $somaValoresReceita;
        echo PHP_EOL;
        echo "O valor total das despesas do mês é " . $somaValoresDespesa;
        echo PHP_EOL;
        echo "O saldo final do mês é " . $saldofinal;
        echo PHP_EOL;
        echo "Valor total de despesas por categoria neste mês:";
        echo PHP_EOL;

       
        $url = $_SERVER["REQUEST_URI"];
        $urlexplode = explode("/", $url);
        $dataurl = $urlexplode[5];
        $mesano = str_replace("-", "/", $dataurl);
        
    
        $queryMesano = [];

        foreach($query as $querysemfiltro){
            if($querysemfiltro['mesano'] === $mesano){
                array_push($queryMesano, $querysemfiltro);
            }
        }

        
        foreach($queryMesano as $categoria){
            
            $categorias = $categoria["categoria"];
            
            $valor = $categoria[1];

            echo "Categoria  $categorias   -> Valor:  $valor";
            echo PHP_EOL;
          
        } 

    }

}    