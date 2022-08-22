<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateUserController extends AbstractController
{
    private $userRepository;
    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }
  
     

    /**
     * @Route("/criausuario", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $dadosRequest = $request->getContent();
        
        $usuario = $this->criarEntidade($dadosRequest);

        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        return new JsonResponse($usuario);
    }

    public function criarEntidade(string $json): User
    {
        $dadoEmJson = json_decode($json);
        
        $usuario = new User();
        $usuario->setUsername($dadoEmJson->usuario)
        ->setPassword($dadoEmJson->senha);
       
        return $usuario;

    }
}    