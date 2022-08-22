<?php

namespace App\Security;

use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JwtAutenticador extends AbstractGuardAuthenticator
{
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // TODO: este metodo inicializa algumas coisas..por enquanto nao iremos precisar
    }

    public function supports(Request $request)
    {
        // vai retornar true pra todas rotas...menos a de login (que é onde o usuario insere o usuario e senha pra gerar o token)
        return $request->getPathInfo() !== '/login';
    }

    public function getCredentials(Request $request)
    {
        // buscar as credenciais, e tira a palavra bearer que tem a ver com o metodo que escolheu la no postman e vai inserir esta palavra
        //ai tem que tirar ela pra conferir certinho
        
        $tokenapache = str_replace('Bearer ', '', apache_request_headers());
        
        $tokenapache = $tokenapache['Authorization'];
       
        try{
            return JWT::decode($tokenapache, new Key('chave', 'HS256'));
        }catch(\Exception $e) {
            return false;
        }
        //fazer um teste com o basicauth
        //$token = str_replace('Basic ', '', $request->headers->get('Authorization') );
        
        

        try{
            return JWT::decode($tokenapache, 'chave', ['HS256']);
        }catch(\Exception $e) {
            return false;
        }
         
    }

    //busca o usuario a partir das credenciais (retornadas no metodo acima) 
    //$credentials é o que vem de retorno dentro do try no metodo acima
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // se nas credenciais nao existir o username ira retornar null (que diz na documentacao que se fizer isso retorna uma exceção)
        //se credentials nao for um objeto retorna null tambem
        if(!is_object($credentials) || !property_exists($credentials, 'username')){
            return null;
        }
        //caso contrario vai buscar o usuario no repositorio e
        $username = $credentials->username;
        return $this->repository->findOneBy(['username' => $username]);
    }

    //verifica se a credencial esta valida..se tiver vai retornar true,e ntao vai retornar isso se a credencial for um objeto e tiver 
    // a propriedade username
    public function checkCredentials($credentials, UserInterface $user)
    {
        return is_object($credentials) &&  property_exists($credentials, 'username');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // o que ocorre quando a autenticacao falhar, se retornar null a requisicao continua, o que nao e pra ocorrer
        return new JsonResponse(
            ['erro' => 'Falha na autenticação'], Response::HTTP_UNAUTHORIZED
        );

    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        //  o que ocorre quando a autenticacao ocorrer com sucesso, se retornar null a requisicao acontece normalmente
        return null;

    }

    public function supportsRememberMe()
    {
        // como e uma api ..este aqui nao vai ficar ativado..entao vai retornar false...
        return false;
    }
}
