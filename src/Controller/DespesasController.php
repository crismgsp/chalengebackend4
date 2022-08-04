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
        

        $receita = new Receitas();
        $receita->setDescricao($dadoEmJson->descricao);
        $receita->setValor($dadoEmJson->valor);
        $receita->setData($dadoEmJson->data);
        //$receita->setMesano($mesano); nao funcionou inserir isto pelo get... apaguei esta coluna
        
        
        $this->entityManager->persist($receita);
        //enviando alteracoes para o banco
        $this->entityManager->flush();

        //agora retorna novamente no formato json para testar
        return new JsonResponse($receita);
    }

    
    /**
     * @Route("/despesas", methods={"GET"})
     *
     */
    public function buscarTodos(): Response
    {        
        //"cria o repositorio"
        $repositorioDeReceitas = $this->entityManager->getRepository(Receitas::class);
        //no repositorio busca todos dados
        $listaReceitas = $repositorioDeReceitas->findAll();

        return new JsonResponse($listaReceitas);
    }

    //metodo para buscar somente informacoes de um medico atraves do id fornecido na url

    /**
     * 
     *@Route("/despesas/{id}", methods={"GET"})
     */
    public function buscarUm(int $id): Response
    {
               
        $receita = $this->buscaReceita($id);
        
        $codigoRetorno = is_null($receita) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($receita, $codigoRetorno);
    }

    /**
     * 
     *@Route("/despesas/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request): Response
    {
        //$id = $request->get('id'); colocou como argumento ai nao precisou mais pegar assim

        //vai receber os dados enviados para atualizacao, do corpo da requisição 
        $corpoRequisicao = $request->getContent();
       
        $receitaEnviada = $this->medicoFactory->criarMedico($corpoRequisicao);

        //vai achar este medico ja existente no repositorio
        
        $receitaExistente = $this->buscaReceita($id);
        if (is_null($receitaExistente)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        //vai atribuir os valores digitados para atualizacao para este medico
        $receitaExistente->setDescricao($receitaEnviada->getDescricao())
        ->setValor($receitaEnviada->getValor())
        ->setData($receitaEnviada->getData());

        //neste caso nao precisa dar o persist pois a entidade medicoExistente já esta sendo observada pelo doctrine
        //pois foi buscada pelo doctrine...entao para enviar a atualizacao pro banco de dados basta usar o flush() direto
        $this->entityManager->flush();

    }

    /**
     * 
     *@Route("/receitas/{id}", methods={"DELETE"})
     */
    public function remove(int $id): Response
    {
        $receita = $this->buscaReceita($id);
        $this->entityManager->remove($receita);
        $this->entityManager->flush();
        
         // retorna vazio e que nao foi encontrado...pois apos executar tera sido deletado
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function buscaReceita(int $id)
    {
        $repositorioDeReceitas = $this->entityManager->getRepository(Receitas::class);
        $receita = $repositorioDeReceitas->find($id);
        return $receita;
    }
}