<p align="center"><img src="https://github.com/Worcnaz-Kyouma/recruiting-laon/blob/main/laon-streaming.png?raw=true" width="30%" height="20%"></p>

## Proposta do projeto
O objetivo é criar um catálogo de filmes (e possivelmente séries). 

O usuário poderá se cadastrar na plataforma utilizando nome, email, senha (e quaisquer outros dados que julgar importante). 

Para visualizar o catálogo, é necessário efetuar o login com credenciais válidas e ativas. Ao entrar, o usuário será recebido com a listagem de títulos disponíveis e ativos na plataforma. Ao clicar em algum deles, o usuário será redirecionado para uma tela com os detalhes do título escolhido. 

Seja criativo! Adicione quaisquer informações ou funcionalidades que julgar importante pro bom funcionamento da plataforma.

## Sobre a implementação

O sistema foi implementado em 2 partes: 

recruiting-laon-frontend
- Linguagem: Typescript
- Framework: NextJS 15
- Gerenciador de pacotes: npm
- Estilização: 
    - Tailwind
    - Material UI
    - Phospor Icons
- Gerenciador de state: Zustand
- Avisos Temporarios: Toast
- Utilitarios:
    - Plop: Criação de componentes via CLI

recruiting-laon-backend
- Linguagem: PHP 8.4
- Framework: Laravel 15
- Gerenciador de pacotes: composer
- Arquitetura de inspiração: REST
- Auth: Sanctum
- Cache: Database
- Database: MySQL 8 com Migrations(Laravel)

Alem disto, os dados de filmes e séries da aplicação vem da "The Movie DB API", para mais informações acesse: <b><a>https://www.themoviedb.org</a></b>

## Requisitos
recruiting-laon-frontend:
- npm: 10.9^
- node: 22.14^

recruiting-laon-backend:
- PHP: 8.4^
- Composer: 2.8.12
- MySQL: 8

## Como rodar

Clone o projeto com o comando "git clone <web URL>" ou baixe o arquivo ZIP do projeto e descompacte-o onde preferir.

Execute estes passos para as 2 partes da aplicação:

Front-end:
- Abra um terminal dentro da pasta "recruiting-laon-frontend", instale as dependências do Node presentes no arquivo "package.json" executando o comando: "npm i".
- Após instalar as dependências no passo anterior, execute o comando "npm run build" no mesmo diretório para construir a aplicação.
- Ao finalizar os passos anteriores, execute o comando "npm run start".
- A aplicação estará rodando na URL: <b><a>http://localhost:3000</a></b>

Back-end:
- Abra um outro terminal(diferente do anterior que esta rodando o client) dentro da pasta "recruiting-laon-backend", instale as dependências executando o comando: "composer install".
- Duplique o arquivo ".env.example", e mude o nome da duplicata para ".env".
- Preencha os seguintes valores do env:
    - DB_PASSWORD: Senha do usuario do seu MySQL local.
    - TMDB_API_KEY: Chave da api do TMDB(para testar o projeto, pode utilizar minha key que esta no final deste README).
- Depois disto, geramos a app key: "php artisan key:generate".
- Finalizando o env, vamos criar o banco de dados, execute o comando: "php artisan db:create".
- Agora construa o banco com as migrations, execute o comando "php artisan migrate".
- Por fim, inicie a API, execute o comando "php artisan serve".
- A API estará rodando na URL: <b><a>http://localhost:8000/api</a></b>

## Deploy
Esta aplicação esta hospedada na internet! Você pode acessa-la agora mesmo no link <b><a>https://recruiting-laon-34sfe9ux6-nicolasprados-projects.vercel.app</a></b>
A via de de informação, a url do backend é: <b><a>https://recruiting-laon-production.up.railway.app/api</a></b>

A hospedagem esta divida entre dois provedores:
- Vercel: NextJS frontend
- Railway: 
    - Laravel 12 backend
    - MySQL 8 database

## Descrição da solução

Com base nos requisitos, decidi que seria interessante lidar com informações reais, consultando algumas fontes descobri o The Movie Database.
Ele é bem simples, e fornece uma API para filmes e séries.

Construi minha aplicação em cima destes dados, por fim, estes foram os resultados:
- Home com os filmes/séries mais populares do més.
- Busca de mídias por popularidade, trending e mais.
- Busca de mídias por titulo.
- Detalhes das mídias. Ao clicar em um card de mídia, será redirecionado aos seus detalhes, sendo que algumas(quando existentes na API) são em português.
- Reprodução de trailers nos detalhes das mídias.
- Cadastro de usuario e login.
- Criação de listas de mídia(como playlists do spotify), e a gerencia delas.

Alem disto, vale dizer que alguns requisitos não funcionais tambem foram implementados, como cache na consulta da API externa para agilizar a comunicação e aprimorar a performace do catalogo.

Para mais informações, entre na pasta docs deste repositorio, nela você encontrará:
- Diagrama relacional do banco 
- Collection dos endpoints da API em formato JSON para importar no Insomnia/Postman ou qualquer outro cliente http que suporte este formato da collection.

## Manual
Abaixo, descrevo uma breve instrução sobre como usar a aplicação e suas funcionalidades:

### Home Page
Aqui os filmes/séries mais populares são listados ao usuario.
- Pode-se consultar mais mídias clicando na flecha a direta no tipo de mídia(Filmes ou Seríes) que desejar.
- Na parte superior, clicando em "ENTRAR" você pode criar sua conta no sistema para ter acesso a todos os recursos dele.

### Registro de Usuário
O cadastro de usuario consiste em:
- Nickname (não pode ter mais de 50 caracteres)
- Email
- Senha (deve ter no minimo 8 caracteres)
- Senha repetida (para assegurar que a senha esta correta)
O login tambem pode ser efetuado nesta tela, navegando pelo cabeçario da pagina(ENTRAR / CADASTRAR).

### Listagem de mídias
Na home page, ao clicar na flechinha a direita no catalogo, você será levado para o listador de mídia(se clicou na flecha de baixo, nas séries, irá consultar somente seríes, o mesmo para a flecha de cima pros filmes)
- Pode-se listar mídias de duas formas, titulos similares ou metodos de consulta.
    - Os metodos de consulta são apresentados por meio de um campo de seleção a esquerda da tela
    - O titulo pode ser inserido no campo de texto central, e então clique no botão buscar para trazer as mídias.
    - OBS: A busca por titulo é aproximada, então colocando um nome parecido, ou ate mesmo em portugues, funcionará
- A consulta é paginada e limitada a 500 paginas.

### Detalhes da mídia
Ao clicar em uma mídia, você será redirecionado para seus detalhes. Aos quais contem:
- Titulo.
- Titulo em português.
- Trailer.
- Sinopse.
- Atores.
- e ate mesmo os posteres das temporadas(caso a mídia em questão seja uma seríe).

### Gerencia de listas
O sistema conta com algo chamado "Listas de Mídias", como playlists do spotify!
Você pode criar uma lista do que quiser, com quantas mídias desejar.

Ao passar o mouse por cima de um card de mídia um checkbox a direita aparece. Selecionando ele, tres botões serão apresentados na parte inferior da tela
- Limpar Seleção
- Adicionar a lista
- Criar lista

Para consultar suas listas, na parte superior do sistema, ao lado do demonstrativo do seu usuario, um botão "MINHAS LISTAS"
- É identica a tela da home, mas com suas listas!
- A direita de cada lista, clicando na flecha você pode ver os detalhes da lista.
- Vale dizer, se deseja remover alguma mídia da sua lista, va ate detalhes dela, selecione as que deseja remover e clique no botão "REMOVER DA LISTA" na parte inferior da tela.

## Endpoints
- BaseUrl: https://domain/api

### welcome
- Rota: /
- Descrição: Boas vindas amigavel a aplicação

### user-create
- Rota: /user
- Método: POST
- Descrição: Cria um novo usuário com nome, e-mail e senha.

### user-login
- Rota: /user/login
- Método: POST
- Descrição: Realiza o login de um usuário existente e retorna o token de autenticação.

### user-logout
- Rota: /user/logout/{id}
- Método: POST
- Descrição: Encerra a sessão do usuário e invalida o token de autenticação.

### top-popular
- Rota: /media/list/{id}?page={n}
- Método: GET
- Descrição: Retorna os detalhes de uma lista de mídias específica, incluindo suas mídias associadas.

### listing-methods
- Rota: /media/listing-method/{tipo}
- Método: GET
- Descrição: Retorna os métodos de listagem disponíveis para um determinado tipo de mídia (por exemplo, filmes ou séries).

Entre outros...
Para mais informações, importe a Collection da API para o Postman/Insomnia, inspirado na arquitetura REST, procurei deixar as rotas bem semanticas, então seu nome basicamente descreve sua função
