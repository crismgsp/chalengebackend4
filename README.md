<h1 align="center"><strong>Challenge Backend4 Alura :heart: </strong></h1><br>

<strong>Resumo do que foi proposto para este Chalenge:</strong><br><br>
<strong><p>Semana 1  </p></strong>
Implementar uma API REST: implementar nela o CRUD de receitas e de despesas, seguindo algumas validações e regras de negócio,
implementar rotas para que sejam feitas requisicções HTTP, usar o Postman para testar estas requisições
Não pode repetir a mesma descrição de despesa e receita para o mesmo mês/ano, caso o usuário tente fazer isso,
é feita uma checagem e é devolvida uma mensagem avisando que isto não é permitido, e o post não é efetivado.
<br><br>

<strong><p>Semana 2 </p></strong>
Realizar ajustes na API: para permitir a categorização de despesas, além de implementar novas funcionalidades, como a busca de receitas e despesas pela descrição. Tambem é para fazer testes automatizados. <br><br>

<strong><p>Semanas 3 e 4 </p></strong>

Adicionar segurança na API: com a implementação de um mecanismo de autenticação, além  o deploy dela em algum provedor<br><br><br>


<p align="center"><strong>O que já fiz até hoje (quase final da ultima semana):</strong></p>

Criei o projeto usando o framework <strong>Symfony</strong>, e o gerenciador Doctrine para fazer o mapeamento de objetos para o banco de dados, facilitando a conexão e consultas com o banco. Implementei as rotas, e em cada uma delas está definida qual requisição pode ser feita. <br> <br>

<p>Criei as rotas pedidas, com as regras pedidas, criei a rota onde saem as despesas categorizadas, implementei a autenticação, tem uma rota que fica escondida, que cria o usuario, depois este usuario insere o nome e senha na rota de login, e é devolvido um token, que ele insere na aba Authorization, type: Bearer Token do Postman (não testei em outro programa mas deve ser parecido com o Postman), após inserir este token ele consegue acessar as demais rotas, a rota de login é a única que não exige que este token esteja inserido.
 Está feito o deploy, agora só falta estudar melhor a parte dos testes automatizados para tentar implementa-los, por enquanto fiz os testes manualmente e e está tudo funcionando conforme o pedido.</p><br><br>

Obs: irei dar uma pausa de 1 semana neste projeto para me dedicar ao curso de tecnologo, estou em semana de provas, logo que passar a prova e eu ajeitar tudo la...volto a estudar a parte de testes automatizados e tento implementar no projeto...em seguida preciso fazer umas refatorações tambem<br><br>

<strong>Banco de dados:</strong> Criei banco de dados com 3 tabelas, uma pra armazenar as informações das despesas, outra para 
as despesas e mais uma para armazenar usuário e senha para autenticação.<br>


<strong>Criei as rotas pedidas que são estas abaixo:</strong> <br><br>
OBS: irei tentar melhorar estas urls...consequentemente deixando as rotas melhores e mais curtas...<br><br>
<strong>Rota de login</strong>: <br>
@Route("/login", name="app_login")<br>
https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/login<br>
Nesta rota o usuario insere os dados assim: <br>
pode utilizar o usuario abaixo caso queira testar: <br>
<pre>
{    
  </t>  "usuario": "usuario",<br>
  </t>  "senha" : "123456"<br>
}
</pre>
<br>
E envia um post, na resposta é retornado o token que ele irá inserir na autorização, no postman, marcar opção bearer token<br><br>
Apos inserir este token as requisicoes podem ser feitas:


<strong>Receitas</strong>: <br>
@Route("/receitas", methods={"POST"}, por enquanto está assim a rota:<br>
 <strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/receitas</strong> <br>
 Esta rota é para o usuário inserir uma receita, usando o método POST <br><br>
 <br>
 Exemplo de post em receitas:<br>
 <pre>
{    
        "descricao": "salario atualiza",
        "valor": 2400,
        "data": "08/07/2022"
}
</pre>
 
 @Route("/receitas", methods={"GET"})<br>
<strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/receitas</strong><br>
Esta rota é para o usuário buscar informações de todas receitas, usando o método GET<br><br>

@Route("/receitas/{id}", methods={"GET"}):<br>
<strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/receitas/id</strong> <br>
Esta rota é para o usuário buscar informações de uma receita, passando o seu id e usando o método GET<br><br>

@Route("/receitas/{id}", methods={"PUT"}):<br>
<strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/receitas/id</strong> <br>
Esta rota é para o usuário atualizar informações de uma receita, passando o seu id e usando o método PUT<br><br>

@Route("/receitas/{id}", methods={"DELETE"}):<br>
<strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/receitas/id</strong> <br>
Esta rota é para o usuário deletar informações de uma receita, passando o seu id e usando o método DELETE<br><br>

@Route("/receitas/descricao/{descricao}", methods={"GET"})<br>
<strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/receitas/descricao/salario</strong> <br>
Nesta rota o usuario pode buscar todas as receitas de acordo com uma descrição passada na url, e usando o GET<br><br>

@Route("/receitas/mes/{mesano}", methods={"GET"}) :<br>
<strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/receitas/mes/mm-yyyy</strong> <br>
Nesta rota o usuario pode buscar todas as receitas de um mesmo mes(no mesmo ano), e usando o GET<br><br>

<br>

<strong>Despesas</strong>: <br>
@Route("/despesas", methods={"POST"} :<br>
 <strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas</strong> <br>
 Esta rota é para o usuário inserir uma despesa, usando o método POST <br><br>
 <br>
 Exemplo de post em despesas:<br>
 <pre>
{    
        "descricao": "padaria",
        "valor": 12,
        "categoria": "alimentação",
        "data": "22/07/2022"
}
</pre>
 
 @Route("/despesas", methods={"GET"}), :<br>
<strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas</strong> <br>
Esta rota é para o usuário buscar informações de todas despesas, usando o método GET<br><br>

@Route("/despesas/{id}", methods={"GET"}),  abaixo segue um exemplo:<br>
<strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas/id</strong> <br>
Esta rota é para o usuário buscar informações de uma despesa, passando o seu id e usando o método GET<br><br>

@Route("/despesas/{id}", methods={"PUT"}),  abaixo segue um exemplo:<br>
<strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas/id</strong> <br>
Esta rota é para o usuário atualizar informações de uma despesa, passando o seu id e usando o método PUT<br><br>

@Route("/despesas/{id}", methods={"DELETE"}),  abaixo segue um exemplo:<br>
<strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas/id</strong> <br>
Esta rota é para o usuário deletar informações de uma despesa, passando o seu id e usando o método DELETE<br><br>

@Route("/despesas/descricao/{descricao}", methods={"GET"}), abaixo segue um exemplo:<br>
<strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas/descricao/papelaria</strong> <br>
Nesta rota o usuario pode buscar todas as despesas de acordo com uma descrição passada na url, e usando o GET<br><br>

@Route("/despesas/mes/{mesano}", methods={"GET"}), ficou assim localmente no meu computador:<br>
<strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/despesas/mes/mm-yyyy</strong> <br>
Nesta rota o usuario pode buscar todas as despesas de um mesmo mes(no mesmo ano), e usando o GET<br><br>


<br>


<strong>Resumo mensal</strong>: <br>
@Route("/resumo/{mesano}", methods={"GET"}<br>
 <strong>https://apicontrolefinanceiro.crismgsp.com/controlefinanceiro/public/index.php/resumo/mm-yyyy</strong> <br>
  onde mm -> mês com 2 dígitos e yyyy é ano com 2 dígitos <br>
ao acessar esta rota de resumo mensal, utilizando o GET, obtem-se um resultado assim, por exemplo:<br><br>
O valor total das receitas do mês é 2700<br>
O saldo final do mês é 1640<br>
Valor total de despesas por categoria neste mês:<br>
Categoria  alimentação   -> Valor: 325<br>
Categoria  educação   -> Valor: 125<br>
Categoria  imprevistos   -> Valor: 40<br>
Categoria  lazer   -> Valor: 540<br>
Categoria  outras   -> Valor: 30<br>



<p align="center"><strong>Ferramentas e linguagens utilizadas até agora:</strong></p>
<p><img src='src/assets/imagens/php.png' alt="simbolo PHP criado por Freepik - Flaticon"/> PHP </p>

<p><img src='src/assets/imagens/mariadb.png'alt="simbolo MariaDB"/> Banco de dados MariaDB </p>
<p><img src='src/assets/imagens/phpmyadmin.png' alt=" Imagem relacionada a PHPMyAdmin"/>PHPMyAdmin (pra acessar o MariaDB)  </p>
<p><img src='src/assets/imagens/vscode.png' alt="simbolo VSCODE"/> Visual Studio Code </p>
<p><img src='src/assets/imagens/xampp.png' alt="simbolo XAMPP"/> XAMPP <br> </p>
<p><img src='src/assets/imagens/composer.png' alt="simbolo XAMPP"/> Composer <br> </p>
<p><img src='src/assets/imagens/symfony.png' alt="simbolo XAMPP"/> Symfony <br> </p>
<p><img src='src/assets/imagens/doctrine.png' alt="simbolo XAMPP"/> Doctrine<br> </p>
<p><img src='src/assets/imagens/postman.png' alt="simbolo XAMPP"/> Postman<br> </p>







<p>Referencias das imagens para credito:</p>
PHP -> https://www.flaticon.com/br/icones-gratis/php

<br>


