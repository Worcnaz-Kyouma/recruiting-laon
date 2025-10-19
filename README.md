<p align="center"><img src="https://raw.githubusercontent.com/Nicolas-Prado/recruiting-laon/main/laon-streaming.png" width="30%" height="20%"></p>

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

Alem disto, os dados de filmes e séries da aplicação vem da "The Movie DB API", para mais informações acesse: https://www.themoviedb.org/

## Requisitos
recruiting-laon-frontend:
- npm: 10.9^
- node: 22.14^

recruiting-laon-backend:
- PHP: 8.4^
- Composer: 2.8.12
- MySQL: 8

## Como rodar

Baixe o arquivo ZIP do projeto e descompacte-o onde preferir.

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

## Descrição da solução

Com base nos requisitos, decidi que seria interessante lidar com informações reais, consultando algumas fontes descobri o The Movie Database.
Ele é bem simples, e fornece uma API para filmes e séries.

Construi minha aplicação em cima destes dados, contando com:
- Os filmes/séries mais populares do més
- Busca de mídias por popularidade, trending


Esperamos que nosso sistema possa auxiliá-los. Muito obrigado pela oportunidade!

## Manual
Abaixo, descrevo uma breve instrução sobre como usar a aplicação e suas funcionalidades:

## Tela Inicial
Login:
- Acessar com um usuário já existente, inserindo seu nome de usuário e senha.

Sign Up:
- Criar um novo usuário para efetuar o login no sistema.

## Tela Principal

Header:
- No canto superior esquerdo, há um botão escrito "Sair" para efetuar o logout do usuário.
- No canto superior direito, encontra-se um pequeno círculo com a imagem do usuário logado. Ao clicar neste círculo:
  - Você será redirecionado para uma tela de perfil do usuário, onde é possível visualizar e editar seus dados.

## Corpo Central
No centro, a aplicação informará caso o usuário logado não esteja em nenhum grupo. Além disso, nesta seção os times serão exibidos. Inicialmente, todos os times estarão minimizados.

Botão Inferior Esquerdo:
- Este botão é o gerador de times. Ao clicar nele, você poderá criar quantos times desejar para o usuário logado.

Times:
- Na parte superior direita de cada grupo, haverão opções "Sair" do time ou "Excluir" o time (É importante observar que apenas os usuários com leveis mais altos no time podem excluí-lo).
- Na parte superior esquerda de cada grupo, há o nome do time. Se o usuário logado for capaz, mediante a seu level no time, poderá clicar no nome do time e altera-lo livremente. (Vale notar que o nome de cada time deve ser unico)
- Na seção de time minimizado, existe uma pequena seta que, ao ser clicada, expandirá o grupo.
- Com o grupo expandido, todos os usuários pertencentes ao grupo serão exibidos, cada um no segmento correspondente ao seu level no time.
- Ao clicar em um usuário, todas as suas informações serão mostradas. Se o level do seu usuário logado atender a certos requisitos (detalhados na seção de "Level" do manual, logo abaixo), você poderá remover o usuário do grupo ou aumentar o level dele.
- Clicando em seu usuário no time, é possível aumentar o seu próprio nível, caso tenha capacidade para fazê-lo.
- Na parte inferior da seção do time expandido, acima do ícone de expandir/contrair o grupo, existe um botão para adicionar novos membros ao grupo. Ao clicar nele, o "Buscador de Usuários" será aberto.

Level:
- Cada usuário possui um level em cada grupo ao qual pertence. Com base nesse número, algumas permissões especiais serão concedidas.
- Se o level do seu usuário logado for igual ao level mais alto do grupo, ele pode excluí-lo e aumentar/diminuir o level de outros usuários, podendo até mesmo removê-los.
- Usuários com leveis mais baixos do que o usuário logado podem ser removidos, e também é possível aumentar ou diminuir o level deles. O limite é o próprio level do usuário no grupo (a menos que a observação anterior seja aplicável; nesse caso, você pode alterar o level do usuário indefinidamente, com o limite no level 1).

Buscador de Usuários:
- Nessa tela destinada a buscar novos usuários, você pode realizar a busca com base no "Nome, Email e Telefone". Ao clicar em "Buscar", os usuários correspondentes serão exibidos de forma paginada.
- Ao clicar em um usuário encontrado, ele será adicionado ao grupo.

# Documentação Back-end
- Vale dizer que todas as consultas são feitas na root(ou seja, protocol://localhost:port/{URI}) precedidas pela fragment da entity relativa ao recurso.
## User Entity(/users)
### GET:
- Descrição: Consultar usuarios por nome 
- URI: /username/:username
- URL Params: :username
- Query Params: N/A
- Body Content: N/A

### POST:
- Descrição: Cadastrar usuario 
- URI: /
- URL Params: N/A
- Query Params: N/A
- Body Content:
```
{
  username: 'JohnDoe',
  password: '123',
  name: 'John Doe',
  email: 'JohnDoe@gmail.com',
  phone: '(42) 99999-9999',
  bornDate: '2004-12-28'
}
```

### PUT:
- Descrição: Atualizar usuario 
- URI: /
- URL Params: N/A
- Query Params: N/A
- Body Content:
```
{
  username: 'JaneDoe',
  name: 'Jane Doe',
  email: 'janedoe@gmail.com',
  phone: '(42) 99999-9999'
}
```

## Team Entity(/teams)
### POST
- Descrição: Cadastrar time 
- URI: /
- URL Params: N/A
- Query Params: N/A
- Body Content:
```
{
  userId: 1,
  teamName: "nome"
}
```

### PUT
- Descrição: Atualizar time 
- URI: /:teamId
- URL Params: :teamId
- Query Params: N/A
- Body Content:
```
{
  teamName: "Novo nome"
}
```

### DELETE
- Descrição: Deletar time 
- URI: /:teamId
- URL Params: :teamId
- Query Params: N/A
- Body Content: N/A

## User Team Entity(/usersteams)
### GET
- Descrição: Consulta um time junto de seus usuarios, com seus respectivos niveis 
- URI: /:teamId
- URL Params: :teamId
- Query Params: N/A
- Body Content: N/A

### POST
- Descrição: Cadastrar usuario em um time, com seu devido level neste time 
- URI: /
- URL Params: N/A
- Query Params: N/A
- Body Content:
```
{
  userId: 1,
  teamId: 1,
  level: 1
}
```

### PATCH
- Descrição: Atualizar level de um usuario em um time
- URI: /
- URL Params: N/A
- Query Params: N/A
- Body Content:
```
{
  userId: 1,
  teamId: 1,
  level: 2
}
```

### DELETE
- Descrição: Remove um usuario de um time
- URI: /
- URL Params: N/A
- Query Params: N/A
- Body Content:
```
{
  userId: 1,
  teamId: 1
}
```
