Cadastro de Pessoas e Endereços

Este projeto é uma aplicação web para o cadastro de pessoas e seus respectivos endereços. A aplicação foi desenvolvida utilizando Laravel para o backend, que expõe uma API RESTful, e Vue.js para o frontend. O projeto inclui funcionalidades para gerenciar pessoas e endereços.

Tecnologias Utilizadas: 
- Backend: Laravel (API RESTful)
    - Documentação da API configurada com Swagger
    - Testes realizados com Postman

- Frontend: Vue.js
    - Vuetify: Para o design e componentes da interface do usuário
    - Service Layer: Todas as requisições à API foram centralizadas na camada de serviços, mantendo os componentes limpos e fáceis de manter

- Banco de Dados: MySQL
    - Relacionamento entre as tabelas Pessoas e Endereços

Funcionalidades Implementadas
- Cadastro de Pessoas:
    - Formulário para o cadastro de pessoas, capturando informações como nome, CPF, telefone, e-mail, entre outros.
    - Após o cadastro da pessoa, o sistema habilita a opção para adicionar endereços (residencial e comercial).

- Cadastro de Endereços:
    - Somente após o cadastro da pessoa, o endereço pode ser adicionado.
    - Formulário para cadastro de endereço com preenchimento automático dos campos baseado no CEP, utilizando uma API externa.

- Busca e Listagem:
    - Página inicial com dois campos de busca: por nome e CPF.
    - Listagem de pessoas cadastradas, com possibilidade de visualizar detalhes, editar ou excluir.

- Detalhes, Edição e Exclusão:
    - Visualização dos detalhes de uma pessoa e seus endereços.
    - Funcionalidade para editar ou excluir registros.

Estrutura do Projeto
- Backend (Laravel):
    - Implementação da API RESTful.
    - Configuração do Swagger para documentação da API.
    - Configuração do banco de dados MySQL com relacionamentos entre tabelas.

- Frontend (Vue.js):
    - Componentes Vue organizados para criar a interface do usuário.
    - Camada de serviços para todas as requisições à API, mantendo a lógica desacoplada dos componentes.
    - Uso do Vuetify para estilização e layout responsivo.

Como Executar o Projeto:
- Backend (Laravel)
    - Clone o repositório.
    - Execute composer install para instalar as dependências.
    - Configure o arquivo .env com as credenciais do banco de dados MySQL.
    - Execute as migrações com php artisan migrate.
    - Inicie o servidor com php artisan serve.
    - Acesse o Swagger para documentação da API em /api/documentation.

- Frontend (Vue.js)
    - Dentro da pasta frontend, execute npm install para instalar as dependências.
    - Inicie o servidor de desenvolvimento com npm run serve.

- Banco de Dados
    - Certifique-se de que o MySQL esteja configurado e rodando. As tabelas são criadas automaticamente com as migrações do Laravel.

Funcionalidades Faltantes
-Embora a aplicação esteja funcional, algumas funcionalidades ainda não foram implementadas ou concluídas:
- Melhorias na busca e filtros avançados.
- Validação de CPF e outros campos de forma mais robusta.
- Implementação de autenticação e autorização de usuários.

Conclusão:

Este projeto serve como um exemplo básico de como construir uma aplicação full stack utilizando Laravel e Vue.js. Ele abrange desde a configuração da API até a criação de uma interface de usuário interativa e responsiva. Faltam algumas funcionalidades que podem ser implementadas em iterações futuras.