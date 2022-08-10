<h1 align="center"><strong>Challenge Backend4 Alura -> </strong></h1><br>

<strong>Resumo do que foi proposto para este Chalenge:</strong><br>
<p style="color: red";>Semana 1  </p>
Implementar uma API REST: implementar nela o CRUD de receitas e de despesas, seguindo algumas validações e regras de negócio,
implementar rotas para que sejam feitas requisicções HTTP<br>

<p style="color: red";>Semana 2 </p>
Realizar ajustes na API: para permitir a categorização de despesas, além de implementar novas funcionalidades, como a busca de receitas e despesas pela descrição. Tambem é para fazer testes automatizados. <br>

<p style="color: red";>Semanas 3 e 4 </p>

Vamos adicionar segurança na API: com a implementação de um mecanismo de autenticação, além de também realizar o deploy dela em algum provedor Cloud, como o Heroku.

<p align="center"><strong>O que já fiz até hoje (meio da segunda semana):</strong></p>

<strong>Banco de dados:</strong> Criei banco de dados com 2 tabelas, uma pra armazenar as informações das despesas e outro para 
as despesas<br>

Projeto criado usando o framework Symfony, e o gerenciador Doctrine para fazer o mapeamento objetos para o banco de dados, facilitando a conexão e consultas com o banco. Implementei algumas rotas, e em cada uma delas está definida qual requisição pode ser feita. <br>
<strong>As rotas pedidas/implementadas até o momento são:<strong> <br>



<strong>Resumo mensal</strong>: <br>
@Route("/resumo/{mesano}", methods={"GET"}, ficou assim localmente no meu computador: http://localhost/controlefinanceiro/public/index.php/resumo/mm-yyyy  onde mm -> mês com 2 dígitos e yyyy é ano com 2 dígitos <br>
ao acessar rota de resumo mensal, utilizando o GET, obtem-se um resultado assim, por exemplo:<br>
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
Symfony
Doctrine





<p>Referencias das imagens para credito:</p>
PHP -> https://www.flaticon.com/br/icones-gratis/php

<br>


