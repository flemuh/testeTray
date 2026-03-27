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
├── web/ # Vue (Front-end)
├── docker-compose.yml
└── README.md
```
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

### 📊 observar subida do laravel e migrations
```sh
docker compose logs -f api 
```

## 🌐 Acessos
### API Laravel:
```
http://localhost:8000
```

### Front-end Vue:
```
http://localhost:5173
```

Banco MySQL:
```
Host: 127.0.0.1
Port: 3306
Database: tray_test
User: tray_user
Password: tray_pass
```

#### Rodar migrations manualmente (se necessário)
```
docker compose exec api php artisan migrate
```
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


## 🧠 Decisões Técnicas
- Uso de Docker para padronização do ambiente
- Separação clara entre front e back
- Uso de migrations para controle do banco
- Estrutura preparada para escalabilidade (microserviços / mensageria futura)
- Validações no front e back
- Código organizado seguindo boas práticas

## 🚀 Próximos passos (melhorias)
- Implementação de testes automatizados
- Fila para envio de e-mails (queue)
- Autenticação completa com Google OAuth
- Paginação e otimizações para grande volume de dados
- Melhorias de UX/UI

## 👨‍💻 Autor
Fernando Humel Procopio
