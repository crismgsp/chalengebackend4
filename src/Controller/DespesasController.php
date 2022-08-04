<?php

namespace App\Controller;

use App\Entity\Despesas;
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

        //$this->dadoEmJson = $dadoEmJson;

        //var_dump($this->dadoEmJson);
        //exit();
        

        $despesa = new Despesas();
        $despesa->setDescricao($dadoEmJson->descricao);
        $despesa->setValor($dadoEmJson->valor);
        $despesa->setData($dadoEmJson->data);
                
        
        $this->entityManager->persist($despesa);
        //enviando alteracoes para o banco
        $this->entityManager->flush();

        //agora retorna novamente no formato json para testar
        return new JsonResponse($despesa);
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
     *@Route("/despesas/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
       
        $dadoEmJson = json_decode($corpoRequisicao);
        
        
        //o teste de validaacao para atualizacao deve ser um pouco diferente...pois se for o mesmo id ele deve permitir que 
        //a o tipo de despesa seja o mesmo que ja tem no banco naquele mes pois as x vai manter a despesa mas atualizar o valor..
        /*$testevalida = new ValidacaoDespesas($this->entityManager);
        $testevalida->validaReceita($dadoEmJson);
        exit(); */
               
        
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