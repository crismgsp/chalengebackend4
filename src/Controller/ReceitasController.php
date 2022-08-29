<?php

namespace App\Controller;

use App\Entity\Receitas;
use App\Models\ValidacaoAtualizacao;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Models\ValidacaoReceitas;




class ReceitasController extends AbstractController
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
     * @Route("/receitas", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        //primeiro precisa pegar o corpo da requisição
        $corpoRequisicao = $request->getContent();
        
        
        $dadoEmJson = json_decode($corpoRequisicao);

        $testevalida = new ValidacaoReceitas($this->entityManager);
        $testevalida->validaReceita($dadoEmJson);
        
        if($testevalida->getResult()){
            $receita = new Receitas();
            $receita->setDescricao($dadoEmJson->descricao);
            $receita->setValor($dadoEmJson->valor);
            
            $receita->setData($dadoEmJson->data);
            
            $mesano = substr($dadoEmJson->data, 3 ,8);

            $receita->setMesano($mesano);

            
            
            $this->entityManager->persist($receita);
            //enviando alteracoes para o banco
            $this->entityManager->flush();
    
            //agora retorna novamente no formato json para testar
            
            return new JsonResponse($receita);

        }else{
            $else = "Ja tem esta descricao de receita inserida neste mes, não pode repetir";
            return new JsonResponse($else);
        }
         
        
    }

    
    /**
     * @Route("/receitas", methods={"GET"})
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

   
    /**
     * 
     *@Route("/receitas/{id}", methods={"GET"})
     */
    public function buscarUm(int $id): Response
    {
               
        $receita = $this->buscaReceita($id);
        
        $codigoRetorno = is_null($receita) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($receita, $codigoRetorno);
    }

    /**
     * 
     *@Route("/receitas/descricao/{descricao}", methods={"GET"})
     */
    public function buscarPorDescricao($descricao): Response
    {
               
        $repositorioDeReceitas = $this->entityManager->getRepository(Receitas::class);
        $receita = $repositorioDeReceitas->findBy(['descricao' => $descricao]);
        
        return new JsonResponse($receita);
    }

     /**
     * 
     *@Route("/receitas/mes/{mesano}", methods={"GET"})
     */
    public function buscarPorAnoMes($mesano): Response
    {
        
        $url = $_SERVER["REQUEST_URI"];
        $urlexplode = explode("/", $url);
        $dataurl = $urlexplode[6];
        $mesano = str_replace("-", "/", $dataurl);
        

        $repositorioDeReceitas = $this->entityManager->getRepository(Receitas::class);
        $receita = $repositorioDeReceitas->findBy(['mesano' => $mesano]);
        
        
        return new JsonResponse($receita);
    }

    /**
     * 
     *@Route("/receitas/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request): Response
    {
        
               
        $corpoRequisicao = $request->getContent();
       
        $dadoEmJson = json_decode($corpoRequisicao);

        
        $testevalida = new ValidacaoAtualizacao($this->entityManager);
        $testevalida->validaAtualizacaoR($dadoEmJson);
      
        
        if($testevalida->getResult()){
            $receitaEnviada = new Receitas();
            $receitaEnviada->setDescricao($dadoEmJson->descricao);
            $receitaEnviada->setValor($dadoEmJson->valor);
            $receitaEnviada->setData($dadoEmJson->data);
    
            
            
            $receitaExistente = $this->buscaReceita($id);
            if (is_null($receitaExistente)) {
                return new Response('', Response::HTTP_NOT_FOUND);
            }
    
           
            $receitaExistente->setDescricao($receitaEnviada->getDescricao())
            ->setValor($receitaEnviada->getValor())
            ->setData($receitaEnviada->getData());
    
            
            $this->entityManager->flush();
    
            return new JsonResponse($receitaEnviada);
    

        }else{
            $erroatualiza = "Atualização não feita, pois já tem uma receita inserida com esta descrição neste mês, não pode repetir";
            return new JsonResponse($erroatualiza);
        }     
        
     
        
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

    public function buscaPorDescricao($descricao)
    {
        $repositorioDeReceitas = $this->entityManager->getRepository(Receitas::class);
        $receita = $repositorioDeReceitas->findby($descricao);
        return $receita;
    }
}