<h1 align="center"><strong>Challenge Backend4 Alura -> </strong></h1><br>

<strong>Resumo do que foi proposto para este Chalenge:</strong><br>
<p style="color: red";>Semana 1  </p>
Implementar uma API REST: implementar nela o CRUD de receitas e de despesas, seguindo algumas validações e regras de negócio,
implementar rotas para que sejam feitas requisicções HTTP, usar o Postman para testar estas requisições<br>

<p style="color: red";>Semana 2 </p>
Realizar ajustes na API: para permitir a categorização de despesas, além de implementar novas funcionalidades, como a busca de receitas e despesas pela descrição. Tambem é para fazer testes automatizados. <br>

<p style="color: red";>Semanas 3 e 4 </p>

Vamos adicionar segurança na API: com a implementação de um mecanismo de autenticação, além de também realizar o deploy dela em algum provedor Cloud, como o Heroku.

<p align="center"><strong>O que já fiz até hoje (meio da terceira semana):</strong></p>

<p>Coloquei o projeto online, mas ainda falta implantar o mecanismo de autenticação, estou estudando sobre isto no momento... a parte de teste automatizado (que era pra ter feito na segunda semana) preciso estudar mais..assisti um dos cursos sugeridos e comecei a tentar fazer mas ainda estou achando um pouco dificil até o momento... irei estudar para começar a fazer a autenticação primeiro e atualizar o deploy...depois atualizo as rotas de acesso aqui  e deixarei a parte de testes automatizados por ultimo
pois precisarei fazer mais cursos para assimilar melhor sobre isto</p>

<strong>Banco de dados:</strong> Criei banco de dados com 2 tabelas, uma pra armazenar as informações das despesas e outro para 
as despesas<br>

Projeto criado usando o framework <strong>Symfony</strong>, e o gerenciador Doctrine para fazer o mapeamento de objetos para o banco de dados, facilitando a conexão e consultas com o banco. Implementei algumas rotas, e em cada uma delas está definida qual requisição pode ser feita. <br> <br>
<strong>As rotas pedidas/implementadas até o momento são:</strong> <br><br>

<strong>Receitas</strong>: <br>
@Route("/receitas", methods={"POST"}, ficou assim localmente no meu computador:<br>
 http://localhost/controlefinanceiro/public/index.php/receitas <br>
 Esta rota é para o usuário inserir uma receita, usando o método POST <br><br>
 <br>
 
 @Route("/receitas", methods={"GET"}), ficou assim localmente no meu computador:<br>
http://localhost/controlefinanceiro/public/index.php/receitas <br>
Esta rota é para o usuário buscar informações de todas receitas, usando o método GET<br><br>

@Route("/receitas/{id}", methods={"GET"}), ficou assim localmente no meu computador:<br>
http://localhost/controlefinanceiro/public/index.php/receitas/id <br>
Esta rota é para o usuário buscar informações de uma receita, passando o seu id e usando o método GET<br><br>

@Route("/receitas/descricao/{descricao}", methods={"GET"}), ficou assim localmente no meu computador,vou deixar um exemplo:<br>
http://localhost/controlefinanceiro/public/index.php/receitas/descricao/salario <br>
Nesta rota o usuario pode buscar todas as receitas de acordo com uma descrição passada na url, e usando o GET<br><br>

@Route("/receitas/mes/{mesano}", methods={"GET"}), ficou assim localmente no meu computador:<br>
http://localhost/controlefinanceiro/public/index.php/receitas/mes/mm-yyyy <br>
Nesta rota o usuario pode buscar todas as receitas de um mesmo mes(no mesmo ano), e usando o GET<br><br>

<br>

<strong>Despesas</strong>: <br>
@Route("/despesas", methods={"POST"}, ficou assim localmente no meu computador:<br>
 http://localhost/controlefinanceiro/public/index.php/despesas <br>
 Esta rota é para o usuário inserir uma despesa, usando o método POST <br><br>
 <br>
 
 @Route("/despesas", methods={"GET"}), ficou assim localmente no meu computador:<br>
http://localhost/controlefinanceiro/public/index.php/despesas <br>
Esta rota é para o usuário buscar informações de todas despesas, usando o método GET<br><br>

@Route("/despesas/{id}", methods={"GET"}), ficou assim localmente no meu computador, vou deixar um exemplo:<br>
http://localhost/controlefinanceiro/public/index.php/despesas/1 <br>
Esta rota é para o usuário buscar informações de uma despesa, passando o seu id e usando o método GET<br><br>

@Route("/despesas/descricao/{descricao}", methods={"GET"}), ficou assim localmente no meu computador,vou deixar um exemplo:<br>
http://localhost/controlefinanceiro/public/index.php/despesas/descricao/supermercado <br>
Nesta rota o usuario pode buscar todas as despesas de acordo com uma descrição passada na url, e usando o GET<br><br>

@Route("/despesas/mes/{mesano}", methods={"GET"}), ficou assim localmente no meu computador:<br>
http://localhost/controlefinanceiro/public/index.php/despesas/mes/mm-yyyy <br>
Nesta rota o usuario pode buscar todas as despesas de um mesmo mes(no mesmo ano), e usando o GET<br><br>


<br>


<strong>Resumo mensal</strong>: <br>
@Route("/resumo/{mesano}", methods={"GET"}, ficou assim localmente no meu computador:<br>
 http://localhost/controlefinanceiro/public/index.php/resumo/mm-yyyy <br>
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


