# Sistema de Gerenciamento de Professores, Estudantes, Projetos e Habilidades

Este projeto é uma API RESTful para gerenciamento de professores, estudantes, projetos e habilidades, desenvolvida em PHP utilizando o micro framework Slim.

## Funcionalidades

- CRUD de Professores
- CRUD de Estudantes
- CRUD de Projetos
- CRUD de Habilidades
- Relacionamento de habilidades a estudantes
- Autenticação JWT para usuários
- Sistema de logs de requisições
- Headers personalizados
- Documentação da API com Swagger
- Autenticação JWT global para todas as rotas

## Requisitos

- PHP 8.0 ou superior
- Composer
- MySQL 5.7 ou superior

## Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/colcic-uesc/backend-project-panelinha.git
   cd backend-project-panelinha
   ```

2. Instale as dependências:
   ```bash
   composer install
   ```

3. Configure o banco de dados:
   - Crie um banco de dados MySQL
   - Copie o arquivo `.env.example` para `.env`
   - Edite `.env` e insira as credenciais do seu banco de dados e a chave JWT:

4. Execute as migrações:
   ```bash
   vendor/bin/phinx migrate
   ```

5. Crie o diretório de logs e configure as permissões:
   ```bash
   mkdir logs
   chmod 777 logs
   ```

## Executando o projeto

1. Inicie o servidor PHP embutido:
   ```bash
   php -S localhost:8000 -t public
   ```

2. Acesse a documentação da API:
   Abra o navegador e acesse `http://localhost:8000/swagger.html`

## Autenticação

A API utiliza autenticação JWT para proteger os endpoints. Para acessar as rotas protegidas:

1. Faça login através do endpoint `/auth/login` com o método POST, utilizando curl ou postman, com os seguintes campos:
   - username (nome de usuário para login)
   - password (senha do usuário)

   Usuário padrão:
   - username: admin
   - password: admin

2. O token JWT retornado deve ser incluído no header `Authorization` das requisições:
   ```
   Authorization: Bearer {seu_token_aqui}
   ```

## Sistema de Logs

O sistema registra automaticamente as seguintes informações para cada requisição:
- IP do cliente
- Presença de token JWT
- Data e hora da requisição
- Método e URL da requisição
- Tempo total de processamento

Os logs são salvos em `logs/api.log`

## Headers Personalizados

Todas as respostas da API incluem os seguintes headers:
- `X-APP-NAME: Panelinha`
- `X-APP-API-VERSION: 0.1`

## Estrutura do Projeto

- `public/`: Diretório público contendo o ponto de entrada da aplicação e arquivos estáticos
- `src/`: Código-fonte da aplicação
  - `Controllers/`: Controladores da aplicação
  - `Models/`: Modelos de dados
  - `Services/`: Serviços para lógica de negócios
  - `Middleware/`: Middlewares da aplicação
  - `Auth/`: Classes relacionadas à autenticação
- `logs/`: Armazenamento dos logs da aplicação
- `db/migrations/`: Migrações do banco de dados