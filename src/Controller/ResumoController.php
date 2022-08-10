<?php

namespace App\Controller;

use App\Entity\Receitas;
use App\Entity\Despesas;
use App\Models\ResumoMes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;




class ResumoController extends AbstractController
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
     * 
     *@Route("/resumo/{mesano}", methods={"GET"})
     */
    public function buscarPorAnoMes($mesano): Response
    {
        
        $url = $_SERVER["REQUEST_URI"];
        $urlexplode = explode("/", $url);
        $dataurl = $urlexplode[5];
        $mesano = str_replace("-", "/", $dataurl);
        

       $resposta = new ResumoMes($this->entityManager);
       $resposta->resumoMes($mesano);
        
        
        return new JsonResponse($resposta);
    }
}  