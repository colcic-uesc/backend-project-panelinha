# Sistema de Gerenciamento de Professores, Estudantes, Projetos e Habilidades

Este projeto é uma API RESTful para gerenciamento de professores, estudantes, projetos e habilidades, desenvolvida em PHP utilizando o micro framework Slim.

## Funcionalidades

- CRUD de Professores
- CRUD de Estudantes
- CRUD de Projetos
- CRUD de Habilidades
- Relacionamento de habilidades a estudantes

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
   - Edite `.env` e insira as credenciais do seu banco de dados

4. Execute as migrações:
   ```
   vendor/bin/phinx migrate
   ```

## Executando o projeto

1. Inicie o servidor PHP embutido:
   ```bash
   php -S localhost:8000 -t public
   ```

2. Acesse a documentação da API:
   Abra o navegador e acesse `http://localhost:8000/swagger.html`

## Estrutura do Projeto

- `public/`: Diretório público contendo o ponto de entrada da aplicação e arquivos estáticos
- `src/`: Código-fonte da aplicação
  - `Controllers/`: Controladores da aplicação
  - `Models/`: Modelos de dados
  - `Services/`: Serviços para lógica de negócios
- `data/`: Armazenamento de dados em arquivos JSON
