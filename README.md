# 🚀 Fullstack Test - Laravel + Vue + Docker

## 📌 Objetivo

Este projeto tem como objetivo demonstrar a construção de uma aplicação Full Stack com separação entre Back-End e Front-End, integração com autenticação via Google (OAuth) e boas práticas de desenvolvimento.

A aplicação permite:
- Login com Google
- Cadastro complementar de usuário
- Listagem de usuários
- Filtro por nome e CPF
- Envio de e-mail de confirmação

---

## 🧰 Tecnologias Utilizadas

### Back-End
- PHP 8.x
- Laravel 13
- MySQL 8
- Arquitetura em camadas (Controller, Service, Repository)
- Laravel Queue

### Front-End
- Vue 3
- TypeScript
- Vite
- Vue Router
- Pinia (state management)
- Sass

### Infraestrutura
- Docker
- Docker Compose

---

## 🏗️ Estrutura do Projeto
```
.
├── api/ # Laravel (Back-end)
├── api/docker/ # Automatização para queue e migrations
├── web/ # Vue (Front-end)
├── docker-compose.yml # Docker
├── .github/ # Pipeline CI/CD
└── README.md # Documentação
```

## 🏛️ Arquitetura

- API Laravel desacoplada do frontend Vue
- Arquitetura em camadas:
  - Controller → entrada da requisição
  - Service → regra de negócio
  - Repository → acesso ao banco
- Frontend consome API via HTTP
- Autenticação via OAuth Google
- Processamento assíncrono com fila

## Fluxo principal

1. Front solicita URL do Google para API
2. Usuário autentica no Google
3. Google redireciona para callback da API
4. API salva token do Google
5. Usuário completa cadastro
6. API recupera e-mail via token salvo
7. API envia e-mail por fila
8. Front lista usuários com filtros
---

## Variáveis de ambiente

### Copiar .env.example da API para .env
Preencher Dados :

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=""
MAIL_FROM_ADDRESS=

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=

### Copiar .env.example da WEB para .env
Preencher Dados :

VITE_GOOGLE_CLIENT_ID

---

## ⚙️ Como rodar o projeto

### 🔧 Pré-requisitos

- Docker Desktop instalado

---

### ▶️ Subir a aplicação

Na raiz do projeto:

```sh
docker compose up -d --build
```

### 📊 Após subida dos containers observar subida do laravel e migrations até finalizar
```sh
docker compose logs -f api 
```

## 🌐 Acessos
### API Laravel:
```
http://localhost:8000
http://localhost:8000/ping
```

### Front-end Vue:
```
http://localhost:5173
```

---

### Banco MySQL:
```
Host: localhost
Port: 3306
Database: tray_test
User: root
Password: root
```

### Teste de volumetria:
Aumentar a quantidade conforme teste no arquivo UserSeeder.php
```
docker compose exec api php artisan db:seed --class=UserSeeder
```
---

### 🧹 Limpar ambiente

Remove containers, volumes e dados:

docker compose down -v
⛔ Parar aplicação
```
docker compose down
```
🔄 Reiniciar aplicação
```
docker compose down

docker compose up -d --build
```

---

## 📊 Logs

### Ver logs de todos os serviços:

```
docker compose logs -f
```

Ver logs apenas da API:
```
docker compose logs -f api
```

Ver logs apenas da fila:
```
docker compose logs -f tray_queue
```

---

## 🔌 Endpoints da API

### OAuth Google
```
POST /auth/google/url
```
- Retorna URL para autenticação no Google
```
GET /auth/google/callback
```
- Recebe o código do Google
- Salva token e cria/atualiza usuário

### Usuários
```
POST /users/complete-registration
```
- Completa cadastro do usuário

GET /users
- Lista usuários
- Query params:
  - name
  - cpf
  - page
  - per_page

---

## 🧠 Gerenciamento de Estado (Pinia)

O Pinia é utilizado para centralizar o estado da listagem de usuários, incluindo:
- Lista de usuários
- Paginação
- Estado de carregamento
- Tratamento de erros

A store `userStore` é responsável por consumir a API e fornecer os dados para os componentes.

---

## 📬 Processamento Assíncrono (Queue)

O envio de e-mail é realizado de forma assíncrona utilizando Laravel Queue.

Fluxo:
1. Usuário finaliza cadastro
2. API dispara um Job
3. Job é processado pelo worker
4. E-mail é enviado

Isso evita bloqueio da requisição e melhora performance.

---

## Testes da API
```
docker compose exec api php artisan test
```

### Testes do frontend
```
docker compose exec web npm run test
```

### Qualidade da API
```
composer quality
```

### Qualidade do frontend
```
npm run quality
```

## Decisões técnicas
- paginação no backend
- filtro por nome e CPF
- ordenação no backend
- fila para envio de e-mail
- índices para melhorar busca
- estratégia pensada para volume alto

## Melhorias futuras
- cobertura maior de testes
- autenticação própria
- ordenações adicionais
- paginação mais avançada


## 🛠️ Problemas comuns

### E-mail não enviado
- Verifique credenciais SMTP
- Verifique se a queue está rodando

### API não conecta no banco
- Verifique se o container MySQL está pronto
- Rode novamente: docker compose up -d --build

## 👨‍💻 Autor
Fernando Humel Procopio
