<?php

namespace App\Tests\Service;

require 'vendor/autoload.php';

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;
use App\Controller\DespesasController;
use App\Entity\Despesas;
use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;


//testa se está inserindo o Post feito e se não insere a mesma descrição para o mesmo mes/ano

class DespesasTest extends TestCase

{

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        
    }

     
        
    //inserindo informacoes que serão usadas em alguns testes...esta funcao sera passada depois com o dataprovider para alguns testes...
    public function postando()
    {
            $client = new Client(array(['http://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php', 'request.options' => array('exceptions' => false,)]));
            $data = '02/01/2012';

            $data2 = '10/01/2012';

            //mesano sera o mesmo para todas datas pois todas insercoes do teste serão do mesmo mes
            $mesano = substr($data, 3 ,8);
    
            $dados = array('descricao' => 'supermercado', 'valor' => 210, 
            'mesano' => $mesano, 'categoria' => 'alimentação', 'data' => $data);

            //vai tentar inserir a despesa com a mesma descrição para o mesmo mes...nao é para permitir
            $dados2 = array('descricao' => 'supermercado', 'valor' => 210, 
            'mesano' => $mesano, 'categoria' => 'alimentação', 'data' => $data2);

            //vai inserir uma outra despesa no mesmo mes
            $dados3 = array('descricao' => 'papelaria', 'valor' => 500, 
            'mesano' => $mesano, 'categoria' => 'educação', 'data' => $data2);
            //inserir uma terceira despesa diferente no mesmo mes
            $dados4 = array('descricao' => 'mercearia', 'valor' => 43, 
            'mesano' => $mesano, 'categoria' => 'alimentação', 'data' => $data);

            //envio dados 1
            
            //banco de dados de teste
            
            
            $request = $this->httpClient->request('POST', 'http://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas', json_encode($dados) );
            $request = $this->httpClient->request('POST', 'http://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas', json_encode($dados2) );
            $request = $this->httpClient->request('POST', 'http://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas', json_encode($dados3) );
            $request = $this->httpClient->request('POST', 'http://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas', json_encode($dados4) );
            
            $response = $client->send($request);
            
            /*$request = $client->post('http://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas', null,
            json_encode($dados));
            $response = $request->send();
            //tentativa de envio de dado com descricao repetida para mesmo mes
            $request = $client->post('http://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas', null,
            json_encode($dados2));
            $response = $request->send();
            //envio de segunda despesa diferente
            $request = $client->post('http://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas', null,
            json_encode($dados3));
            $response = $request->send();
            //envio de terceira despesa diferente
            $request = $client->post('http://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas', null,
            json_encode($dados4));
            $response = $request->send(); */

            

            
    }
   
    

   public function testDespesas()
   {
        $url = "http://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas";
        $despesas1 = curl_init($url);
        //para transformar num array
        curl_setopt($despesas1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($despesas1, CURLOPT_SSL_VERIFYPEER, false);
        $despesas = json_decode(curl_exec($despesas1));
        //var_dump($despesas);
        //exit();
        /*array(1) {
        [0]=>
        object(stdClass)#1 (6) {
        ["id"]=>  int(1)    ["descricao"]=>  string(9) "papelaria"   ["valor"]=>
        int(15)    ["categoria"]=>   string(10) "educação"
        ["data"]=>   string(10) "08/07/2022"
        ["mesano"]=>   string(7) "07/2022" */
  }
   

    //vai importar os dados do banco de dados pra ser usada nos testes acima..verificar se o que foi importado 
    //corresponde ao que vai ser testado
    function importaDadosBd()
    {
        $repositorioDeDespesas = $this->entityManager->getRepository(Despesas::class);
        $despesa = $repositorioDeDespesas->findAll;
        return $despesa; 
    }

}












