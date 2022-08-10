<?php

namespace App\Controller;

use App\Entity\Despesas;
use App\Models\ValidacaoAtualizacao;
use App\Models\ValidacaoDespesas;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;



class DespesasController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
        

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        
    }
  
    /**
     * @Route("/despesas", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        //primeiro precisa pegar o corpo da requisição
        $corpoRequisicao = $request->getContent();
        
        
        $dadoEmJson = json_decode($corpoRequisicao);

        $testevalida = new ValidacaoDespesas($this->entityManager);
        $testevalida->validaDespesa($dadoEmJson);
        
        if($testevalida->getResult()){
            $despesa = new Despesas();
            $despesa->setDescricao($dadoEmJson->descricao);
            $despesa->setValor($dadoEmJson->valor);

            $categoria = ['alimentação', 'saúde', 'moradia', 'transporte', 'educação', 'lazer', 'imprevistos'];
            if(in_array($dadoEmJson->categoria, $categoria)){
                $despesa->setCategoria($dadoEmJson->categoria);
            }else{
                $despesa->setCategoria('outras');
            }
            
            $despesa->setData($dadoEmJson->data);

            $mesano = substr($dadoEmJson->data, 3 ,8);

            $despesa->setMesano($mesano);
                    
            
            $this->entityManager->persist($despesa);
            //enviando alteracoes para o banco
            $this->entityManager->flush();
    
            //agora retorna novamente no formato json para testar
            return new JsonResponse($despesa);

        }else{
            "Ja tem esta descricao de despesa inserida neste mes";
        }    
      
    }

    
    /**
     * @Route("/despesas", methods={"GET"})
     *
     */
    public function buscarTodos(): Response
    {        
        //"cria o repositorio"
        $repositorioDeDespesas = $this->entityManager->getRepository(Despesas::class);
        //no repositorio busca todos dados
        $listaDespesas = $repositorioDeDespesas->findAll();

        return new JsonResponse($listaDespesas);
    }

    //metodo para buscar somente informacoes de um medico atraves do id fornecido na url

    /**
     * 
     *@Route("/despesas/{id}", methods={"GET"})
     */
    public function buscarUm(int $id): Response
    {
               
        $despesa= $this->buscaDespesa($id);
        
        $codigoRetorno = is_null($despesa) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($despesa, $codigoRetorno);
    }

    /**
     * 
     *@Route("/despesas/descricao/{descricao}", methods={"GET"})
     */
    public function buscarPorDescricao($descricao): Response
    {
               
        $repositorioDeDespesas = $this->entityManager->getRepository(Despesas::class);
        $receita = $repositorioDeDespesas->findBy(['descricao' => $descricao]);
        
        return new JsonResponse($receita);
    }

     /**
     * 
     *@Route("/despesas/mes/{mesano}", methods={"GET"})
     */
    public function buscarPorAnoMes($mesano): Response
    {
        
        $url = $_SERVER["REQUEST_URI"];
        $urlexplode = explode("/", $url);
        $dataurl = $urlexplode[6];
        $mesano = str_replace("-", "/", $dataurl);
        

        $repositorioDeDespesas = $this->entityManager->getRepository(Despesas::class);
        $receita = $repositorioDeDespesas->findBy(['mesano' => $mesano]);
        
        
        return new JsonResponse($receita);
    }

    /**
     * 
     *@Route("/despesas/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
       
        $dadoEmJson = json_decode($corpoRequisicao);
        
        
        $testevalida = new ValidacaoAtualizacao($this->entityManager);
        $testevalida->validaAtualizacaoD($dadoEmJson);

        
        
        if($testevalida->getResult()){
            $despesaEnviada = new Despesas();
            $despesaEnviada->setDescricao($dadoEmJson->descricao);
            $despesaEnviada->setValor($dadoEmJson->valor);
            $despesaEnviada->setData($dadoEmJson->data);
    
            
            $despesaExistente = $this->buscaDespesa($id);
            if (is_null($despesaExistente)) {
                return new Response('', Response::HTTP_NOT_FOUND);
            }
    
            //vai atribuir os valores digitados para atualizacao para este medico
            $despesaExistente->setDescricao($despesaEnviada->getDescricao())
            ->setValor($despesaEnviada->getValor())
            ->setData($despesaEnviada->getData());
    
            //neste caso nao precisa dar o persist pois a entidade medicoExistente já esta sendo observada pelo doctrine
            //pois foi buscada pelo doctrine...entao para enviar a atualizacao pro banco de dados basta usar o flush() direto
            $this->entityManager->flush();
    
            return new JsonResponse($despesaEnviada);
    
        }else{
            echo "Ja tem esta descricao de despesa inserida neste mes";
        }     
               
        
        
    }

    /**
     * 
     *@Route("/despesas/{id}", methods={"DELETE"})
     */
    public function remove(int $id): Response
    {
        $despesa = $this->buscaDespesa($id);
        $this->entityManager->remove($despesa);
        $this->entityManager->flush();
        
         // retorna vazio e que nao foi encontrado...pois apos executar tera sido deletado
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function buscaDespesa(int $id)
    {
        $repositorioDeDespesas = $this->entityManager->getRepository(Despesas::class);
        $despesa = $repositorioDeDespesas->find($id);
        return $despesa;
    }
}