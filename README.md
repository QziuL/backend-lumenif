# LumenIF API

## Sobre o Projeto

LumenIF API é o backend para uma plataforma de cursos online, desenvolvido como um projeto acadêmico. A API é responsável por gerenciar usuários, cursos, matrículas, e fornecer os dados necessários para o frontend da aplicação.

Projeto desenvolvido para a matéria de Desenvolvimento Web II, do curso de TADS.

## Tecnologias Utilizadas

- **PHP 8.2**
- **Laravel 12**
- **Laravel Sanctum:** Para autenticação de API.
- **Docker:** Para subir container do banco PostgreSQL.

## Funcionalidades Principais

A API oferece um conjunto de funcionalidades para diferentes perfis de usuários:

### Autenticação

- **Registro de Usuário:** `POST /api/register`
- **Login:** `POST /api/login`
- **Logout:** `POST /api/logout` (Requer autenticação)

### Perfil: Administrador

- **Gerenciamento de Usuários:** CRUD completo de usuários.
- **Aprovação de Cursos:** Permite aprovar ou rejeitar cursos criados pelos "Creators".
- **Visualização de Roles:** Lista os perfis de usuário disponíveis.

### Perfil: Creator (Criador de Conteúdo)

- **Gerenciamento de Cursos:** CRUD completo para cursos, módulos e aulas.
- **Dashboard de Estatísticas:** Métricas sobre o desempenho dos cursos.

### Perfil: Student (Aluno)

- **Visualização de Cursos:** Lista e visualiza os cursos disponíveis.
- **Inscrição em Cursos:** Permite que o aluno se inscreva em um curso.
- **Acompanhamento de Progresso:** Marca aulas como concluídas.

## Estrutura da API

A API está organizada da seguinte forma:

- **Controllers:** Responsáveis por receber as requisições HTTP e interagir com os Services.
- **Services:** Contêm a lógica de negócio da aplicação.
- **DTOs (Data Transfer Objects):** Utilizados para transferir dados entre as camadas da aplicação de forma estruturada.
- **Resources:** Transformam os models em respostas JSON.
- **Models:** Representam as tabelas do banco de dados.
- **Middleware:** Utilizado para controle de acesso baseado em perfis (Roles).

## Como Executar o Projeto

1. **Clone o repositório:**
   ```bash
   git clone <url-do-repositorio>
   ```
2. **Instale as dependências:**
   ```bash
   composer install
   ```
3. **Configure o ambiente:**
   - Copie o arquivo `.env.example` para `.env`.
   - Gere a chave da aplicação: `php artisan key:generate`


4. **Configure o arquivo Docker no diretorio `/docker`: `docker-compose.yml`**


5. **Execute as migrações e seeders:**
   ```bash
   php artisan migrate --seed
   ```
6. **Inicie o servidor de desenvolvimento:**
   ```bash
   php artisan serve
   ```

A API estará disponível em `http://localhost:8000`.
