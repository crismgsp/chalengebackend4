<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends AbstractController
{
    private $repository;

    public function __construct(UserRepository $repository, UserPasswordEncoderInterface $encoder)
    {
        $this->repository = $repository;
        $this->encoder = $encoder;
    }
    //o usuario ira enviar os dados de usuario e senha...como vai descobrir se tem este usuario cadastrado no banco de dados?
    /**
     * @Route("/login", name="app_login")
     */
    public function index(Request $request): JsonResponse
    {
        //pegando os dados passados na requisição nesta rota login (nome usuario e senha)
        $dadosEmJson = json_decode($request->getContent());
        if(is_null($dadosEmJson->usuario) || is_null($dadosEmJson->senha)){
            return new JsonResponse([
                'erro' => 'Favor enviar usuário e senha'
            ], Response::HTTP_BAD_REQUEST);
        }
                
        //vai buscar os dados de usuarios para checar se tem este usuario no banco de dados
        $user = $this->repository->findOneBy(['username' => $dadosEmJson->usuario]);
        

        //se encontrar o usuario vai verificar se a senha bate com a senha deste usuario no banco, caso seja diferente retorna uma msg e 
        //o status de nao autorizado... se bater se bater retorna
        if(!$this->encoder->isPasswordValid($user, $dadosEmJson->senha)){
            return new JsonResponse([
                'erro' => 'Usuario ou senha inválidos'
            ],  Response::HTTP_UNAUTHORIZED);
        }
      
        $token = JWT::encode(['username' => $user->getUsername()], 'chave', 'HS256' );
        
        //vai retornar este token para o usuario
        return new JsonResponse(
            ['access_token' => $token]
        );
    }
}