<?php

namespace App\Tests\Service;

//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
//use App\Controller\DespesasController;
use App\Entity\Despesas;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\JsonResponse;

//testa se está inserindo o Post feito e se não insere a mesma descrição para o mesmo mes/ano

class DespesasTest extends WebTestCase

{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    private Request $request;
        

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        
    } 

    public function testPost()
    {
        $despesa = new DespesasController();
        $despesa->novo($request);

        $request = 
    
         

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












